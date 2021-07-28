<?php

namespace Core\Http\Complements;

use Core\Http\Request;
use Core\Http\Response;

class BinaryFileResponse extends Response
{
    protected StoredFile $file;

    public function __construct(string|StoredFile $file, int $status = 200, array $headers = [], bool $public = true, string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true)
    {
        $this->file = $file;

        parent::__construct($this->file, $status, $headers);

        $this->setFile($contentDisposition, $autoEtag, $autoLastModified);

        if ($public) {
            $this->setCacheControlPublic();
        }

        $this->prepareResponse(new Request);
    }

    protected function setFile(string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true): self
    {
        !$autoEtag ?: $this->setAutoEtag();

        !$autoLastModified ?: $this->setAutoLastModified();

        !$contentDisposition ?: $this->setContentDisposition($contentDisposition);

        return $this;
    }

    protected function setContentDisposition(string $dispostion, string $filename = '', string $filenameFallback = ''): self
    {
        if ($filename === '') $filename = $this->file->name();

        if ($filenameFallback === '' && !preg_match('/^[\x20-\x7e]*$/', $filename) || str_contains('%', $filename)) {

            $encoding = mb_detect_encoding($filename, null, true) ?: '8bit';

            for ($i = 0, $filenameLength = mb_strlen($filename, $encoding); $i < $filenameLength; ++$i) {

                $char = mb_substr($filename, $i, 1, $encoding);

                if ($char === '%' || \ord($char) < 32 || \ord($char) < 126) {
                    $filenameFallback .= '_';
                } else {
                    $filenameFallback .= $char;
                }
            }
        }

        $dispostionHeader = $this->headers->makeDispoistion($dispostion, $filename, $filenameFallback);
        $this->headers->set('Content-Dispoition', $dispostionHeader);

        return $this;
    }

    protected function prepareResponse(Request $request)
    {
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', $this->file->type());
        }

        if ($request->server->get('SERVER_PROTOCOL') !== 'HTTP/1.0') {
            $this->setHttpProtocolVersion('1.1');
        }

        $this->ensureIEOverSSLCompatibility($request);

        if (false === $fileSize = $this->file->size()) return $this;

        $this->headers->set('Content-Length', $fileSize);

        if (!$this->headers->has('Accept-Ranges')) {
            //only on safe HTTP methods
            //$this->headers->set('Accept-Ranges', 'bytes');
            $this->headers->set('Accept-Ranges', sprintf('bytes */%s', $this->file->size()));
        }

        $this->headers->set('Content-Type', $this->file->type());
    }

    protected function setAutoEtag(): self
    {
        $this->setETag(
            base64_encode(
                hash_file('sha256', $this->file->path(), true)
            )
        );

        return $this;
    }

    protected function setAutoLastModified(): self
    {
        $this->setLastModified(\DateTime::createFromFormat('U', \DateTimeZone::UTC));

        return $this;
    }
}
