<?php

namespace Core\Hashing;

use Core\Contracts\Hashing\HasherContract;

class BcryptHasher extends AbstractHasher implements HasherContract
{
    /**
     * Default Bcrypt cost
     * 
     * @var int
     */
    protected int $cost = PASSWORD_BCRYPT_DEFAULT_COST;

    /**
     * Indicates wheter performing an algorithm check
     * 
     * @var bool
     */
    protected bool $verifyAlgorithm = false;

    /**
     * Create a new Bcrypt hasher instance
     * 
     * @param array $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->cost = $options['cost'] ?? $this->cost;
        $this->verifyAlgorithm = $options['verify'] ?? $this->verifyAlgorithm;
    }

    /**
     * Hash the given value
     * 
     * @param string $value
     * @param array $options
     * @return string
     * 
     * @throws \RuntimeException
     */
    public function make(string $value, array $options): string
    {
        $hash = @password_hash(
            $value,
            $this->algorithm(),
            ['cost' => $this->cost($options)]
        );

        is_string($hash) ?: throw new \RuntimeException('Bcrypt hash not supported');

        return $hash;
    }


    /**
     * Check if the given hash has been hashed with the specified options
     * 
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return password_needs_rehash(
            $hashedValue,
            $this->algorithm(),
            ['cost' => $this->cost($options)]
        );
    }

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
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] != 'bcrypt') {
            throw new \RuntimeException('The password does not use Bcrypt algorithm');
        }

        return parent::check($currentValue, $hashedValue);
    }

    /**
     * Get the cost value
     * 
     * @param array $options
     * @return int
     */
    protected function cost(array $options): int
    {
        return $options['cost'] ?? $this->cost;
    }

    /**
     * Get the algorithm that should be used for hashing
     * 
     * @return int
     */
    protected function algorithm(): string
    {
        return PASSWORD_BCRYPT;
    }

    /**
     * Set default Bcrypt cost
     *
     * @param int $cost Default Bcrypt cost
     * @return self
     */
    public function setCost(int $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Set wheter performing an algorithm check
     *
     * @param bool $verifyAlgorithm Indicates wheter performing an algorithm check
     * @return self
     */
    public function setVerifyAlgorithm(bool $verifyAlgorithm): self
    {
        $this->verifyAlgorithm = $verifyAlgorithm;

        return $this;
    }
}
