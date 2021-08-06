<?php

namespace Core\Support\Files;

use Core\FileSystems\Storage;
use Core\Http\RequestComplements\UploadedFile;

trait HandlesImages
{
    private array $image_types = [
        'bmp'     => 'image/bmp',
        'cgm'     => 'image/cgm',
        'djv'     => 'image/vnd.djvu',
        'djvu'    => 'image/vnd.djvu',
        'gif'     => 'image/gif',
        'ico'     => 'image/x-icon',
        'jpe'     => 'image/jpeg',
        'jpeg'    => 'image/jpeg',
        'jpg'     => 'image/jpeg',
        'pbm'     => 'image/x-portable-bitmap',
        'pgm'     => 'image/x-portable-graymap',
        'png'     => 'image/png',
        'pnm'     => 'image/x-portable-anymap',
        'ppm'     => 'image/x-portable-pixmap',
        'ras'     => 'image/x-cmu-raster',
        'rgb'     => 'image/x-rgb',
        'svg'     => 'image/svg+xml',
        'svgz'    => 'image/svg+xml',
        'tif'     => 'image/tiff',
        'tiff'    => 'image/tiff',
        'wbmp'    => 'image/vnd.wap.wbmp',
        'xbm'     => 'image/x-xbitmap',
        'xpm'     => 'image/x-xpixmap',
        'xwd'     => 'image/x-xwindowdump',
        'ief'     => 'image/ief'
    ];

    private array $image_mime_type = [];

    public function isImage(UploadedFile $file): bool
    {
        return in_array($file->currentFile()->type, $this->image_mime_type);
    }

    public function upload(UploadedFile $file, string $to, string $path): void
    {
        Storage::in($to)->put(
            $file,
            $path
        );
    }

    public function uploadIfIsImage(UploadedFile $key, string $to, string $path): void
    {
        if ($this->isImage($key)) $this->upload($key, $to, $path);
    }

    public function deleteFile(string $path, string $filename): void
    {
        Storage::in($path)->delete($filename);
    }

    public function getFile($path, string $filename): string
    {
        return Storage::in($path)->get($filename);
    }
}
