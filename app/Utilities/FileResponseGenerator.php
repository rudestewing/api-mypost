<?php
namespace App\Utilities;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

trait FileResponseGenerator
{
    protected $fileAccessId;

    public function generateFilrUrl($id, $type = 'image')
    {
        $this->fileAccessId = str_replace('-', '', Str::uuid()->toString().time());
        Cache::put($this->fileAccessId, 1, now()->addMinutes(5));
        
        return array_merge(
            [
                'original' => route('Api.Storage.Retrieve', [
                    'id' => $id,
                    'access_id' => $this->fileAccessId
                ])
            ],
            $type == 'image' ? $this->generateImageUrl($id) : []
        );
    }

    private function generateImageUrl($id): array
    {
        $sizes = ['xs', 'sm', 'md', 'lg'];

        $data = [];
        foreach ($sizes as $size) {
            $data[$size] = route('Api.Storage.Retrieve', [
                'id' => $id,
                'access_id' => $this->fileAccessId,
                'size' => $size,
            ]);
        }
        return $data;
    }
}