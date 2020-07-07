<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class PosterTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
}