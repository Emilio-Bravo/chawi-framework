<?php

namespace Core\Support\Files;

use Core\Http\RequestComplements\UploadedFile;

trait HandlesRequestFiles
{
    public function hasFiles(): bool
    {
        foreach (array_keys($_FILES) as $key) {
            return !empty($_FILES[$key]['name']);
        }
    }

    public function hasFile($key): bool
    {
        $file = new UploadedFile($key);
        return $file->hasContents();
    }

    public function file($key)
    {
        return new UploadedFile($key);
    }

    public function getAllUploadedFiles()
    {
        return $_FILES;
    }
}
