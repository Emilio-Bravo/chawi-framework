<?php

namespace Core\Contracts;

interface FacadeContract
{
    /**
     * Get the target class
     * 
     * @return string
     * 
     * @throws RuntimeException
     */
    public static function getClass(): string;
}
