<?php

namespace Core\Client\Authentification;

trait guestsNotAllowed
{

    public function __construct()
    {
        parent::__construct();
        $this->mustBeAuthenticated();
    }

    private function mustBeAuthenticated(): void
    {
        if (!\Core\Http\Persistent::get('user')) {

            $response = new \Core\Http\Response;

            exit((string) $response->redirect(
                isset($this->redirect_path) ? $this->redirect_path : '/user/login'
            ));
        }
    }
}
