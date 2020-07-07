<?php

namespace App\Http\Controllers\Api\Storage;

use App\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    protected $types = [
        'image' => [
            'max' => 1500,
            'allowedMimes' => ['jpeg', 'jpg', 'png'],
        ],
        'document' => [
            'max' => 1500,
            'allowedMimes' => ['pdf'],
        ],
        'audio' => [
            'max' => 1500,
            'allowedMimes' => ['mp3', 'ogg'],
        ],
    ];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $allowedTypes = implode(',', array_keys($this->types));
        
        $request->validate([
            'type' => "required|string|in:{$allowedTypes}"
        ]);
            
        $allowedMimes = implode(',', $this->types[$request->type]['allowedMimes']);
        $allowedMaxSize = $this->types[$request->type]['max'];

        $request->validate([
            'file' => "required|max:{$allowedMaxSize}|mimes:{$allowedMimes}",
        ]);

        $path = $this->generatePath($request);
        $content = file_get_contents($request->file);

        try {
            Storage::disk('local')->put($path, $content);

            $file = File::create([
                'type' => $request->type,
                'path' => $path,
            ]);

            if($request->type == 'image') {
                $this->processResizeImage($file);
            }
            
            return response()->json([
                'data' => $file->only([
                    'url',
                    'type',
                    'id'
                ])
            ], Response::HTTP_CREATED);
            
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    private function generatePath($request, $count = 0)
    {
        $ext = $request->file('file')->getClientOriginalExtension();

        $fileName = str_shuffle(str_shuffle(Str::random(32).time()).$count).'.'.$ext;
        $storePath = $request->custom_path ? $request->custom_path.'/' : '';
        
        $path = $storePath.$fileName;

        return !$this->checkAvailability($path) ?
            $this->generatePath($request, $count+1) :
            $path;
    }

    private function checkAvailability($path) 
    {
        return Storage::disk('local')->exists($path) ? false : true;
    }


    private function processFile()
    {

    }

    private function processResizeImage(File $file): void
    {
        $dimensions = [
            'xs' => 80, 
            'sm' => 120, 
            'md' => 200, 
            'lg' => 500
        ];

        foreach ($dimensions as $size => $height) {
            $realPath = storage_path('app/'.$file->path);
            $img = Image::make($realPath);
            
            $img->resize(null, $height, function($constraint) {
                $constraint->aspectRatio(); 
            });

            $resizedFile = $img->stream('jpg');
            $path = "{$size}/{$file->path}";

            if(Storage::disk('local')->put($path, $resizedFile)) {
                $file->fileResizes()->create([
                    'dimensions' => $size,
                    'path' => $path
                ]);
            }
        }
    }

    private function processDocument($request)
    {

    }

    private function processAudio($request)
    {

    }
}
