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
            'files' => [
                'avatar' => $this->generateFilrUrl($user->avatar_file_id, 'image'),
                'id_card' => $this->generateFilrUrl($user->avatar_file_id, 'image'),
            ],
            'original' => $user,
        ];
    }
}