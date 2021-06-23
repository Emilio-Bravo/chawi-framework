<?php

namespace Core\Http\ResponseComplements;

class redirectResponse
{

    private string $location = '/';
    private ?array $message;
    private int $code = 200;
    private \Core\Http\Response $response;

    public function __construct(string $location = '/', ?array $message = null, int $code = 200)
    {
        $this->response = new \Core\Http\Response;
        $this->location = $location;
        $this->message = $message;
        $this->code = $code;
        $this->proccessLocation();
    }

    public function __destruct()
    {
        return $this->response->redirect($this->location, $this->code)->with(
            key($this->message),
            array_values($this->message)[0]
        );
    }

    public function proccessLocation(): void
    {
        if ($this->location === 'back') $this->location = \Core\Http\Server::referer();
    }
}
