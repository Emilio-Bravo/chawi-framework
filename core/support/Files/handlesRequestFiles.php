<?php

namespace Core\Support\Files;

trait HandlesRequestFiles
{
     public function hasFiles(): bool
    {
        foreach (array_keys($_FILES) as $key) {
            return !empty($_FILES[$key]['name']);
        }
    }

    public function hasFile($key)
    {
        return isset($_FILES[$key]) && ($_FILES[$key]['name']) != null;
    }

    public function file($key)
    {
        return $_FILES[$key];
    }

    public function getClientFileName($key)
    {
        return $_FILES[$key]['name'];
    }

    public function getFileType($key)
    {
        return $_FILES[$key]['type'];
    }

    public function getFileSize($key)
    {
        return $_FILES[$key]['size'];
    }

    public function getFileTmpName($key)
    {
        return $_FILES[$key]['size'];
    }

    public function getAllUploadedFiles()
    {
        return $_FILES;
    }
}
