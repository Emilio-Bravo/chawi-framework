<?php

namespace Core\Http\Routing;

class RouteHelper
{
    /**
     * Returns the path without parameters
     * 
     * @param string $path
     * @return string|void
     */
    public static function guessPath(string $path)
    {
        if (preg_match_all('/{.*}/', $path)) {

            $sanitizedPath = preg_replace('/{.*}/', '', $path);

            return rtrim($sanitizedPath, '/');
        }
    }

    /**
     * Sets the route params fields
     * 
     * @param string $path
     * @param array $route
     * @return void
     */
    public static function fillParams(string $path, array &$route): void
    {
        if (preg_match_all('/{.*}/', $path, $matches)) {
            $route['params'] = explode(
                '/',
                preg_replace(
                    '/[{}]/',
                    '',
                    $matches[0][0]
                )
            );
        }
    }

    /**
     * Wheter the route has params
     * 
     * @param string $path
     * @return bool
     */
    public static function hasParams(string $path): bool
    {
        return preg_match('/{.*}/', $path);
    }
}
