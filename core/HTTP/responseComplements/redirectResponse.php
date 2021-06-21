<?php

namespace Core\Http\ResponseComplements;

class redirectResponse
{
    public function __construct(string $location, ?array $message, int $code = 200)
    {
        $reponse = new \Core\Http\Response(null, $code);
        return $reponse->redirect($location)->with(key($message), $message[0]);
    }
}
