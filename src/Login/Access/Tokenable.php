<?php

namespace Singlephon\Nodelink\Login\Access;

abstract class Tokenable
{
    public string $token;
    public string $externalToken;
    public static string $hashType = 'sha256';

    public static function attempt(string $not_hashed, string $hashed): bool
    {
        return hash(self::$hashType, $not_hashed) == $hashed;
    }

    public static function hash(string $not_hashed): bool|string
    {
        return hash(self::$hashType, $not_hashed);
    }

}
