<?php

namespace Core\Http\Routing;

class RouteUriParams
{
    private UriParamBag $uriParams;
    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->uriParams = new UriParamBag;
        $this->setParams();
    }

    private function setParams(): void
    {
        array_map(fn ($param) => $this->uriParams->append($param), $this->params);
    }

    public function get()
    {
        return $this->uriParams->get();
    }
}
