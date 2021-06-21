<?php

namespace Core\Client\Authentification;

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

    public function auth(string $user_auth_key, string $password): \Core\Http\Response
    {

        $response = new \Core\Http\Response;

        $user = $this->model::find([
            $this->auth_keys['user_auth_key'] => $user_auth_key
        ]);

        if (is_object($user) && password_verify($password, $user->password)) {
            $this->setSession((array) $user);
            return $response->redirect()->withSuccess("Welcome {$user->name}");
        }

        return $response->redirect()->withError('Incorrect username and / or password');
    }

    public function newUser(array $data, string $password_key): void
    {

        $email = $data[$this->auth_keys['user_auth_key']];

        if ($this->emailIsUnique($email)) {
            $data[$password_key] = \Core\Support\Crypto::cryptoPassword($data[$password_key]);
            $this->model::insert($data);
        } else {
            exit((string) new \Core\Http\ResponseComplements\redirectResponse('/', [
                'error' => "$email is already in use"
            ], 500));
        }
    }

    public function setSession(array $data): void
    {
        \Core\Http\Persistent::create('user', (object) $data);
    }

    public function logout(): \Core\Http\Response
    {
        \Core\Http\Persistent::destroy('user');
        $response = new \Core\Http\Response;
        return $response->redirect();
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
}
