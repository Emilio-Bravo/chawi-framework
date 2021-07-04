<?php

namespace Core\Client\Authentification;

use Core\Config\Support\interactsWithAuthConfig;

/**
 * User will be redirected to a custom location if provided
 * by adding the property redirectGuestTo and giving it a value,
 * otherwise user will be redirected to route /user/login
 */

trait guestsNotAllowed
{

    use interactsWithAuthConfig;

    private object $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = $this->getAuthConfig();
        $this->mustBeAuthenticated();
    }

    private function mustBeAuthenticated(): void
    {
        if (!\Core\Http\Persistent::get($this->config->session['key'])) {

            exit(new \Core\Http\ResponseComplements\redirectResponse(
                $this->redirectGuestTo ?? '/user/login',
                ['error' => 'You need to be identified']
            ));
            
        }
    }
}
