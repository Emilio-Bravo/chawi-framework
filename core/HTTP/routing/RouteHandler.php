<?php

namespace Core\Http\Routing;

class RouteHandler
{

    /**
     * The current route index
     * 
     * @var array
     */
    protected array $routeBag;

    /**
     * The route current method
     * 
     * @var string
     */
    protected string $method;

    /**
     * The route corresponding URI
     * 
     * @var string|array
     */
    protected string|array $uri;

    /**
     * Create a new RouteHandler instance
     * 
     * @param string|array $uri
     * @param array $routeBag
     */
    public function __construct(string|array $uri, array &$routeBag)
    {
        $this->routeBag = &$routeBag;
        $this->uri = $uri;
    }

    /**
     * Add a name to the selected route
     * 
     * @param string $name
     * @return self
     */
    public function name(string $name): self
    {
        $this->routeBag[$this->uri]['name'] = $name;

        return $this;
    }

    /**
     * Add a middleware to the selected route
     * 
     * @param string|array $middleware
     * @return self
     */
    public function middleware(string|array $middleware): self
    {
        if (!\is_array($this->uri)) {
            $this->routeBag[$this->uri]['middleware'] = $middleware;
            $this->routeBag[$this->uri]['middleware_route'] = $this->uri;
        } else {
            $this->setMultipleMiddlewares($middleware);
        }

        return $this;
    }

    /**
     * Adds a middleware to multiple routes
     * 
     * @param string|array $middleware
     * @return void
     */
    protected function setMultipleMiddlewares(string|array $middleware): void
    {
        foreach ($this->uri as $uri) {
            $uri = $uri->getUri();
            $this->setMethod($uri);
            $this->routeBag[$this->method][$uri]['middleware'] = $middleware;
            $this->routeBag[$this->method][$uri]['middleware_route'] = $uri;
        }
    }

    /**
     * Sets the route current method
     * 
     * @param string $component The selected route
     * @return void
     */
    protected function setMethod(string $component): void
    {
        foreach ($this->routeBag as $method) {
            if (\is_array($method) && \array_key_exists($component, $method)) {
                $this->method = key($this->routeBag);
            } else if (\array_key_exists($component, $this->routeBag)) {
                $this->method = key($this->routeBag);
            }
        }
    }

    /**
     * Add a prefix to a group of routes
     * 
     * @param string $prefix
     * @param Core\Http\Routing\RouteHandler $route
     * @return self
     */
    public function addPrefix(string $prefix, self $route): self
    {
        $sanitizedPath = RouteHelper::guessPath($route->getUri()) ?? $route->getUri();

        if (RouteHelper::hasParams($route->getUri())) {
            RouteHelper::fillParams($this->uri, $this->routeBag[$this->uri]);
        }

        $this->routeBag["/$prefix/$sanitizedPath"] = $this->routeBag[$route->getUri()];
        unset($this->routeBag[$this->getUri()]);

        $this->setUri("/$prefix/$sanitizedPath");

        return $this;
    }

    /**
     * Get the routeBag
     *
     * @return array
     */
    public function getRouteBag(): array
    {
        return $this->route;
    }

    /**
     * Get the route corresponding URI
     *
     * @return string
     */
    public function getUri(): string|array
    {
        return $this->uri;
    }

    /**
     * Get the route current method
     * 
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the route corresponding URI
     *
     * @param string|array $uri he route corresponding URI
     * @return self
     */
    public function setUri(string|array $uri): self
    {
        $this->uri = $uri;

        return $this;
    }
}
