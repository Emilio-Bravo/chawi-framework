<?php

namespace Core\Http;

use Core\Http\Traits\responseMessages;
use Core\Http\Traits\Renderable;

class Response
{

    use responseMessages, Renderable;

    public function __construct($content = null, int $code = 200)
    {
        if (!is_null($content)) $this->render($content);
        $this->setStatusCode($code);
    }

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
