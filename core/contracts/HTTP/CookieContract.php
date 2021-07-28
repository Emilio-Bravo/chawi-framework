<?php

namespace Core\Contracts\Http;

interface CookieContract
{

    /**
     * Cookie exists?
     * 
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool;

    /**
     * Get a cookie
     * 
     * @param string $key
     */
    public static function get(string $key);

    /**
     * Remove an existing cookie
     * 
     * @param string $key
     * @return void
     */
    public static function remove(string $key): void;
}
