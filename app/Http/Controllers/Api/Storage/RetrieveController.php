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
            ], 403);
        }

        $request->validate([
            'size' => 'nullable|in:sm,md,xl,original'
        ]);

        if($request->size) {
            // get spesific size from file
        }

        $file = File::find($id);
        if(!$file || !Storage::disk('local')->exists(optional($file)->path)) {
            return response()->json([], 404);
        }

        $realPath = storage_path("app/{$file->path}"); // local storage
        $file = FacadesFile::get($realPath);
        $type = FacadesFile::mimeType($realPath);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    }
}
