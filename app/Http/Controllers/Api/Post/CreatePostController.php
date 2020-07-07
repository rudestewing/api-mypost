<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreatePostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image_file' => 'required|string|file_exists_check'
        ]);

        $user = $request->user();
        $post = $user->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image_file' => $request->image_file,
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $post,
        ], Response::HTTP_CREATED);
    }
}
