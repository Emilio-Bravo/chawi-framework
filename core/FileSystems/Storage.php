<?php

namespace Core\FileSystems;

use Core\Config\Support\interactsWithPathSettings;
use Core\Http\Complements\DonwloadResponse;
use Core\Http\Complements\StoredFile;
use Core\Http\RequestComplements\UploadedFile;

class Storage
{

    use interactsWithPathSettings;

    /**
     * The current folder to work with
     * 
     * @var string
     */
    public string $currentFolder;

    public function __construct(string $folder)
    {
        $this->currentFolder = $folder;
    }

    /**
     * Returns an object which represents an stored file
     * 
     * @param string $filename
     * @return object
     */
    public function get(string $filename): StoredFile
    {
        return new StoredFile("$this->storage_path/$this->currentFolder", $filename);
    }

    /**
     * Unlinks the specified path
     * 
     * @param string $filename
     * @return void
     */
    public function delete(string $filename): void
    {
        unlink("{$this->storage_path}{$this->currentFolder}/$filename");
    }

    /**
     * Uploads a file to the specified path
     * 
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
     * Determines wheter a file exists or not
     * 
     * @param string|UploadedFile $filename the file to search
     * @return bool
     */
    public function has(string|UploadedFile $filename): bool
    {
        if ($filename instanceof UploadedFile) $filename = $filename->name();

        return !\is_dir("$this->storage_path/$this->currentFolder/$filename");
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
    public function download(string $filename): DonwloadResponse
    {
        return new DonwloadResponse(
            new StoredFile("$this->storage_path/$this->currentFolder", $filename),
            200
        );
    }

    /**
     * Creates a new storage folder and intance
     * 
     * @param string $folder
     * @return self|false
     */
    public static function create(string $folder): self|false
    {
        $currentFolder = self::getInstance()->storage_path . DIRECTORY_SEPARATOR . $folder;

        if (!\is_dir($currentFolder)) mkdir($currentFolder);

        return \is_dir($currentFolder) ? new self($folder) : false;
    }

    /**
     * Sets the current folder
     * 
     * @param string $folder
     * @return object
     */
    public static function in(string $folder): self
    {
        return (new self($folder));
    }

    /**
     * Returns a new Storage instance
     * 
     * @return self
     */
    private static function getInstance()
    {
        return new self('');
    }
}
