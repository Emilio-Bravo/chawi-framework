<?php

namespace Core\Http;

class Router
{

    private Request $request;
    private string $uri;
    private string $method;

    public function __construct()
    {
        $this->request = new Request;
    }

    public array $routes = [];

    public function resolve()
    {
        $this->setRouterInfo();
        $callback = $this->routes[$this->method][$this->uri];
        return $this->handle($callback);
    }

    public function handle($callback, ...$args)
    {
        if (is_array($callback)) {
            $ob = new $callback[0];
            return call_user_func([$ob, $callback[1]], empty($args) ? new Request : $args);
        }
        return call_user_func($callback);
    }

    public function setRouterInfo(): void
    {
        $this->method = $this->request->getMethod();
        $this->uri = $this->request->getURI();
    }

    public function toRegex(string $str): string
    {
        $str = stripcslashes($str);
        return str_pad($str, strlen($str), '/', STR_PAD_BOTH);
    }

    public function get(string $path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }
}
