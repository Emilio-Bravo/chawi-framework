<?php

namespace Core\Foundation\Traits\Http;

trait responseMessages
{
    public function withSuccess(string $message): self
    {
        \Core\Support\Flash::create('success', $message);
        return $this;
    }

    public function withError(string $message): self
    {
        \Core\Support\Flash::create('error', $message);
        return $this;
    }

    public function with(string $key, $value): self
    {
        \Core\Support\Flash::create($key, $value);
        return $this;
    }
}
