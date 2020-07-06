<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class FileResize extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    protected $appends = [
        'url'
    ];

    public function file()
    {
        return $this->belongsTo(\App\File::class, 'file_id');
    }

    public function getUrlAttribute($value)
    {
        $accessId = Str::uuid()->toString();
        Cache::put($accessId, 1, now()->addMinutes(30));

        return route('Api.Storage.Retrieve', [
            'id' => $this->file_id,
            'access_id' => $accessId    
        ]);
    }
}
