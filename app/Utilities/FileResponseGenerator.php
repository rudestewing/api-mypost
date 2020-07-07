<?php
namespace App\Utilities;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

trait FileResponseGenerator
{

    public function generateFilrUrl($path = null, $type = 'image')
    {
        return array_merge(
            $path ? [
                'original' => $this->generateStorageSignedUrl($path)
            ] : [],
            $type == 'image' ? $this->generateImageUrl($path) : []
        );
    }

    private function generateImageUrl($path = null): array
    {
        if(!$path) {
            return [];
        }

        $sizes = ['xs', 'sm', 'md', 'lg'];

        $data = [];
        foreach ($sizes as $size) {
            $data[$size] = $this->generateStorageSignedUrl($path, [
                'size' => $size
            ]);
        }
        return $data;
    }

    private function generateStorageSignedUrl($path, $queryParams = [])
    {
        return URL::temporarySignedRoute(
            'Api.Storage.Get',
            now()->addMinutes(10),
            array_merge(
                [
                    'path' => $path,
                ],
                $queryParams
            )
        );

        return route(
            'Api.Storage.Get', 
            array_merge(
                [
                    'path' => $path
                ],
                $queryParams
            )
        );
    }
}