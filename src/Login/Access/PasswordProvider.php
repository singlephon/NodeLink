<?php

namespace Singlephon\Nodelink\Login\Access;

use Illuminate\Support\Str;

class PasswordProvider extends Tokenable
{
    public static function random (): string
    {
        return TokenProvider::hash( Str::random(16) );
    }

    public static function add (array $data): array
    {
        $data['password'] = self::random();
        return $data;
    }
}
