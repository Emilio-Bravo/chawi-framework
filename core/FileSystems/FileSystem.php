<?php

namespace Core\FileSystems;

use Core\Config\Support\interactsWithPathSettings;
use Core\Http\Complements\DownloadResponse;
use Core\Http\Complements\StoredFile;
use Core\Http\RequestComplements\UploadedFile;

class FileSystem
{

    use interactsWithPathSettings;

    /**
     * The current folder to work with
     * 
     * @var string
     */
    protected string $currentFolder = '';

    /**
     * Returns an object which represents an stored file
     * 
     * @param string $path
     * @return object
     */
    public function get(string $path): StoredFile
    {
        return new StoredFile("$this->storage_path/$this->currentFolder", $path);
    }

    /**
     * Unlinks the specified path
     * 
     * @param string $path
     * @return self
     */
    public function delete(string $path): self
    {
        unlink("{$this->storage_path}{$this->currentFolder}/$path");

        return $this;
    }

    /**
     * Create a file into the specified path
     * 
     * @param UploadedFile|string $contents
     * @param string $path
     * @param bool $lock
     * @return self
     */
    public function put(UploadedFile|string $contents, string $path, bool $lock = false): self
    {
        if ($contents instanceof UploadedFile) {
            $contents = $contents->getContents();
        }

        file_put_contents(
            "{$this->storage_path}{$this->currentFolder}/$path",
            $contents,
            $lock ? LOCK_EX : 0
        );

        return $this;
    }

    /**
     * Determines wheter a file exists or not
     * 
     * @param string|UploadedFile $filename the file to search
     * @return bool
     */
    public function has(string|UploadedFile $path): bool
    {
        if ($path instanceof UploadedFile) $path = $path->name();

        return !\is_dir("$this->storage_path/$this->currentFolder/$path");
    }

    /**
     * Moves an existing file to the specified destination storage folder
     * 
     * @param string $filename the file to move
     * @param string $destination_folder the destination storage folder
     * @return bool
     */
    public function move(string $filename, string $destination_folder): bool
    {
        return rename(
            "$this->storage_path/$this->currentFolder/$filename",
            "$this->storage_path/$destination_folder/$filename"
        );
    }

    /**
     * Returns a file download response
     * 
     * @return Core\Http\Complements\DownloadResponse
     */
    public function download(string $path): DownloadResponse
    {
        return new DownloadResponse(
            new StoredFile("$this->storage_path/$this->currentFolder", $path),
            200
        );
    }

    /**
     * Creates a new storage folder and intance
     * 
     * @param string $folder
     * @return self|false
     */
    public function create(string $folder): self|false
    {
        $currentFolder = "$this->storage_path/$folder";

        $this->ensureDirectory($currentFolder);

        return \is_dir($currentFolder) ? $this->in($folder) : false;
    }

    /**
     * Creates a new directory
     * 
     * @param string $path
     * @param int $mode The permissions for the operation
     * @param bool $recursive Wheter to allow the creation of nested directories specified in the pathname
     * @param bool $force Wheter to rewrite an existsing directory
     * @return bool
     */
    public function makeDirectory(string $path, int $mode = 0755, bool $recursive = false, bool $force = false): bool
    {
        return $force
            ? @mkdir($path, $mode, $recursive, $force)
            : mkdir($path, $mode, $recursive, $force);
    }

    /**
     * Creates the directory if it was not previously created
     * 
     * @param string $path
     * @param int $mode The permissions for the operation
     * @param bool $recursive Wheter to allow the creation of nested directories specified in the pathname
     * @return self
     */
    public function ensureDirectory(string $path, int $mode = 0755, bool $recursive = true): self
    {
        if (!\is_dir($path)) {
            $this->makeDirectory($path, $mode, $recursive);
        }

        return $this;
    }

    /**
     * Sets the current folder
     * 
     * @param string $folder
     * @return self
     */
    public function in(string $folder): self
    {
        $this->currentFolder = $folder;

        return $this;
    }
}
