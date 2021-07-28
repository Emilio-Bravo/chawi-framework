<?php

namespace Core\Http\Complements;

use Core\Http\HeaderHelper;
use Core\Http\Response;

class DonwloadResponse extends Response
{

    /**
     * Current response file
     * 
     * @var StoredFile
     */
    protected StoredFile $file;

    /**
     * Current file name
     * 
     * @var string
     */
    protected ?string $filename;

    /**
     * Create a new download response 
     * 
     * @param StoredFile $file The current file
     * @param int $code The response code
     * @param string|null $filename The filename for the download
     * @param array $headers Additional response headers
     */
    public function __construct(StoredFile $file, int $code = 200, ?string $filename = null, array $headers = [])
    {
        $this->file = $file;
        parent::__construct($file, $code, $headers);
        $this->prepareResponse($filename);
    }

    /**
     * Prepares the download response
     * 
     * @param string $filename
     * @return void
     */
    protected function prepareResponse(?string $filename): void
    {
        if (!$this->headers->has('Accept-Ranges')) {
            //only on safe HTTP methods
            $this->headers->set('Accept-Ranges', sprintf('bytes */%s', $this->file->size()));
        }

        if (!$this->headers->has('Pragma')) {
            $this->headers->set('Pragma', 'public');
        }

        if (!$this->headers->has('Expires')) {
            $this->headers->set('Expires', 0);
        }

        if (!$this->headers->hasCacheControlDirective('must-revalidate')) {

            $this->headers->addCacheControlDirective('must-revalidate');
            $this->headers->addCacheControlDirective('post-check', 0);
            $this->headers->addCacheControlDirective('pre-check', 0);
        }

        $this->setCacheControlPrivate();

        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', $this->file->type());
        }

        $filename = $filename ?? $this->file->name();

        $this->headers->set(
            'Content-Disposition',
            HeaderHelper::makeDisposition('attachment', $filename, $filename)
        );

        $this->headers->set('Content-Transfer-Encoding', 'binary');
    }

    /**
     * Get the current response file
     *
     * @return StoredFile
     */
    public function getFile(): StoredFile
    {
        return $this->file;
    }

    /**
     * Get the current file name
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
