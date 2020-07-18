<?php
namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'poster'
    ];

    protected $defaultIncludes = [
        'poster'
    ];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'files' => $post->files,
            'original' => $post
        ];
    }

    public function includePoster(Post $post)
    {
        $poster = $post->user;
        return $this->item($poster, new PosterTransformer);
    }
}