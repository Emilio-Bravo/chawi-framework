<?php

namespace Core\Hashing;

abstract class AbstractHasher
{
    /**
     * Returns the information of the given hash
     * 
     * @param string $hash 
     * @return array
     */
    public function info(string $hash): array
    {
        return password_get_info($hash);
    }

    /**
     * Compares the plain text with the given hash
     * 
     * @param string $currentValue
     * @param string $hashedValue
     * @return bool
     */
    public function check(string $currentValue, string $hashedValue): bool
    {
        return strlen($hashedValue) === 0 ? false : password_verify($currentValue, $hashedValue);
    }
}
