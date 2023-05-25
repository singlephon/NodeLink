<?php

namespace Singlephon\Nodelink\Service\Intentions;

use Illuminate\Support\Str;

class Version
{
    public static function toDirectory(float $version): string
    {
        return Str::replace('.', '_', (string) $version);
    }

    public static function getRequest(string $resource): string
    {
        $version = static::toDirectory(env('COMMON_SERVICE_APP_VERSION'));
        return "App\\NodeLink\\Requests\\V$version\\{$resource}Request";
    }
}
