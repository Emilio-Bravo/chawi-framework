<?php

namespace Core\Http\Routing;

use ArrayObject;

class MethodParamBag extends ArrayObject
{
    public function get(): array
    {
        return $this->getArrayCopy();
    }
}
