<?php

namespace Core\Support\Facades;

use Core\Contracts\FacadeContract;

/**
 * @method static \Core\Support\Flash create(string $key, mixed $value)
 * @method static \Core\Support\Flash enable()
 * @method static bool has(string $key)
 * @method static mixed get(string $key)
 * @method static \Core\Support\Flash push(string $key, string $index, string $value) 
 */
class Flash extends Facade implements FacadeContract
{
    /**
     * Get the target class
     * 
     * @return string
     * 
     * @throws RuntimeException
     */
    public static function getClass(): string
    {
        return 'Core\\Support\\Flash';
    }
}
