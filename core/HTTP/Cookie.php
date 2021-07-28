<?php

namespace Core\Http;

use Core\Contracts\Http\CookieContract;
use Core\Http\Complements\AbstractCookie;

/**
 * Create a Cookie
 * 
 * @see https://developer.mozilla.org/es/docs/Web/HTTP/Cookies
 */
class Cookie extends AbstractCookie implements CookieContract
{
    /**
     * Cookie name
     * 
     * @var string
     */
    protected string $name;

    /**
     * Cookie value
     * 
     * @var string
     */
    protected ?string $value;

    /**
     * Cookie supported path
     * 
     * @var string
     */
    protected string $path;

    /**
     * Cookie supported domain
     * 
     * @var string
     */
    protected ?string $domain;

    /**
     * Cookie samesite
     * 
     * @var string
     */
    protected ?string $sameSite;

    /**
     * Wheter cookie is secure or not
     * 
     * @var bool
     */
    protected bool $secure;

    /**
     * Wheter the cookie only should sent to the server
     * 
     * @var bool
     */
    protected bool $httpOnly;

    /**
     * Wheter cookie should be sent without url encoding
     * 
     * @var bool
     */
    protected bool $raw;

    /**
     * Cookie expiration time
     * 
     * @var int
     */
    protected int $expire;

    /**
     * Cookie samesite terms
     * 
     * @var array
     */
    private array $sameSiteTerms = [
        'lax',
        'strict',
        'none'
    ];

    /**
     * Cookie reserverd chars
     */
    private const RESERVED_CHARS = [
        '=', ',', ';',
        ' ', "\t", "\r",
        "\n", "\v", "\f"
    ];

    /**
     * Cookie reserved chars replacement
     */
    private const RESERVED_CHARS_REPLACEMENT = [
        '%3D', '%2C', '%3B',
        '%20', '%09', '%0D',
        '%0A', '%0B', '%0C'
    ];

    /**
     * @param string $name cookie name
     * @param string $value cookie value
     * @param int|string $expire cookie expiration date
     * @param string $path indicates a URL path that must exist in the requested URL to send the header. The% x2F character ("/") is considered a directory separator, and subdirectories will match as well
     * @param string $domain the Domain and Path directives define the scope of the cookie: to which URLs the cookies should be sent
     * @param bool $secure a secure cookie is only sent to the server with an encrypted request over the HTTPS protocol.
     * @param bool $httpOnly to prevent cross-site scripting (XSS) attacks, HttpOnly cookies are inaccessible from the Document.cookie Javascript API; They are only sent to the server. 
     * @param bool $raw send a cookie without url encoding
     * @param string $sameSite for more info see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite
     */
    public function __construct(string $name, ?string $value, $expire = 0, string $path = '/', ?string $domain = null, bool $secure = false, bool $httpOnly = false, bool $raw = false, ?string $sameSite = 'lax')
    {
        $this->name = $name;
        $this->value = $value;
        $this->expire = $this->expiresTimeStamp($expire);
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->raw = $raw;
        $this->sameSite = $sameSite;
    }

    /**
     * Returns the complete cookie format
     * 
     * @return string
     */
    public function __toString(): string
    {
        if ($this->raw) $cookie = $this->name;

        else $cookie = str_replace(self::RESERVED_CHARS, self::RESERVED_CHARS_REPLACEMENT, $this->name); //Replacing reserved chars

        $cookie .= "=";

        if ($this->value === null) {
            $cookie .= 'deleted; expires=' . gmdate('D, d-M-Y H:i:s T', time() - 31536001) . '; Max-Age=0';
        } else {

            $cookie .= $this->raw ? $this->value : rawurlencode($this->value);

            $this->expire === 0 ?: $cookie .= '; expires=' . gmdate('D, d-M-Y H:i:s T', $this->expire) . "; Max-Age={$this->getMaxAge()}";
        }

        $this->setOptionalDetails($cookie);

        return $cookie;
    }

    /**
     * Sets the optional details of the cookie
     * 
     * @param string $str
     * @return void
     */
    protected function setOptionalDetails(string &$str): void
    {

        $str .= "; path=$this->path";

        is_null($this->domain) ?: $str .= "; domain=$this->domain";

        if ($this->secure) $str .= '; secure';

        if ($this->httpOnly) $str .= '; httponly';

        $this->evaluateSameSite($str);
    }

    /**
     * Get the cookie expires time stamp
     * 
     * @param int expire
     * @return int
     */
    protected function expiresTimeStamp(int $expire = 0): int
    {
        if ($expire instanceof \DateTimeInterface) $expire = $expire->format('U');

        if (!is_numeric($expire)) $expire = strtotime($expire);

        return $expire > 0 && false !== $expire ? (int) $expire : 0;
    }

    /**
     * Get the cookie max age
     * 
     * @return int
     */
    protected function getMaxAge(): int
    {
        $maxAge = $this->expire - time();

        return 0 >= $maxAge ? 0 : $maxAge;
    }


    /**
     * Evauluates the cookie samesite terms
     * 
     * @param string $str
     * @return void
     */
    protected function evaluateSameSite(&$str): void
    {
        if (in_array($this->sameSite, $this->sameSiteTerms)) {

            $str .= "; samesite=$this->sameSite";

            if ($this->sameSite == 'none' && !str_contains($str, 'secure')) {
                $str .= '; secure';
            }
        }
    }

    /**
     * Get cookie name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get cookie value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get cookie supported path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get cookie supported domain
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Get cookie samesite
     *
     * @return string
     */
    public function getSameSite(): string
    {
        return $this->sameSite;
    }

    /**
     * Get wheter cookie is secure or not
     *
     * @return bool
     */
    public function getSecure(): bool
    {
        return $this->secure;
    }

    /**
     * Get wheter the cookie only should sent to the server
     *
     * @return bool
     */
    public function getHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    /**
     * Get wheter cookie should be sent without url encoding
     *
     * @return bool
     */
    public function getRaw(): bool
    {
        return $this->raw;
    }

    /**
     * Get cookie expiration time
     *
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }
}
