<?php

namespace Core\Http;

use Core\Support\Files\HandlesImages;
use Core\Support\Files\HandlesRequestFiles;

class Request
{

    use HandlesRequestFiles, HandlesImages;

    private ?array $input = [];

    public function __construct()
    {
        $this->sanitizeRequest();
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getURI(): string
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position === false) return $path;
        return substr($path, 0, $position);
    }

    private function sanitizeRequest(): void
    {
        switch ($this->getMethod()) {
            case 'GET':
                $this->input = \Core\Support\HttpSanitizer::sanitize_get();
                break;
            case 'POST':
                $this->input = \Core\Support\HttpSanitizer::sanitize_post();
                break;
        }
    }

    public function all(): ?array
    {
        return $this->input;
    }

    public function except(...$inputs)
    {
        foreach ($this->input as $key => $value) {
            if (!preg_match('/' . implode('|', $inputs) . '/', $key)) {
                $expected[$key] = $value;
            }
        }
        return $expected;
    }

    public function input(string $input)
    {
        return $this->input[$input];
    }

    public function setInputValue(string $input, $value): void
    {
        $this->input[$input] = $value;
    }

    public function imageUploadProccess(string $path, ...$keys): void
    {
        if ($this->hasFiles()) {
            foreach ($keys as $files_key) {
                $filename = \Core\Support\Crypto::cryptoImage($this, $files_key);
                $this->uploadIfIsImage($files_key, $path, $filename);
                $this->setInputValue($files_key, $filename);
            }
        }
    }

    public function imageUpdateProccess(string $path, array $keys, array $delete_filenames): void
    {
        if ($this->hasFiles()) {
            array_map(fn ($filename) => $this->deleteFile($path, $filename), $delete_filenames);
            foreach ($keys as $files_key) {
                $filename = \Core\Support\Crypto::cryptoImage($this, $files_key);
                $this->uploadIfIsImage($files_key, $path, $filename);
                $this->setInputValue($files_key, $filename);
            }
        }
    }
}
