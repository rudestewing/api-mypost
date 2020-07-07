<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class FileResize extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function file()
    {
        return $this->belongsTo(\App\File::class, 'file_id');
    }
}
