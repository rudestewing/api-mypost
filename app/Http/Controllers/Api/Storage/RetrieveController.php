<?php

namespace App\Http\Controllers\Api\Storage;

use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class RetrieveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id = null)
    {
        if(!$id) {
            return response()->json([
                'message' => 'file not found'
            ], 404);
        }
        
        $accessId = Cache::get($request->access_id);
        
        if(!$accessId) {
            return response()->json([
                'message' => 'unauthorized'
            ], 404);
        }

        $request->validate([
            'dimensions' => 'nullable|in:xs,sm,md,lg'
        ]);

        $file = File::find($id);
        if(!$file) {
            return response()->json([], 404);
        }

        if($request->dimensions) {
            $spesificSize = $file->fileResizes()->where('dimensions', $request->dimensions)->first();
            return $this->render($spesificSize->path);
        }

        return $this->render($file->path);
    }


    private function render($path)
    {
        if(!Storage::disk('local')->exists($path)) {
            return response()->json([], 404);
        }

        $realPath = storage_path("app/{$path}"); // local storage

        $response = Response::make(FacadesFile::get($realPath), 200);
        $response->header('Content-Type', FacadesFile::mimeType($realPath));

        return $response;
    }
}
