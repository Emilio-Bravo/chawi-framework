<?php

namespace Core\FileSystems;

class Storage
{

    public static string $storage_path = __DIR__ . '/../../app/storage/public/';

    public static function file(string $path, string $filename): string
    {
        return file_get_contents(self::$storage_path . "$path/$filename");
    }

    public static function delete(string $path, string $filename): void
    {
        unlink(self::$storage_path . "$path/$filename");
    }

    public static function put(string $current_file_path, string $destination_path, string $filename): void
    {
        move_uploaded_file($current_file_path, self::$storage_path . "$destination_path/$filename");
    }
}
