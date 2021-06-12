<?php

namespace Core\Foundation;

class Controller
{

    protected \Core\Client\View $view;
    protected \Core\Http\Response $response;

    public function __construct()
    {
        $this->view = new \Core\Client\View;
        $this->response = new \Core\Http\Response;
    }

    protected function render($view, array $vars = []): void
    {
        echo $this->view->render($view, $vars);
        \Core\Support\Flash::enable(); //Enbale flash sessions
    }

    protected function redirect(string $location = '/'): \Core\Http\Response
    {
        return $this->response->redirect($location);
    }

    protected function back(): \Core\Http\Response
    {
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    protected function validate(array $data_patern): void
    {
        $validator = new \Core\Support\Validator;
        $validator->validate($data_patern);
    }
}
