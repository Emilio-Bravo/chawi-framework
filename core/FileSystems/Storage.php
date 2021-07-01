<?php

namespace Core\FileSystems;

use Core\Http\RequestComplements\UploadedFile;

class Storage
{

    public string $storagePath = __DIR__ . '/../../app/storage/public/';

    public string $currentFolder;

    public function __construct(string $folder)
    {
        $this->currentFolder = $folder;
    }

    public function get(string $filename): string
    {
        return file_get_contents("{$this->storagePath}{$this->currentFolder}/$filename");
    }

    public function delete(string $filename): void
    {
        unlink("{$this->storagePath}{$this->currentFolder}/$filename");
    }

    public function put(UploadedFile $file, string $path): void
    {
        if ($file instanceof UploadedFile) {
            move_uploaded_file($file->tmpName(), "{$this->storagePath}{$this->currentFolder}/$path");
        }
    }

    public static function from(string $folder): self
    {
        return (new self($folder));
    }
}
