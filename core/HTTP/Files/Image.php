<?php

namespace Core\Http\Files;

use Core\Http\Complements\StoredFile;
use Core\Http\RequestComplements\UploadedFile;

class Image
{

    /**
     * Available image types
     * 
     * @var array
     */
    private array $suportedMimeTypes = [
        'bmp'     => 'image/bmp',
        'gif'     => 'image/gif',
        'jpeg'    => 'image/jpeg',
        'jpg'     => 'image/jpg',
        'png'     => 'image/png',
        'xbm'     => 'image/x-xbitmap',
        'xpm'     => 'image/x-xpixmap'
    ];

    private UploadedFile|StoredFile $image;

    /**
     * Create a new Image instance
     * 
     * @param UploadedFile|StoredFile $image
     * @return void
     * 
     * @throws \RuntimeException
     */
    public function __construct(UploadedFile|StoredFile $image)
    {
        $this->image = $image;

        if (!in_array($this->image->type(), $this->suportedMimeTypes)) {
            throw new \RuntimeException('Current file is not an image');
        }
    }

    public function getCorrespondingFunc(): string
    {
        $mimeType = array_intersect($this->suportedMimeTypes, $this->image->type());

        $funcComplement = array_search($mimeType, $this->suportedMimeTypes);

        return "imagecreatefrom$funcComplement";
    }
}
