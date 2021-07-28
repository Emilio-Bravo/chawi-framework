<?php

namespace Core\Http\Routing;

use ArrayObject;

class UriParamBag extends ArrayObject
{
    public function get(): array
    {
        return $this->getArrayCopy();
    }
}
