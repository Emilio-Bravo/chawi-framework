<?php

namespace Core\Client;

use Core\Config\Support\interactsWithValidatorConfig;
use Core\Http\Server;
use Core\Support\Flash;

class ViewHelper
{

    use interactsWithValidatorConfig;

    private object $config;

    public function __construct()
    {
        $this->config = $this->getValidatorConfig();
    }

    public function url(string $path): string
    {
        return Server::host() . Server::uri() . $path;
    }

    public function hasError(string $key): bool
    {
        return isset(Flash::init()->get('errors')[$key]);
    }

    public function getError(string $key): string
    {
        return Flash::init()->get('errors')[$key];
    }

    public function insertErrorHtmlTemplate(string $message): string
    {
        return <<<HTML
            <span class="text-danger" role="alert">
                <strong>{$message}</strong>
            </span>
        HTML;
    }

    public function insertHTML(string $html): string
    {
        return <<<HTML
            $html
        HTML;
    }

    public function method_field(string $method): string
    {
        return $this->insertHTML(
            sprintf(
                '<input type="hidden" name="method_%s" value="%s" />',
                $method,
                $method
            )
        );
    }

    public function errorTemplate(string $key)
    {
        if ($this->hasError($key)) {

            return \Core\Support\Formating\MsgParser::format(
                $this->config->error_template,
                $this->getError($key)
            );
        }
    }
}
