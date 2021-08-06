<?php

namespace Core\Http\Complements;

class AbstractCookie
{
    /**
     * Cookie exists?
     * 
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Get a cookie
     * 
     * @param string $key
     */
    public static function get(string $key)
    {
        return in_array($key, $_COOKIE) ? $_COOKIE[$key] : false;
    }

    /**
     * Remove an existing cookie
     * 
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        new \Core\Http\Cookie($key, null, 0);

        if (in_array($key, $_COOKIE)) unset($_COOKIE[$key]);
    }
}
