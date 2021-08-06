<?php

namespace Core\Support\Facades;

use Core\Contracts\FacadeContract;

/**
 * @method static \Core\FileSystems\FileSystem in(string $folder)
 * @method static \Core\FileSystems\FileSystem create(string $folder)
 * @method static \Core\FileSystems\FileSystem put(UploadedFile|string $contents, string $path, bool $lock = false)
 * @method static \Core\FileSystems\FileSystem delete(string $path)
 * @method static \Core\Http\Complements\StoredFile get(string $path)
 * @method static \Core\Http\Complements\DownloadResponse download(string $path)
 * @method static bool move(string $filename, string $destination_folder)
 * @method static bool has(string|UploadedFile $path)
 * @method static bool makeDirectory(string $path, int $mode = 0755, bool $recursive = false, bool $force = false)
 * 
 * @see \Core\FileSystems\FileSystem
 */
class Storage extends Facade implements FacadeContract
{
    /**
     * Get the target class
     * 
     * @return string
     * 
     * @throws RuntimeException
     */
    public static function getClass(): string
    {
        return 'Core\\FileSystems\\FileSystemManager';
    }
}
