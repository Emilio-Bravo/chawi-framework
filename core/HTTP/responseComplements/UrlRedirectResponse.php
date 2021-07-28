<?php

namespace Core\Http\ResponseComplements;

use Core\Http\Response;

class UrlRedirectResponse extends Response
{
    /**
     * The response target url
     * 
     * @var string
     */
    protected string $targetUrl;

    /**
     * Creates a redirect response
     * 
     * @param string $url The full URL to redirect to
     * @param int $status The response status code, supported: (201, 301, 302, 303, 307, 308)
     * @param array $headers The response headers (Location already set)
     * @return void
     * 
     * @throws InvalidArgumentException
     */
    public function __construct(string $url = '/', int $status = 302, array $headers = [])
    {

        $this->setStatusCode($status);

        parent::__construct('', $status, $headers);

        $this->setTargetUrl($url);

        if (!$this->isRedirect()) {

            throw new \InvalidArgumentException(

                sprintf(
                    '%s is not an HTTP redirect status',
                    $status
                )

            );
        }

        if ($status === 301 && !\array_key_exists('cache-control', array_change_key_case($headers, \CASE_LOWER))) {
            $this->headers->remove('cache-control');
        }
    }

    /**
     * Sets the redirect target for the response
     * 
     * @param string $url
     * @return self
     */
    protected function setTargetUrl(string $url): self
    {
        $this->targetUrl = $url;

        $this->setContent(

            sprintf(
                '<!DOCTYPE html>
                <html>
                   <head>
                       <meta charset="UTF-8" />
                       <meta http-equiv="refresh" content="0;url=\'%1$s\'" />
                       <title>Redirecting to %1$s</title>
                   </head>
                   <body>
                       Redirecting to <a href="%1$s">%1$s</a>
                   </body>
                </html>',
                htmlspecialchars($this->targetUrl, \ENT_QUOTES, 'UTF-8')
            )
        );

        $this->headers->set('Location', $this->targetUrl);

        return $this;
    }

    /**
     * Get the value of targetUrl
     * 
     * @return string
     */
    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }
}
