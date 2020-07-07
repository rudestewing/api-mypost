<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFileAttribute;

    protected $guarded = [];

    protected $fileAttributes = [
        'image_file_id'
    ];

    protected $appends = [
        'files'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
