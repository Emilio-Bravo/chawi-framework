<?php

namespace Core\Foundation;

use Core\Http\Response;
use Core\Client\View;
use Core\Support\Validation\Validator;

class Controller
{
    protected View $view;
    protected Response $response;

    public function __construct()
    {
        $this->view = new View;
        $this->response = new Response;
    }

    protected function render($view, array $vars = [], $code = 200, array $headers = []): void
    {
        new Response($this->view->render($view, $vars), $code, $headers);

        \Core\Support\Facades\Flash::enable();
    }

    protected function redirect(string $location = '/'): Response
    {
        return $this->response->redirect($location);
    }

    protected function back(): Response
    {
        return $this->redirect(\Core\Http\Server::referer());
    }

    protected function validate(\Core\Http\Request $request, array $data_patern): Validator
    {
        $validator = new Validator;
        return $validator->validate($request, $data_patern);
    }
}
