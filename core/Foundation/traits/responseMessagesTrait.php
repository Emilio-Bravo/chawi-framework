<?php

namespace Core\Http\Traits;

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
}
