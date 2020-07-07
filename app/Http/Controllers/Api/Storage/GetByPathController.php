<?php

namespace App\Http\Controllers\Api\Storage;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;


class GetByPathController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $path = null)
    {
        if(!$path) {
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

        $response = Response::make(FacadesFile::get($realPath), 200);
        $response->header('Content-Type', FacadesFile::mimeType($realPath));

        return $response;
    }
}
