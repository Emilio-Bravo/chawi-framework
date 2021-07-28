<?php

namespace Core\Http\Routing;

class RouteMethodParams
{

    private MethodParamBag $methodParams;
    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->methodParams = new MethodParamBag;
        $this->setParams();
    }

    private function setParams()
    {
        foreach ($this->params as $param) {
            $class = (string) $param->getType();
            !class_exists($class) ?: $this->methodParams->append(new $class);
        }
    }

    public function get()
    {
        return $this->methodParams->get();
    }
}
