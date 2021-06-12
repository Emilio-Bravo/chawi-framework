<?php

namespace Core\Http;

class Request
{

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
}
