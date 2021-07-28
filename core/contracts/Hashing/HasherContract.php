<?php

namespace Core\Contracts\Hashing;

interface HasherContract
{
    /**
     * Returns the information of the given hash
     * 
     * @param string $hash 
     * @return array
     */
    public function info(string $hash): array;

    /**
     * Hash the given value
     * 
     * @param string $value
     * @param array $options
     * @return string
     */
    public function make(string $value, array $options): string;

    /**
     * Compares the plain text with the given hash
     * 
     * @param string $currentValue
     * @param string $hashedValue
     * @return bool
     */
    public function check(string $currentValue, string $hashedValue): bool;

    /**
     * Check if the given hash has been hashed with the specified options
     * 
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash(string $hashedValue, array $options): bool;
}
