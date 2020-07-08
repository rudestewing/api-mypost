<?php
namespace App;

use App\Utilities\FileResponseGenerator;

trait HasFileAttributes
{
    use FileResponseGenerator;

    /**
     * funciton accessor untuk attribute "files"
     * 
     *
     * @return array
     */
    public function getFilesAttribute(): array
    {
        $data = [];

        if(!$this->fileAttributes) {
            return $data;
        }
        
        foreach ($this->fileAttributes as $key => $type) {
            $data[$key] = $this->generateFilrUrl($this->{$key}, $type);
        }

        return $data;
    }
}