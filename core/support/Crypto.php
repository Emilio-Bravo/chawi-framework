<?php

namespace Core\Support;


/**
 * Handles encryption
 * @author Emilio Bravo
 */

class Crypto
{

    const CRYPTO_LENGTH = 5;

    protected static $charset = "abcdefghijklmnopqrstpuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTPUVWXYZ";
    protected static $code;

    /**
     * Generates a unique charset
     */
    private static function cryptoCryptGenerate()
    {
        for ($i = 0; $i < self::CRYPTO_LENGTH; $i++) {
            self::$code .= substr(self::$charset, rand(0, 61), 1);
        }
    }

    /**
     * Transforms an string into a unique randomized string
     */
    public static function cryptoStr(&$str)
    {
        $str = self::cryptoCryptGenerate();
    }

    /**
     * Generates an appropiate password_hash
     */
    public static function cryptoPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => self::CRYPTO_LENGTH]);
    }

    public static function cryptoCode()
    {
        self::cryptoCryptGenerate();
        return self::$code;
    }

    public static function cryptoImage($request)
    {
        return self::cryptoCode() . $request->getClientOriginalName();
    }

    public static function generateToken()
    {
        openssl_random_pseudo_bytes(self::CRYPTO_LENGTH, $binary_token);
        return bin2hex($binary_token);
    }

    public static function createToken()
    {
         \Core\Http\Persistent::create('TOKEN', self::generateToken());
    }
}
