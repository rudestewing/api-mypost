<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFileAttributes;

    protected $guarded = [];

    protected $fileAttributes = [
        'image_file' => 'image'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
