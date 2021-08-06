<?php

namespace Core\Support\Facades;

abstract class Facade
{
    /**
     * Get the target class
     * 
     * @return string
     * 
     * @throws RuntimeException
     */
    protected static function getClass(): string
    {
        throw new \RuntimeException(
            sprintf('Facade does not implement %s method', __METHOD__)
        );
    }
    /**
     * Dinamicly calls the class methods
     * 
     * @param string $method
     * @param mixed $arguments
     * @return mixed
     * 
     * @throws RuntimeException
     */
    public static function __callStatic(string $method, $arguments)
    {
        $class = static::getClass();

        if (!$object = new $class) {
            throw new \RuntimeException(
                'The called class could not be instanced, or has not been registered'
            );
        }

        return $object->$method(...$arguments);
    }
}
