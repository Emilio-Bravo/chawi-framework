<?php

namespace Core\Http\Routing;

use Core\Http\Server;

class Router
{

    /**
     * The current request URI
     * 
     * @var string
     */
    private string $uri;

    /**
     * The current request method
     * 
     * @var string
     */
    private string $method;

    /**
     * The current route method
     * 
     * @var string
     */
    private string $selectedMethod;

    /**
     * The route bag
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * The current request URI params
     * 
     * @var array
     */
    private array $uriParams = [];

    /**
     * The current route linked method
     * 
     * @var ReflectionMethod
     */
    private \ReflectionMethod $currentMethod;

    /**
     * The current route parameter bag
     * 
     * @var Core\Http\Routing\RouteParams
     */
    private RouteParams $routeParams;

    /**
     * Create a new route instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->setRouterInfo();
    }

    /**
     * Listens to incoming HTTP requests 
     * and executes the corresponding route
     * 
     * @return void
     */
    public function resolve()
    {
        $callback = @$this->routes[$this->method][$this->uri];

        if (\key_exists($this->uri, $this->routes[$this->method])) {

            if (empty($this->setUriParams()) && isset($this->routes[$this->method][$this->uri]['params'])) {
                return $this->notFound();
            }
        } else {
            return $this->notFound();
        }

        return $this->handle($callback);
    }

    /**
     * Handles the route callback
     * 
     * @param mixed $callback
     * @return mixed
     */
    protected function handle($callback)
    {
        $this->handleMiddlewares();

        if (is_array($callback)) {

            $ob = new $callback[0];

            $this->currentMethod = new \ReflectionMethod($ob, $callback[1]);

            $this->setParams();

            return call_user_func([$ob, $callback[1]], ...$this->routeParams);
        }
        return call_user_func($callback);
    }

    /**
     * Handles the route middlewares
     * 
     * @return void
     */
    protected function handleMiddlewares(): void
    {

        $middleware = new \Core\Http\Kernel;

        $middleware->appRutine();

        $currentRoute = @$this->routes[$this->method][$this->uri]['middleware_route'];

        if (isset($currentRoute) && $currentRoute === $this->uri) {

            try {
                $middleware->evaulauteRoute($this->routes[$this->method][$this->uri]);
            } catch (\RuntimeException $e) {
                exit($e->getMessage());
            }
        }
    }

    /**
     * Keeps the route params into the route
     * 
     * @return array
     */
    protected function setUriParams(): array
    {
        $params = @$this->routes[$this->method][$this->uri]['params'];

        !isset($params) ?: $this->proccessMethod($params);

        return $this->uriParams;
    }

    /**
     * Proccess the request method and its parameters
     * 
     * @param array $uriParams
     * @return void
     */
    protected function proccessMethod(array $uriParams): void
    {
        $expected = [];

        if (preg_match_all('/\?.*/', Server::completeUri(), $matches)) {

            $params = explode('&', str_replace('?', '', $matches[0][0]));

            array_walk($params, fn (&$param) => $param = preg_replace('/.*=/', '', $param));

            $expected = array_combine($uriParams, $params);
        }

        $this->uriParams = empty($expected) ? $this->uriParams : array_merge($this->uriParams, $expected);
    }

    /**
     * Sets the route params into the corresponding bag
     * 
     * @return void
     */
    protected function setParams(): void
    {
        $methodParams = $this->currentMethod->getParameters();
        $this->routeParams = new RouteParams($methodParams, $this->uriParams);
    }

    /**
     * Sets the HTTP request method and the request URI
     * 
     * @return void
     */
    protected function setRouterInfo(): void
    {
        $this->method = Server::method();
        $this->uri = preg_replace('/\?.*/', '', Server::uri()); //excepting get parameters
    }

    /**
     * Create a new GET route
     * 
     * @param string $path
     * @param mixed $callback
     * @return Core\Http\Routing\RouteHandler
     */
    public function get(string $path, $callback): RouteHandler
    {
        $this->selectedMethod = 'GET';
        $this->routes['GET'][$path] = $callback;
        $this->setParamsIndex($path, $callback);

        return new RouteHandler($path, $this->routes['GET']);
    }

    /**
     * Link routes to a middleware
     * 
     * @param string|array $middleware
     * @param Core\Http\Routing\RouteHandler $routes
     * @return void
     */
    public function inMiddleware(string|array $middleware, RouteHandler ...$routes): void
    {
        array_map(fn ($route) => $route->middleware($middleware), $routes);
    }

    /**
     * Create a new POST route
     * 
     * @param string $path
     * @param mixed $callback
     * @return Core\Http\Routing\RouteHandler
     */
    public function post(string $path, $callback): RouteHandler
    {
        $this->selectedMethod = 'POST';
        $this->routes['POST'][$path] = $callback;
        $this->setParamsIndex($path, $callback);

        return new RouteHandler($path, $this->routes['POST']);
    }

    /**
     * Add routes into a group
     * 
     * @param string $refix
     * @param Core\Http\Routing\RouteHandler $routes
     * @return Core\Http\Routing\RouteHandler
     */
    public function group(string $prefix, RouteHandler ...$routes): RouteHandler
    {

        foreach ($routes as $route) {
            $route = $route->addPrefix($prefix, $route);
            $routeContainer[] = $route;
        }

        return new RouteHandler($routeContainer, $this->routes);
    }

    /**
     * Adapts the URI to the be found in the routes array
     * and fills the params of the route
     * 
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    protected function setParamsIndex(string $path, $callback): void
    {
        if (RouteHelper::hasParams($path)) {

            $sanitizedPath = RouteHelper::guessPath($path);

            $this->routes[$this->selectedMethod][$sanitizedPath] = $callback;
            RouteHelper::fillParams($path, $this->routes[$this->selectedMethod][$sanitizedPath]);
        }
    }

    /**
     * Returns an HTTP 404 server response
     * 
     * @return Core\Http\Response
     */
    protected function notFound()
    {
        return new \Core\Http\Response('<h1>Not found</h1>', 404);
    }

    /**
     * Get the current request URI
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get the current request method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the current route method
     *
     * @return string
     */
    public function getSelectedMethod(): string
    {
        return $this->selectedMethod;
    }

    /**
     * Get the route bag
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get the current request URI params
     *
     * @return array
     */
    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    /**
     * Get the current route linked method
     *
     * @return ReflectionMethod
     */
    public function getCurrentMethod(): \ReflectionMethod
    {
        return $this->currentMethod;
    }



    /**
     * Get the current route parameter bag
     *
     * @return Core\Http\Routing\RouteParams
     */
    public function getRouteParams(): RouteParams
    {
        return $this->routeParams;
    }
}
