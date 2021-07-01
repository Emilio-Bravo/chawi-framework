<?php

namespace Core\Foundation\Traits\Http;

trait httpResponses
{
    protected function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $location = '/', int $code = 200): self
    {
        $this->statusCode($code);
        $this->setHeader('location', $location);
        return $this;
    }

    public function setHeader(string $key, string $value): object
    {
        header("$key: $value");
        return $this;
    }

    public static function cancel(): self
    {
        header('location:' . \Core\Http\Server::referer());
        return new static;
    }
}
