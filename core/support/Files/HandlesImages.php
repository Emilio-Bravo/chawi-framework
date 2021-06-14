<?php

namespace Core\Support\Files;

trait HandlesImages
{
    private array $image_types = [
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG,
        IMAGETYPE_PNG,
        IMAGETYPE_SWF,
        IMAGETYPE_PSD,
        IMAGETYPE_BMP,
        IMAGETYPE_TIFF_II,
        IMAGETYPE_TIFF_MM,
        IMAGETYPE_JPC,
        IMAGETYPE_JP2,
        IMAGETYPE_JPX,
        IMAGETYPE_JB2,
        IMAGETYPE_SWC,
        IMAGETYPE_IFF,
        IMAGETYPE_WBMP,
        IMAGETYPE_XBM,
        IMAGETYPE_ICO,
    ];

    private array $image_mime_type = [];

    public string $storage_path = __DIR__ . '/../../../app/storage/public/';

    public function isImage(string $key): bool
    {
        $this->buildImageMimeTypes();
        return in_array($_FILES[$key]['type'], $this->image_mime_type);
    }

    public function uploadImage(string $key, string $path, string $filename): void
    {
        move_uploaded_file($_FILES[$key]['tmp_name'], "$this->storage_path/$path/$filename");
    }

    public function uploadIfIsImage(string $key, string $path, string $filename): void
    {
        if ($this->isImage($key)) $this->uploadImage($key, $path, $filename);
    }

    public function uploadAllIfImages(string $path): void
    {
        array_map(fn ($key) => $this->uploadIfIsImage($key, $path, $key['name']), array_keys($_FILES));
    }

    private function buildImageMimeTypes(): void
    {
        array_map(fn ($value) => $this->image_mime_type[] = image_type_to_mime_type($value), $this->image_types);
    }
}
