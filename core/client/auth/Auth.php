<?php

namespace Core\Client\Authentification;

use Core\Config\Support\interactsWithAuthConfig;
use Core\Http\Persistent;

class Auth
{
    use AuthenticatesUsers, createsUsers;
    use interactsWithAuthConfig;

    private object $model;
    private object $config;

    public function __construct($model)
    {
        $this->model = new $model;
        $this->config = $this->getAuthConfig();
    }

    public static function user(): object
    {
        return (object) Persistent::get('user');
    }

    public static function isAuthenticated(): bool
    {
        return Persistent::has('user');
    }
}
