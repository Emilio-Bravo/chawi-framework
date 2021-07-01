<?php

namespace Core\Http;

class File
{

    public static string $storage_path = __DIR__ . '/../../app/storage/public/';

    public static function get(string $path, string $filename): string
    {
        return file_get_contents(self::$storage_path . "$path/$filename");
    }
}
