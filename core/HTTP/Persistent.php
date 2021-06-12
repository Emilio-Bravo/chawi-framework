<?php

namespace Core\Http;

class Persistent
{
    public function __construct()
    {
        self::init();
    }

    private static function init()
    {
        if (session_status() != PHP_SESSION_ACTIVE) session_start();
    }

    public static function create(string $key): void
    {
        $_SESSION[$key] = null;
    }

    public static function destroy(string $key): void
    {
        if (isset($_SESSION[$key])) unset($_SESSION[$key]);
    }

    public static function set_value(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function push_value(string $key, $value): void
    {
        $_SESSION[$key][] = $value;
    }

    public static function under_push(string $session_key, string $key, $value)
    {
        $_SESSION[$session_key][][$key] = $value;
    }
}
