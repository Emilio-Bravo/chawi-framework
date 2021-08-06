<?php

namespace Core\Http\Routing;

class RouteParams implements \IteratorAggregate
{

    private RouteMethodParams $methodParams;
    private RouteUriParams $uriParams;

    public function __construct(array $methodParams, array $uriParams)
    {
        $this->methodParams = new RouteMethodParams($methodParams);
        $this->uriParams = new RouteUriParams($uriParams);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayObject(

            array_merge(
                $this->methodParams->get(),
                $this->uriParams->get()
            )

        );
    }
}
