<?php
namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

trait HasFileAttribute
{
    public function getFilesAttribute($value) 
    {
        $accessId = Str::uuid().Str::random(5);
        
        Cache::put($accessId, 1, now()->addMinutes(5));

        $data = [];
        foreach ($this->fileAttributes as $item) {
            $data[str_replace('_file_id', '', $item)] = File::query()
                ->select(['id', 'path', 'type'])
                ->with(['fileResizes'])
                ->find($this->{$item});
        }
        return $data;
    }

    // foreach ($this->fileAttributes as $item) {
    //     $data[str_replace('_file_id', '', $item)] = route('Api.Storage.Retrieve', [
    //         'id' => $this->{$item},
    //         'access_id' => $accessId
    //     ]);
    // }
    // return $data;

    public function hasFile($foreignKey)
    {
        return $this->belongsTo(\App\File::class, $foreignKey)->with(['fileResizes']);
    }

}