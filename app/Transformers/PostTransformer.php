<?php
namespace App\Transformers;

use App\Post;
use App\User;
use App\Transformers\PosterTransfomer;
use App\Utilities\FileResponseGenerator;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    use FileResponseGenerator;

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
            'files' => [
                'image' => $this->generateFilrUrl($post->image_file_id)
            ],
            'original' => $post
        ];
    }

    public function includePoster(Post $post)
    {
        $poster = $post->user;
        return $this->item($poster, new PosterTransformer);
    }
}