<?php

namespace Core\Http\Middleware;

use Core\Http\Request;
use Core\Http\ResponseComplements\UrlRedirectResponse;
use Core\Support\Validation\Validator;

abstract class Middleware
{
    /**
     * Determines wether the current middleware proccess
     * terminates successfully or not
     * 
     * @var bool
     */
    public bool $canProceed = false;

    /**
     * Performs an HTTP input validation
     * 
     * @param Core\Http\Request $request
     * @param array $data
     * @return Core\Support\Validator
     */
    protected function validate(Request $request, array $data): Validator
    {
        $validator = new Validator;
        return $validator->validate($request, $data);
    }

    /**
     * Performs a redirection response
     * 
     * @param string $location The url to redirect to
     * @param int $status The response status code, supported: (201, 301, 302, 303, 307, 308)
     * @param array $headers The response headers (Location already set)
     * @return Core\Http\Complements\UrlRedirectResponse
     */
    protected function redirect(string $location, int $status = 302, array $headers = []): UrlRedirectResponse
    {
        try {
            return new UrlRedirectResponse($location, $status, $headers);
        } catch (\InvalidArgumentException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Render a serve HTTP response
     * 
     * @param int $status
     * @param string|null $content
     * @param array $headers
     */
    protected function response(int $status, ?string $content = null, array $headers = [])
    {
        return new \Core\Http\Response($content, $status, $headers);
    }
}
