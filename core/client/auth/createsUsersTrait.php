<?php

namespace Core\Client\Authentification;

use Core\Http\ResponseComplements\redirectResponse;

trait createsUsers
{

    use hashesPasswords;

    public function newUser(array $data)
    {

        $password = $this->config->auth_keys['password'];
        $user = $this->config->auth_keys['user'];

        $data[$password] = $this->hash($data[$password]);

        if ($this->userIsUnique($data[$user])) $this->model::insert($data);

        else return new redirectResponse('back');
    }

    private function userIsUnique(string $user): bool
    {
        return count($this->model::findAll(
            [$this->config->auth_keys['user'] => $user]
        )) < 1;
    }
}
