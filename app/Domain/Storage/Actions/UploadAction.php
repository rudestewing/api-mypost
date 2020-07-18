<?php
namespace App\Domain\Storage\Actions;

use App\File;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Storage\UploadRequest;

class UploadAction
{
    public function excute(UploadRequest $request)
    {
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
                    'path',
                    'url',
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
                    'size' => $size,
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