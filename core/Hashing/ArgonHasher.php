<?php

namespace Core\Hashing;

use Core\Contracts\Hashing\HasherContract;

class ArgonHasher extends AbstractHasher implements HasherContract
{
    /**
     * Default Argon2 memory cost
     *
     * @var int
     */
    protected int $memory = PASSWORD_ARGON2_DEFAULT_MEMORY_COST;

    /**
     * Default Argon2 time cost
     *
     * @var int
     */
    protected int $time = PASSWORD_ARGON2_DEFAULT_TIME_COST;

    /**
     * Default Argon2 threads
     *
     * @var int
     */
    protected int $threads = PASSWORD_ARGON2_DEFAULT_THREADS;

    /**
     * Indicates whether performing an algorithm check
     *
     * @var bool
     */
    protected bool $verifyAlgorithm = false;

    /**
     * Create a new ArgonHasher instance
     *
     * @param array $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->memory = $options['memory'] ?? $this->memory;
        $this->time = $options['time'] ?? $this->time;
        $this->threads = $options['threads'] ?? $this->threads;
        $this->verifyAlgorithm = $php_errormsg['verify'] ?? $this->verifyAlgorithm;
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
            [
                'memory_cost' => $this->memory($options),
                'time_cost' => $this->time($options),
                'threads' => $this->threads($options)
            ]
        );

        is_string($hash) ?: throw new \RuntimeException('Argon2 hash not supported');

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
            [
                'memory_cost' => $this->memory($options),
                'time_cost' => $this->time($options),
                'threads' => $this->threads($options)
            ]
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
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] != 'argon2i') {
            throw new \RuntimeException('The password does not use Argon2i algorithm');
        }

        return parent::check($currentValue, $hashedValue);
    }

    /**
     * Get the memory cost value
     *
     * @param array $options
     * @return int
     */
    protected function memory(array $options): int
    {
        return $options['memory'] ?? $this->memory;
    }

    /**
     * Get the time cost value
     *
     * @param array $options
     * @return int
     */
    protected function time(array $options): int
    {
        return $options['time'] ?? $this->time;
    }

    /**
     * Get the thread´s value
     *
     * @param array $options
     * @return int
     */
    protected function threads(array $options): int
    {
        return $options['threads'] ?? $this->threads;
    }

    /**
     * Get the algorithm that should be used for hashing
     *
     * @return int
     */
    protected function algorithm(): string
    {
        return PASSWORD_ARGON2I;
    }

    /**
     * Set default Argon2 memory cost
     *
     * @param int $memory Default Argon2 memory cost
     * @return self
     */
    public function setMemory(int $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Set default Argon2 time cost
     *
     * @param int $time Default Argon2 time cost
     * @return self
     */
    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Set default Argon2 threads
     *
     * @param int $threads Default Argon2 threads
     * @return self
     */
    public function setThreads(int $threads): self
    {
        $this->threads = $threads;

        return $this;
    }

    /**
     * Set wheter performing an algorithm check
     *
     * @param bool $verifyAlgorithm Indicates whether performing an algorithm check
     * @return self
     */
    public function setVerifyAlgorithm(bool $verifyAlgorithm): self
    {
        $this->verifyAlgorithm = $verifyAlgorithm;

        return $this;
    }
}
