<?php

namespace Core\Hashing;

class Argon2IdHasher extends ArgonHasher
{
    /**
     * Compares the plain text with the given hash
     * 
     * @param string $currentValue
     * @param string $hashedValue
     * @return bool
     * 
     * @throws \RuntimeException
     */
    public function check(string $currentValue, string $hashedValue): bool
    {
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] != 'argon2id') {
            throw new \RuntimeException('The password does not use Argon2i algorithm');
        }

        return strlen($hashedValue) === 0 ? false : password_verify($currentValue, $hashedValue);
    }

    /**
     * Get the algorithm that should be used for hashing
     * 
     * @return int
     */
    protected function algorithm(): string
    {
        return PASSWORD_ARGON2ID;
    }
}
