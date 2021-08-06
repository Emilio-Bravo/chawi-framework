<?php

namespace Core\Http;

use Core\Support\Files\HandlesImages;
use Core\Support\Files\HandlesRequestFiles;
use Core\Support\Files\handlesUploadedFiles;
use Core\Http\RequestComplements\UploadedFile;

class Request
{

    use HandlesRequestFiles,
        HandlesImages,
        handlesUploadedFiles;

    private ?array $input = [];
    public Server $server;
    public array $cookies;

    public function __construct()
    {
        $this->sanitizeRequest();
        $this->server = new Server;
    }

    private function sanitizeRequest(): void
    {
        switch (Server::method()) {
            case 'GET':
                $this->input = \Core\Support\HttpSanitizer::sanitize_get();
                break;
            case 'POST':
                $this->input = \Core\Support\HttpSanitizer::sanitize_post();
                break;
        }
    }

    protected function setUp()
    {
    }

    public function hasHeader(string $name, ?string $value = null): bool
    {
        if (!is_null($value)) {

            return $this->header($name) && $this->header($name) === $value;
        }

        return !is_bool($this->header($name));
    }

    public function hasHeaders(array $names): bool
    {

        foreach ($names as $index => $value) {

            if (!is_int($index)) {
                $names[$index] === $this->header($index) ?: $errors[$index] = false;
            } else {
                $this->header($value) ?: $errors[$index] = false; //Value is now the header name
            }
        }

        return !isset($errors);
    }

    public function hasFile($key): bool
    {
        $file = new UploadedFile($key);
        return $file->hasContents();
    }

    public function file($key)
    {
        return new UploadedFile($key);
    }

    public function header(string $name): string|false
    {
        return $this->server->{$name};
    }

    public function all(): array
    {
        return (array) $this->input;
    }

    public function except(...$inputs): array
    {
        foreach ($this->input as $key => $value) {
            if (!in_array($key, $inputs)) $expected[$key] = $value;
        }
        return (array) $expected;
    }

    public function append(string $key, string $value)
    {
        $this->input[$key] = $value;
    }

    public function input(string $input)
    {
        return $this->input[$input];
    }

    public function has(string $input): bool
    {
        return key_exists($input, $this->input);
    }

    public function setInputValue(string $input, $value): void
    {
        $this->input[$input] = $value;
    }

    public function getMtehod(): string
    {
        return Server::method();
    }

    public function isMultipart(): bool
    {
        return $this->hasHeader('Content-Type')
            && str_contains($this->header('Content-Type'), 'multipart');
    }

    public function isForm(): bool
    {
        return $this->hasHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
}
