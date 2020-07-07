<?php
namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

trait HasFileAttribute
{
    private function generateUrl(array $data)
    {
        return route('Api.Storage.Retrieve', $data);
    }

    private $sizeTypes = [
        'xs', 'sm', 'md', 'lg'
    ];

    public function getFilesAttribute() 
    {
        $accessId = Str::uuid().Str::random(5);
        
        Cache::put($accessId, 1, now()->addMinutes(5));

        $data = [];
        foreach ($this->fileAttributes as $item) {
            $keyName = str_replace('_file_id', '', $item);
            
            $data[$keyName] = [
                'id' => $id = $this->{$item},
                'url' => $this->generateUrl(['id' => $this->{$item}, 'access_id' => $accessId]),
                'sizes' => collect($this->sizeTypes)->map(function($sizeType) use ($accessId, $id) {
                    return [
                        'size' => $sizeType,
                        'url' => $this->generateUrl(['id' => $id, 'size' => $sizeType, 'access_id' => $accessId])
                    ];
                })
            ];
        }
        return $data;
    }
}