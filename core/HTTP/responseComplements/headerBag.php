<?php

namespace Core\Http\ResponseComplements;

use Core\Http\Cookie;
use Core\Http\HeaderHelper;

class HeaderBag implements \IteratorAggregate, \Countable
{
    private array $headers = [];
    private array $cookies = [];
    private array $cache_control = [];

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function set(string $name, string $value): void
    {
        $this->headers[$name] = $value;

        if ($name == 'cache-control') $this->cache_control[$name] = $value;
    }

    public function all()
    {
        return $this->headers;
    }

    public function get(string $key)
    {
        if (in_array($key, array_keys($this->headers))) {
            return $this->headers[$key];
        }
    }

    public function remove(string $key): void
    {
        if (in_array($key, array_keys($this->headers))) {
            unset($this->headers[$key]);
        }
    }

    public function makeDispoistion(string $disposition, string $filename, string $filenameFallback): string
    {
        return HeaderHelper::makeDisposition($disposition, $filename, $filenameFallback);
    }

    public function setCookie(Cookie $cookie): void
    {
        $this->cookies[] = $cookie;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function reset(array $newArray)
    {
        $this->headers = $newArray;
    }

    public function has(string $key): bool
    {
        return isset($this->headers[$key]);
    }

    public function count(): int
    {
        return \count($this->headers);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->headers);
    }

    public function hasCacheControlDirective(string $directive): bool
    {
        return \in_array($directive, $this->cache_control);
    }

    public function addCacheControlDirective(string $key, $value = true): void
    {
        $this->cache_control[$key] = $value;
        $this->set('Cache-Control', $this->getCacheControlHeader());
    }

    public function removeCacheControlDirective(string $key): void
    {
        if (\in_array($key, $this->cache_control)) {
            unset($this->cache_control[$key]);
        }
    }

    public function getAsDate(string $key, \DateTime $default = null): \DateTime|null
    {
        if (is_null($value = $this->get($key))) {
            return $default;
        }

        if (!$date = \DateTime::createFromFormat(\DATE_RFC2822, $value)) {

            throw new \RuntimeException(
                sprintf('The "%s" HTTP header is not parseable (%s).', $key, $value)
            );
        }

        return $date;
    }

    public function getCacheControlDirective(string $key)
    {
        return \array_key_exists($key, $this->cache_control) ? $this->cache_control[$key] : null;
    }

    public function getCacheControlDirectives()
    {
        if (\in_array('Cache-Control', $this->headers)) {
            return array_intersect($this->headers, ['cache-control', 'Cache-Control']);
        }
    }

    public function getCacheControlHeader(): string
    {
        ksort($this->cache_control);

        return HeaderHelper::toString($this->cache_control);
    }
}
