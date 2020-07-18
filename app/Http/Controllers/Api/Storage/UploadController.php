<?php

namespace App\Http\Controllers\Api\Storage;

use App\Domain\Storage\Actions\UploadAction;
use App\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\UploadRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UploadRequest $request, UploadAction $action)
    {
        return $action->excute($request);
    }
}
