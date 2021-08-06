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
    protected string $filename;

    /**
     * The path of the current file
     * 
     * @var string
     */
    protected string $path;

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
     * Get the content of the current file
     * 
     * @return string
     */
    public function __toString(): string
    {
        return file_get_contents($this->path());
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
     * Get the parent directory of the current file
     * 
     * @return string
     */
    public function dirname(): string
    {
        return pathinfo($this->path(), PATHINFO_DIRNAME);
    }

    /**
     * Get the trailing name component from a file path
     * 
     * @return string
     */
    public function basename(): string
    {
        return pathinfo($this->path(), PATHINFO_BASENAME);
    }

    /**
     * Get the mimetype of the current file
     * 
     * @return string
     */
    public function type(): string
    {
        return mime_content_type($this->path());
    }

    /**
     * Get the file extension
     * 
     * @return string
     */
    public function extension(): string
    {
        return pathinfo($this->path(), PATHINFO_EXTENSION);
    }

    /**
     * Get the size of the current file
     * 
     * @return int
     */
    public function size(): int
    {
        return filesize($this->path());
    }

    /**
     * Renames the current file
     * 
     * @param string $newname the new name
     * @return void
     */
    public function rename(string $newname): void
    {
        rename($this->path(), "$this->path/$newname");
    }

    /**
     * Makes a copy of the current file
     * 
     * @param string $filename the new file name
     * @return void
     */
    public function copy(string $filename): void
    {
        copy($this->path(), "$this->path/$filename");
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
     * Find path names matching a given pattern
     * 
     * @param string $pattern
     * @param int $flags
     * @return array|false
     */
    public function glob(string $pattern, int $flags = 0): array|false
    {
        return glob($pattern, $flags);
    }

    /**
     * Performs a download response of the current file
     * 
     * @return Core\Http\Complements\DownloadResponse 
     */
    public function download(): DownloadResponse
    {
        return new DownloadResponse($this);
    }

    /**
     * Get the file´s last modification time
     * 
     * @return int
     */
    public function lastModified(): int
    {
        return filemtime($this->path());
    }

    /**
     * Append content to the current file
     * 
     * @param string $content
     * @return int|false
     */
    public function append(string $content): int|false
    {
        return file_put_contents($this->path(), $content, FILE_APPEND);
    }

    /**
     * Loads the current file
     * 
     * @param array $data The data to work with
     * @return mixed
     */
    public function load(array $data = []): mixed
    {
        $__path = $this->path();
        $__data = $data;

        return (static function () use ($__path, $__data) {
            extract($__data, EXTR_SKIP);

            return require_once $__path;
        })();
    }

    public function replace(string $contents)
    {
        $tempPath = tempnam(
            $this->dirname(),
            $this->basename()
        );

        // Fix permissions of tempPath because `tempnam()` creates it with permissions set to 0600
        chmod($tempPath, 0777 - umask());

        file_put_contents($tempPath, $contents);

        rename($tempPath, $this->path());
    }

    /**
     * Hash the contents of the current file
     * 
     * @return string|false
     */
    public function hash(): string|false
    {
        return md5_file($this->path());
    }
}
