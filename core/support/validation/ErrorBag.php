<?php

namespace Core\Support\Validation;

class ErrorBag implements \IteratorAggregate
{

    private array $errors = [];

    public function add(string $key, string $value): void
    {
        $this->errors[$key] = $value;
    }

    public function remove(string $key): void
    {
        if (\in_array($key, $this->errors)) unset($this->errors[$key]);
    }

    public function has(string $key): bool
    {
        return \key_exists($key, $this->errors);
    }

    public function get(): array
    {
        return $this->errors;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->errors);
    }
}
