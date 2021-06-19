<?php

namespace Core\Http;

use Core\Foundation\Traits\Http\canMorphContent;
use Core\Foundation\Traits\Http\httpResponses;
use Core\Foundation\Traits\Http\responseMessages;
use Core\Foundation\Traits\Http\Renderable;

class Response
{

    use responseMessages, Renderable, canMorphContent, httpResponses;

    public function __construct($content = null, int $code = 200)
    {
        if ($this->canSetContent($content)) $this->setContent($content);
        $this->statusCode($code);
    }

    public function setContent($content): void
    {
        if ($this->shouldBeJson($content)) {
            $this->setHeader('Content-Type', 'application/json');
            $this->morphToJson($content);
        }
        $this->render($content);
    }
}
