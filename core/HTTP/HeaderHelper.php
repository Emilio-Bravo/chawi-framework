<?php

namespace Core\Http;

class HeaderHelper
{

    public const DISPOSITION_ATTACHMENT = 'attachment';
    public const DISPOSITION_INLINE = 'inline';

    public static function toString(array $array, string $separator = ', '): string
    {
        foreach ($array as $index => $value) {

            if (is_bool($value)) $components[] = $index;

            else $components[] = $index . '=' . '"' . $value . '"';
        }

        return implode($separator, $components);
    }

    public static function makeDisposition(string $disposition, string $filename, string $filenameFallback): string
    {
        if (!\in_array($disposition, [self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE])) {

            throw new \InvalidArgumentException(

                sprintf(
                    'diposition can´t be differ of %s or %s',
                    self::DISPOSITION_ATTACHMENT,
                    self::DISPOSITION_INLINE
                )

            );
        }

        //filenameFallback not ASCII
        if (!preg_match('/^[\x20-\x7e]*$/', $filenameFallback)) {
            throw new \InvalidArgumentException('Filename fallback must only contain ASCII characters');
        }

        //Insecure characters in the fallback
        if (str_contains($filenameFallback, '%')) {
            throw new \InvalidArgumentException('The filename callback can´t contain the "%" character');
        }

        if (str_contains($filename, '/') || str_contains($filename, '\\') || str_contains($filenameFallback, '/') || str_contains($filenameFallback, '\\')) {
            throw new \InvalidArgumentException('The filename and fallback can´t contain slashes');
        }

        $params = ['filename' => $filenameFallback];

        if ($filename !== $filenameFallback) {
            $params['filename*'] = 'UTF-8' . rawurlencode($filename);
        }

        return "$disposition; " . self::toString($params, ';');
    }
}
