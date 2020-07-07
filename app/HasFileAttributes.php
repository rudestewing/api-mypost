<?php
namespace App;

use App\Utilities\FileResponseGenerator;

trait HasFileAttributes
{
    use FileResponseGenerator;

    public function getFilesAttribute()
    {
        $data = [];
        foreach ($this->fileAttributes as $key => $type) {
            $data[$key] = $this->generateFilrUrl($this->{$key}, $type);
        }

        return $data;
    }
}