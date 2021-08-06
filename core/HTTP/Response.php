<?php

namespace Core\Http;

use Core\Foundation\Traits\Http\canMorphContent;
use Core\Foundation\Traits\Http\httpResponses;
use Core\Foundation\Traits\Http\responseMessages;
use Core\Foundation\Traits\Http\Renderable;
use Core\Http\ResponseComplements\HeaderBag;

class Response
{
    use responseMessages, Renderable, canMorphContent, httpResponses;

    /**
     * Response content
     * 
     * @var mixed
     */
    protected $content;

    /**
     * The current http protocol for the response
     * 
     * @var string
     */
    protected string $httpProtocolVersion;

    /**
     * The corresponding status code text
     * 
     * @var string
     */
    protected string $statusText;

    /**
     * The response status code
     * 
     * @var int
     */
    protected int $statusCode = 200;

    /**
     * The response charset
     * 
     * @var string
     */
    protected string $charset;

    /**
     * The response headers
     * 
     * @var Core\Http\Complements\HeaderBag
     */
    public HeaderBag $headers;

    /**
     * Response current charset
     */
    const CHARSET = 'UTF-8';

    /**
     * Status codes corresponding texts
     * 
     * @var array
     */
    protected array $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];

    /**
     * Http cache control directives
     * 
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control 
     * @var array
     */
    protected array $HttpResponseCacheControlDirectives = [
        'must_revalidate' => false,
        'no_cache' => false,
        'no_store' => false,
        'no_transform' => false,
        'public' => false,
        'private' => false,
        'proxy_revalidate' => false,
        'max_age' => true,
        's_maxage' => true,
        'immutable' => false,
        'last_modified' => true,
        'etag' => true,
    ];

    public const HTTP_CONTINUE = 100;
    public const HTTP_SWITCHING_PROTOCOLS = 101;
    public const HTTP_PROCESSING = 102;            // RFC2518
    public const HTTP_EARLY_HINTS = 103;           // RFC8297
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_RESET_CONTENT = 205;
    public const HTTP_PARTIAL_CONTENT = 206;
    public const HTTP_MULTI_STATUS = 207;          // RFC4918
    public const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    public const HTTP_IM_USED = 226;               // RFC3229
    public const HTTP_MULTIPLE_CHOICES = 300;
    public const HTTP_MOVED_PERMANENTLY = 301;
    public const HTTP_FOUND = 302;
    public const HTTP_SEE_OTHER = 303;
    public const HTTP_NOT_MODIFIED = 304;
    public const HTTP_USE_PROXY = 305;
    public const HTTP_RESERVED = 306;
    public const HTTP_TEMPORARY_REDIRECT = 307;
    public const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_NOT_ACCEPTABLE = 406;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_CONFLICT = 409;
    public const HTTP_GONE = 410;
    public const HTTP_LENGTH_REQUIRED = 411;
    public const HTTP_PRECONDITION_FAILED = 412;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    public const HTTP_REQUEST_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const HTTP_EXPECTATION_FAILED = 417;
    public const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    public const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    public const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    public const HTTP_LOCKED = 423;                                                      // RFC4918
    public const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    public const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    public const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    public const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    public const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;
    public const HTTP_GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    public const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    public const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    public const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    public const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * Renderizes a server response
     * 
     * @param mixed $content content to be renderized
     * @param int $code response code
     */
    public function __construct($content = null, int $code = 200, array $headers = [])
    {
        $this->headers = new HeaderBag($headers);
        $this->charset = 'UTF-8';
        $this->statusCode = $code;
        $this->content = $content;
        $this->httpProtocolVersion = '1.0';
    }

    /**
     * Renderizes the response
     * 
     * @return void
     */
    public function __destruct()
    {
        if ($this->canSetContent($this->content)) {
            $this->setContent($this->content, $this->statusCode);
        }
    }

    /**
     * Returns an HTTP response string
     * 
     * @return string
     */
    public function __toString(): string
    {
        return
            sprintf('HTTPS/%s %s %s', $this->httpProtocolVersion, $this->statusCode, $this->statusText) . "\r\n" .
            $this->headers . "\r\n" .
            $this->getContent();
    }

    /**
     * If the content is an array, it would be morphed to json
     * 
     * @param mixed $content
     * @return void
     */
    public function setContent($content, ?int $code = null): void
    {
        $this->content = $content;

        if (!is_null($code)) {
            $this->setStatusCode($code);
        }

        if ($this->shouldBeJson($this->content)) {
            $this->headers->set('Content-Type', 'application/json');
            $this->content = $this->morphToJson($content);
        }

        $this->setFileMimeType();
        $this->prepare()->sendHeaders();
        $this->render($this->content);
    }

    /**
     * Analyzes the response headers and prepares the response
     * 
     * @return self
     */
    public function prepare(): self
    {
        if ($this->statusCode >= 100 && $this->statusCode < 200 || in_array($this->statusCode, [204, 304])) { //informational or empty

            $this->headers->remove('Content-Type');  //Remove content related headers
            $this->headers->remove('Content-Length');

            // prevent PHP from sending the Content-Type header based on default_mimetype
            ini_set('default_mimetype', '');
        }

        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', "text/html; charset=$this->charset");
        }

        if (str_contains($this->headers->get('Content-Type'), 'text/') && !str_contains($this->headers->get('Content-Type'), 'charset')) {
            $this->headers->set('Content-Type', $this->headers->get('Content-Type') . "; charset=$this->charset");
        }

        if ($this->headers->has('Transfer-Encoding')) $this->headers->remove('Content-Length');

        if (\Core\Http\Server::get('SERVER_PROTOCOL') !== 'HTTP:/1.0') {
            $this->setHttpProtocolVersion('1.1');
        }

        /*
        if (!$this->headers->has('Connection')) {
            $this->setConnectionType('keep-alive');
        }
        */

        // Check if we need to send extra expire info headers
        if ('1.0' == $this->getHttpProtocolVersion() && str_contains($this->headers->get('Cache-Control'), 'no-cache')) {
            $this->headers->set('pragma', 'no-cache');
            $this->headers->set('expires', -1);
        }

        $this->setCache(

            array_intersect(
                $this->headers->all(),
                $this->HttpResponseCacheControlDirectives
            )

        );

        return $this;
    }

    /**
     * Sets the status code for the current response
     * 
     * @param int $code
     * @return void
     */
    protected function setStatusCode(int $code): self
    {
        if (\in_array($code, array_keys($this->statusTexts))) {
            $this->statusCode = $code;
            $this->statusText = $this->statusTexts[$code];
        }

        return $this;
    }

    /**
     * Sends the response headers
     * 
     * @return void
     */
    protected function sendHeaders(): void
    {
        if (!headers_sent()) {

            foreach ($this->headers as $header => $value) {
                $this->setHeader($header, $value, true, $this->statusCode);
            }

            foreach ($this->headers->getCookies() as $cookie) {
                $this->setHeader('Set-Cookie', $cookie, true, $this->statusCode);
            }

            header(sprintf('HTTP/%s %s %s', $this->httpProtocolVersion, $this->statusCode, $this->statusText), true, $this->statusCode);
        }
    }

    /**
     * In case that the content is an stored file, the response Content-Type will be adapted the current file
     * 
     * @return void
     */
    protected function setFileMimeType(): void
    {
        if ($this->content instanceof \Core\Http\Complements\StoredFile) {
            $this->headers->set('Content-Type', $this->content->type());
            $this->headers->set('Content-Length', $this->content->size());
        }
    }

    /**
     * Sets the Connection header
     * 
     * @param int $timeout sets the timeout for a keep-alive connection
     * @param int $max sets a limit of requests for a keep-alive connection
     * @return void
     */
    protected function setConnectionType(string $type, int $timeout = 5, int $max = 99): void
    {
        if (\in_array($type, ['keep-alive', 'close'])) {

            $this->headers->set('Connection', $type);

            if ($type === 'keep-alive') $this->headers->set(
                'keep-alive',
                sprintf('timeout=%d, max=%d', $timeout, $max)
            );
        }
    }

    /**
     * Sets the response cache headers
     * 
     * @param array $options
     * @return self
     * 
     * @throws InvalidArgumentException
     */
    protected function setCache(array $options): self
    {
        $notSupported = array_diff(array_keys($options), array_keys($this->HttpResponseCacheControlDirectives));

        if (!empty($notSupported)) {

            throw new \InvalidArgumentException(
                sprintf(
                    "The response does not support the following options %s",
                    implode('", "', $notSupported)
                )
            );
        }

        !isset($options['last_modified']) ?: $this->setLastModified($options['last_modified']);

        !isset($options['max_age']) ?: $this->setMaxAge($options['max_age']);

        !isset($options['etag']) ?: $this->setETag($options['etag']);

        !isset($options['s_maxage']) ?: $this->setSharedMaxAge($options['s_maxage']);

        !isset($options['no_store']) ?: $this->setNoStore($options['no_store']);

        if (isset($options['public'])) {
            if ($options['public']) $this->setCacheControlPublic();
        }

        if (isset($options['private'])) {
            if ($options['private']) $this->setCacheControlPrivate();
        }

        foreach ($this->HttpResponseCacheControlDirectives as $directive => $value) {

            if ($value && isset($options[$directive])) {
                $this->headers->addCacheControlDirective(
                    str_replace('_', '-', $directive)
                );
            } else {
                $this->headers->removeCacheControlDirective(
                    str_replace('_', '-', $directive)
                );
            }
        }

        foreach ($options as $key => $value) {
            $this->headers->remove($key);
        }

        return $this;
    }

    protected function getMaxAge(): ?int
    {
        if ($this->headers->hasCacheControlDirective('s-maxage')) {
            return (int) $this->headers->getCacheControlDirective('s-maxage');
        }

        if ($this->headers->hasCacheControlDirective('max-age')) {
            return (int) $this->headers->getCacheControlDirectives('s-maxage');
        }

        if (!is_null($this->getExpires())) {
            return (int) $this->getExpires()->format('U') - (int) $this->headers->getAsDate('Date')->format('U');
        }

        return null;
    }

    protected function ensureIEOverSSLCompatibility(Request $request): void
    {
        if (str_contains($this->headers->get('Content-Disposition') ?? '', 'attachment') && preg_match('/MSIE (.*?);/i', $request->server->get('HTTP_USER_AGENT') ?? '', $match)) {
            if ((int) preg_replace('/(MSIE )(.*?);/', '$2', $match[0]) < 9) {
                $this->headers->remove('Cache-Control');
            }
        }
    }

    /**
     * Returns the age of the response in seconds
     * 
     * @return int
     */
    protected function getAge(): int
    {
        if (!is_null($age = $this->headers->get('Age'))) {
            return (int) $age;
        }

        return max(time() - (int) $this->headers->getAsDate('Date')->format('U'), 0);
    }

    protected function getExpires()
    {
        try {
            return $this->headers->getAsDate('Expires');
        } catch (\RuntimeException $e) {
            // according to RFC 2616 invalid date formats (e.g. "0" and "-1") must be treated as in the past
            return \DateTime::createFromFormat('U', time() - 172800);
        }
    }

    /**
     * Get the Vary header contents
     * 
     * @return array|false
     */
    protected function getVary(): array|false
    {
        if ($this->headers->has('Vary')) {
            return explode(', ', $this->headers->get('Vary'));
        }

        return false;
    }

    /**
     * Sets the Expires HTTP header
     * 
     * @return self
     */
    protected function setExpires(?\DateTimeInterface $date = null): self
    {
        if (is_null($date)) {
            $this->headers->remove('Expires');
            return $this;
        }

        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->headers->set('Expires', $date->format('D, M Y H:i:s') . ' GMT');

        return $this;
    }

    /**
     * Sets Date header
     * 
     * @return void
     */
    protected function setDate(): void
    {
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->headers->set('Date', $date->format('D, M Y H:i:s') . ' GMT');
    }

    /**
     * Sets the ETag value
     * 
     * @param string|null $etag ETag unique identifier or null to remove the header
     * @param bool $weak Whether you want a weak ETag or not
     * @return self
     */
    protected function setETag(?string $etag = null, bool $weak = false): self
    {
        if (is_null($etag)) {
            $this->headers->remove('ETag');
            return $this;
        }

        if (!str_contains('"', $etag)) $etag = '"' . $etag . '"';

        $this->headers->set('ETag', !$weak ?: "W/$etag");

        return $this;
    }

    /**
     * Sets the response Last-Modified header
     * 
     * @return void
     */
    protected function setLastModified(?\DateTimeInterface $date = null): self
    {
        if (is_null($date)) {
            $this->headers->remove('Last-Modified');
            return $this;
        }

        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->headers->set('Last-Modified', $date->format('D, M Y H:i:s') . ' GMT');

        return $this;
    }

    /**
     * Sets an appropaite 304 response
     * 
     * @return void
     */
    protected function setNotModified(): void
    {
        $this->setContent(null, 304);

        $notSupportedHeaders = [
            'Allow',
            'Content-Encoding',
            'Content-Language',
            'Content-Length',
            'Content-MD5',
            'Content-Type',
            'Last-Modified'
        ];

        array_map(fn ($header) => $this->headers->remove($header), $notSupportedHeaders);
    }


    /**
     * Marks a response as safe according to RFC8674.
     *
     * @see https://tools.ietf.org/html/rfc8674
     */
    protected function setContentSafe(bool $safe = true): void
    {
        if ($safe) {
            $this->headers->set('Preference-Applied', 'safe');
        } else if ($this->headers->get('Preference-Applied') === 'safe') {
            $this->headers->remove('Preference-Applied');
        }

        $this->setVary('Prefer');
    }

    /**
     * Returns the response's time-to-live in seconds.
     * It returns null when no freshness information is present in the response.
     * When the responses TTL is <= 0, the response may not be served from cache without first
     * revalidating with the origin.
     *
     * @return null|int
     */
    protected function getTtl(): ?int
    {
        $maxAge = $this->getMaxAge();

        return !is_null($maxAge) ? $maxAge - $this->getAge() : null;
    }

    /**
     * Sets the time to live for shared caches in seconds
     * 
     * @return self
     */
    protected function setTtl(int $seconds): self
    {
        $this->setSharedMaxAge($this->getAge() + $seconds);

        return $this;
    }

    /**
     * Set Vary headers
     * 
     * The Vary HTTP response header determines how to match the headers of future requests to decide 
     * if a cached response can be used instead of requesting a new one from the origin server. 
     * This is used by the server to indicate which headers it uses when selecting a resource representation in a
     * content negotiation algorithm.
     * The Vary header must be set to a 304 Not Modified response exactly as it would have been
     * set to an equivalent 200 OK response.
     * 
     * @param string $headers
     * @return self
     */
    protected function setVary(string $headers): self
    {
        $this->headers->set('Varty', $headers);

        return $this;
    }

    /**
     * The response may be stored only by a browser's cache, even if the response is normally non-cacheable. 
     * If you mean to not store the response in any cache, use no-store instead. 
     * This directive is not effective in preventing caches from storing your response.
     * 
     * @return self
     */
    protected function setCacheControlPrivate(): self
    {
        $this->headers->removeCacheControlDirective('public');
        $this->headers->addCacheControlDirective('private');

        return $this;
    }

    /**
     * The response may be stored by any cache, 
     * even if the response is normally non-cacheable.
     * 
     * @return self
     */
    protected function setCacheControlPublic(): self
    {
        $this->headers->removeCacheControlDirective('private');
        $this->headers->addCacheControlDirective('public');

        return $this;
    }
    /**
     * Sets an immutable cache
     * 
     * @return self
     */
    protected function setCacheControlInmutable(bool $immutable = true): self
    {
        $immutable
            ? $this->headers->addCacheControlDirective('immutable')
            : $this->headers->removeCacheControlDirective('immutable');

        return $this;
    }

    /**
     * The response may not be stored in any cache. 
     * Note that this will not prevent a valid pre-existing cached response being returned. 
     * Clients can set max-age=0 to also clear existing cache responses, 
     * as this forces the cache to revalidate with the server 
     * (no other directives have an effect when used with no-store).
     * 
     * @param bool $store The response should be cached?
     * @return self
     */
    protected function setNoStore(bool $no_store = true): self
    {
        $no_store
            ? $this->headers->addCacheControlDirective('no-store')
            : $this->headers->removeCacheControlDirective('no-store');

        return $this;
    }

    /**
     * Sets the number of seconds after which the response 
     * should no longer be considered fresh.
     * 
     * @return self
     */
    protected function setMaxAge(int $value): self
    {
        $this->headers->addCacheControlDirective('max-age', $value);

        return $this;
    }

    /**
     * Sets the number of seconds after which the response should 
     * no longer be considered fresh by shared caches.
     *
     * @return self
     */
    protected function setSharedMaxAge(int $value): self
    {
        $this->setCacheControlPublic();
        $this->headers->addCacheControlDirective('s-maxage', $value);

        return $this;
    }

    /**
     * Indicates that once a resource becomes stale, 
     * caches must not use their stale copy without 
     * successful validation on the origin server.
     * 
     * @param bool $revalidate
     * @return self
     */
    protected function setMustRevalidate(bool $revalidate = true): self
    {
        $revalidate
            ? $this->headers->addCacheControlDirective('must-revalidate')
            : $this->headers->removeCacheControlDirective('must-revalidate');

        return $this;
    }

    /**
     * Determines wheter the response is cacheable
     * 
     * @return bool
     * @see https://developer.mozilla.org/es/docs/Web/HTTP/Headers/Cache-Control
     */
    protected function isCacheable(): bool
    {
        if (!\in_array($this->statusCode, [301, 302, 307, 308, 410])) return false;

        if ($this->headers->hasCacheControlDirective('no-store')) return false;

        return $this->isValidateable();
    }

    /**
     * Determines wheter the response is a redirect
     * 
     * @param string|null $location 
     * @return bool
     */
    public function isRedirect(string $location = null): bool
    {
        return \in_array($this->statusCode, [201, 301, 302, 303, 307, 308]) && (is_null($location) ?: $location == $this->headers->get('Location'));
    }


    /**
     * Determines wheter the response is invalid
     * 
     * @return bool
     */
    public function isInvalid(): bool
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    /**
     * Determines wheter response informative
     *
     * @return bool
     */
    public function isInformational(): bool
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }

    /**
     * Wheter the response successful
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * Wheter the respinse is a redirection
     *
     * @return bool
     */
    public function isRedirection(): bool
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    /**
     * Wheter the response has a client error
     *
     * @return bool
     */
    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Wheter the server has an internal error
     *
     * @return bool
     */
    public function isServerError(): bool
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    /**
     * Wheter the respinse is ok
     *
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->statusCode === 200;
    }

    /**
     * Wheter the response forbidden
     *
     * @return bool
     */
    public function isForbidden(): bool
    {
        return 403 === $this->statusCode;
    }

    /**
     * Wheter the response is a not found error
     *
     * @return bool
     */
    public function isNotFound(): bool
    {
        return 404 === $this->statusCode;
    }


    /**
     * Determines wheter the reponse is validateble
     * 
     * @return bool
     */
    protected function isValidateable(): bool
    {
        return $this->headers->has('Last-Modified') || $this->headers->has('ETag');
    }

    /**
     * Get response content
     * 
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the current HTTP protocol
     * 
     * @return string
     */
    protected function getHttpProtocolVersion(): string
    {
        return $this->httpProtocolVersion;
    }

    /**
     * Get the corresponding status code text
     *
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->statusText;
    }

    /**
     * Get the response status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get the response headers
     *
     * @return Core\Http\Complements\HeaderBag
     */
    public function getHeaders(): HeaderBag
    {
        return $this->headers;
    }


    /**
     * Set the current http protocol for the response
     *
     * @param string  $httpProtocolVersion  The current http protocol for the response
     * @return self
     */
    public function setHttpProtocolVersion(string $httpProtocolVersion): self
    {
        $this->httpProtocolVersion = $httpProtocolVersion;

        return $this;
    }

    /**
     * Set the corresponding status code text
     *
     * @param string  $statusText  The corresponding status code text
     * @return self
     */
    public function setStatusText(string $statusText): self
    {
        $this->statusText = $statusText;

        return $this;
    }

    /**
     * Get the response charset
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }
}
