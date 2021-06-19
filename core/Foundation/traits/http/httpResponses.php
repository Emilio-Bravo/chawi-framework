<?php

namespace Core\Foundation\Traits\Http;

trait httpResponses
{
    protected function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $location = '/', int $code = 200): \Core\Http\Response
    {
        $this->statusCode($code);
        header("location:$location");
        return $this;
    }

    public function setHeader(string $header, string $value): void
    {
        header("$header: $value");
    }

    public function setHeaders(string ...$headers): void
    {
        array_map(fn ($header) => header($header), $headers);
    }

    public static function cancel(): \Core\Http\Response
    {
        header('location:' . $_SERVER['HTTP_REFERER']);
        return new static;
    }
}
