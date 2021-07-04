<?php

namespace Core\FileSystems;

use Core\Config\Support\interactsWithPathSettings;
use Core\Http\RequestComplements\UploadedFile;

class Storage
{

    use interactsWithPathSettings;

    /**
     * The current folder to work with
     */
    public string $currentFolder;

    public function __construct(string $folder)
    {
        $this->currentFolder = $folder;
    }

    /**
     * Returns the raw content of a file
     * @param string $filename
     * @return string
     */
    public function get(string $filename): string
    {
        return file_get_contents("{$this->storage_path}{$this->currentFolder}/$filename");
    }

    /**
     * Unlinks the specified path
     * @param string $filename
     * @return void
     */
    public function delete(string $filename): void
    {
        unlink("{$this->storage_path}{$this->currentFolder}/$filename");
    }

    /**
     * Uploads a file to the specified path
     * @param UploadedFile $file
     * @param string $path
     * @return void
     */
    public function put(UploadedFile $file, string $path): void
    {
        if ($file instanceof UploadedFile) {
            move_uploaded_file($file->tmpName(), "{$this->storage_path}{$this->currentFolder}/$path");
        }
    }

    /**
     * Sets the current folder
     * @param string $folder
     * @return object
     */
    public static function in(string $folder): self
    {
        return (new self($folder));
    }
}
