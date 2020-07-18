<?php
namespace App\Domain\Storage\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class RetrieveAction
{
    public function excute(Request $request, $path)
    {
        if(!$path || !$request->hasValidSignature()) {
            return response()->json([], 404);
        }

        if($request->size && in_array($request->size, ['xs', 'sm', 'md', 'lg'])) {
            return $this->render("{$request->size}/{$path}");  
        }

        return $this->render($path);
    }

    private function render($path)
    {
        if(!Storage::disk('local')->exists($path)) {
            return response()->json([], 404);
        }

        $realPath = storage_path("app/{$path}"); // local storage

        $response = Response::make(File::get($realPath), 200);
        $response->header('Content-Type', File::mimeType($realPath));

        return $response;
    }
}