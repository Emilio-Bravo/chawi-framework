<?php

namespace Core\Support;

use Core\Http\Persistent;

class Flash
{

    private Persistent $persistent;
    private string $expireKey = 'quit';

    public function __construct()
    {
        $this->persistent = new Persistent;
    }

    public function create(string $key, mixed $value): void
    {
        $this->persistent::create($key, $value);
        $this->persistent::create("{$key}_{$this->expireKey}", true);
    }

    public function enable(): void
    {
        array_map(fn (string $key) => $this->expire($key), array_keys($this->persistent::compoment()));
    }

    public function has(string $key): bool
    {
        return $this->persistent::has($key);
    }

    public function get(string $key)
    {
        if ($this->has($key)) return $this->persistent::get($key);
    }

    public function push(string $key, string $index, string $value): void
    {
        if ($this->has($key)) {
            $this->persistent::push_value($key, $index, $value);
        }
    }

    private function expire(string $key): void
    {

        $targetSession = preg_split("/_$this->expireKey/", $key)[0];

        if (str_contains($key, $this->expireKey) && !is_null($this->persistent::get($targetSession))) {
            $this->persistent::destroy($targetSession);
            $this->persistent::destroy($key);
        }
    }

    public static function init(): self
    {
        return new self;
    }
}
