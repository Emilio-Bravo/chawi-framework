<?php

namespace Core\Client\Authentification;

use Core\Config\Support\InteractsWithConfig;

trait hashesPasswords
{

    use InteractsWithConfig;

    private array $supportedHashers = [
        'argon' => \Core\Hashing\ArgonHasher::class,
        'bcrypt' => \Core\Hashing\BcryptHasher::class
    ];

    private array $defaultRules = [
        'verify' => true
    ];

    public function hash(string $password): string
    {
        $config = $this->getConfig();

        if (\in_array($config->driver, array_keys($this->supportedHashers))) {

            $hasher = $this->setHasher();

            return (string) $hasher->make($password, []);
        }
    }

    public function setHasher(): object
    {
        $config = $this->getConfig();

        return new $this->supportedHashers[$config->driver](
            array_merge($this->defaultRules, $config->{$config->driver})
        );
    }

    public function getConfig(): object
    {
        return $this->getConfigDirective('hashing');
    }

    public function verify(string $password, string $hashedValue): bool
    {
        $hasher = $this->setHasher();

        return (bool) $hasher->check($password, $hashedValue);
    }
}
