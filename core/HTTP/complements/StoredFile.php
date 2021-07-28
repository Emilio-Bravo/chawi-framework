<?php

namespace Core\Http\Complements;

/**
 * Represents an stored file
 */
class StoredFile
{

    /**
     * The current file name
     * 
     * @var string 
     */
    private string $filename;

    /**
     * The path of the current file
     * 
     * @var string
     */
    private string $path;

    /**
     * Sets the file data
     * 
     * @param string $path
     * @param string $filename
     * @return void
     */
    public function __construct(string $path, string $filename)
    {
        $this->path = $path;
        $this->filename = $filename;
    }

    /**
     * Returns the content of the current file
     * 
     * @return string
     */
    public function __toString(): string
    {
        return file_get_contents("$this->path/$this->filename");
    }

    /**
     * Get the name of the current file
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->filename;
    }

    /**
     * Returns the mimetype of the current file
     * 
     * @return string
     */
    public function type(): string
    {
        return mime_content_type("$this->path/$this->filename");
    }

    /**
     * Returns the size of the current file
     * 
     * @return int
     */
    public function size(): int
    {
        return filesize("$this->path/$this->filename");
    }

    /**
     * Renames the current file
     * 
     * @param string $newname the new name
     * @return void
     */
    public function rename(string $newname): void
    {
        rename("$this->path/$this->filename", "$this->path/$newname");
    }

    /**
     * Makes a copy of the current file
     * 
     * @param string $filename the new file name
     * @return void
     */
    public function copy(string $filename): void
    {
        copy("$this->path/$this->filename", "$this->path/$filename");
    }

    /**
     * Get the path of the current file
     * 
     * @return string
     */
    public function path(): string
    {
        return "$this->path/$this->filename";
    }
    /**
     * Returns a file download response
     * 
     * @return Core\Http\Complements\DownloadResponse 
     */
    public function download(): DonwloadResponse
    {
        return new DonwloadResponse($this);
    }
}
