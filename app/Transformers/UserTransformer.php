<?php
namespace App\Transformers;

use App\User;
use App\Utilities\FileResponseGenerator;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use FileResponseGenerator;

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'files' => $user->files,
            'original' => $user,
        ];
    }
}