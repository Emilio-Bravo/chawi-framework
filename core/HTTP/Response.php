<?php

namespace Core\Http;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
    public function redirect(string $location = '/'): Response
    {
        header("location:$location");
        return $this;
    }
    public function with(string $key, $value): Response
    {
        \Core\Support\Flash::create($key, $value);
        return $this;
    }
    public static function cancel(): Response
    {
        header('location:' . $_SERVER['HTTP_REFERER']);
        return new static;
    }
    public static function code(int $code): void
    {
        http_response_code($code);
    }
}
