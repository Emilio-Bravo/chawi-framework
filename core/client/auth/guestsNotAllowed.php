<?php

namespace Core\Client\Authentification;

trait guestsNotAllowed
{

    public function __construct()
    {
        parent::__construct();
        $this->isAuthenticated();
    }

    private function isAuthenticated()
    {
        if (!\Core\Http\Persistent::get('user')) {
            
            $response = new \Core\Http\Response;
            
            $response->redirect(
                isset($this->redirect_path) ? $this->redirect_path : '/user/login'
            );
        }
    }
}
