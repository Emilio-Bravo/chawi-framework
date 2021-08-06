<?php

namespace Core\Http;

use App\Http\Kernel as AppKernel;

class Kernel extends AppKernel
{
    /**
     * Executes the route middleware if provided
     * 
     * @param array $route
     * @return void
     * 
     * @throws RuntimeException
     */
    public function evaulauteRoute(array $route): void
    {
        if (isset($route['middleware'])) {

            foreach ((array) $route['middleware'] as $middleware) {

                if (!$this->middlewareExists($middleware)) {

                    throw new \RuntimeException(
                        sprintf('Route middleware "%s" does not exist', $middleware)
                    );
                }

                $object = new $this->routeMiddlewares[$middleware];

                if (!$this->accomplishWithMiddlewareContract($object)) {

                    throw new \RuntimeException(
                        sprintf('The "handle" method does not exist in %s', $object::class)
                    );
                }

                $method = new \ReflectionMethod($object, 'handle');

                $result = $this->execute($object, $method);

                @$result->canProceed && $result !== false ?: exit;
            }
        }
    }

    /**
     * Executes the route middleware
     * 
     * @param object $middleware
     * @param ReflectionMethod $method
     * @return mixed
     */
    protected function execute(object $middleware, \ReflectionMethod $method)
    {
        $params = [];

        foreach ($method->getParameters() as $param) {

            $arg = (string) $param->getType();

            if (\class_exists($arg)) {

                if ($this->shouldBeInstanced($arg, $params)) {
                    $params[] = new $arg;
                }
            }
        }

        return \call_user_func(
            [$middleware, $method->getName()],
            ...$params
        );
    }

    /**
     * Determines wheter the current parameter should be intanced
     * 
     * @param string $class
     * @param array $params
     * @return bool
     */
    protected function shouldBeInstanced(string $class, array &$params): bool
    {
        if (\method_exists($class, '__construct')) {

            $reflection = new \ReflectionClass($class);
            $constructor = $reflection->getMethod('__construct');

            if ($constructor->isPrivate()) {
                $params[] = $this->canProceed();
                return false;
            }

            if (!empty((array) $constructor->getParameters())) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the middleware closure
     * 
     * @return callable
     */
    protected function canProceed(): callable
    {
        /**
         * Determines wheter the middleware returned success or not
         * 
         * @param object $obejct
         * @return object|false
         */
        return function (object &$object): object|false {

            if (is_subclass_of($object, \Core\Http\Middleware\Middleware::class)) {
                $object->canProceed = true;
                return $object;
            }

            return false;
        };
    }

    /**
     * Executes the app middlewares 
     * 
     * @return void
     * 
     * @throws RuntimeException
     */
    public function appRutine(): void
    {
        foreach (array_keys($this->middlewares) as $middleware) {

            $middleware = new $this->middlewares[$middleware];
            $method = new \ReflectionMethod($middleware, 'handle');

            if (!\method_exists($middleware, 'handle')) {

                throw new \RuntimeException(
                    sprintf('The "handle" method does not exist in %s', $middleware::class)
                );
            }

            if (!$this->execute($middleware, $method)) {
                exit;
            }
        }
    }

    /**
     * Wheter the middleware has been registered in App Kernel
     * 
     * @param string $middleware Middleware key
     * @return bool
     */
    protected function middlewareExists(string $middleware): bool
    {
        return \key_exists($middleware, $this->routeMiddlewares);
    }

    /**
     * Wheter the middleware accomplish with the "handle method" 
     * 
     * @param object $middleware
     * @return bool
     */
    protected function accomplishWithMiddlewareContract(object $middleware): bool
    {
        return \method_exists($middleware, 'handle');
    }
}
