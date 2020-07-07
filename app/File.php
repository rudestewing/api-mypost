<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class File extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected static function boot() 
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->primaryKey} = self::generateUUID();
        });
    }

    private static function generateUUID()
    {
        $uuid = (string) str_replace('-', '', Str::uuid()->toString().time()); 
        
        if((self::class)::find($uuid)) {
            return self::generateUUID();
        }

        return $uuid;
    }

    public function fileResizes()
    {
        return $this->hasMany(\App\FileResize::class, 'file_id');
    }
}
