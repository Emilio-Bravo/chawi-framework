<?php

namespace Core\Client\Authentification;

use Core\Http\ResponseComplements\redirectResponse;

class Auth
{
    private object $model;

    public array $error_msgs = [
        'error' => 'Incorrect username and / or password',
        'success' => 'Welcome'
    ];

    public array $auth_keys = [
        'user_auth_key' => 'email',
        'user_auth_password' => 'password'
    ];

    public function __construct($model)
    {
        $this->model = new $model;
    }

    public function auth(string $user_auth_key, string $password): redirectResponse
    {
        $user = $this->model::find([
            $this->auth_keys['user_auth_key'] => $user_auth_key
        ]);

        if (is_object($user) && password_verify($password, $user->password)) {
            $this->setSession((array) $user);
            return new redirectResponse('/', ['success' => "Welcome {$user->name}"]);
        }

        return new redirectResponse('back', [
            'error' => 'Incorrect username and / or password'
        ]);
    }

    public function newUser(array $data, string $password_key): void
    {

        $email = $data[$this->auth_keys['user_auth_key']];

        if ($this->emailIsUnique($email)) {
            $data[$password_key] = \Core\Support\Crypto::cryptoPassword($data[$password_key]);
            $this->model::insert($data);
        } else {
            exit((string) new redirectResponse('back', [
                'error' => "$email is already in use"
            ], 500));
        }
    }

    public function setSession(array $data): void
    {
        \Core\Http\Persistent::create('user', (object) $data);
    }

    public function logout(): redirectResponse
    {
        \Core\Http\Persistent::destroy('user');
        return new redirectResponse('/');
    }

    private function emailIsUnique(string $email): bool
    {
        return count(
            $this->model::findAll(
                [
                    $this->auth_keys['user_auth_key'] => $email
                ]
            )
        ) < 1;
    }

    public static function user()
    {
        return (object) \Core\Http\Persistent::get('user');
    }
}
