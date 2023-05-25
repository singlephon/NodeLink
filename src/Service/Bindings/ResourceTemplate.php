<?php

namespace Singlephon\Nodelink\Service\Bindings;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ResourceTemplate
{
    use ResourceHelper;

    protected static ?Model $previous;
    protected static ?Model $user;

    protected static array $templates = [
        'prev->',
        'user->'
    ];

    public static function getAttribute(string $template): ?string
    {
        foreach (static::$templates as $item)
        {
            if (Str::contains($template, $item))
                return Str::of($template)->after($item)->beforeLast(']');
        }
        return null;
    }

    public static function getPrevious(string $attribute)
    {
        return static::$previous->$attribute ?? null;
    }

    protected static function getOption(string $template): ?string
    {
        return Str::of($template)->before('->')->after('[');
    }

    public static function isTemplate(string $template): bool
    {
        return Str::contains($template, static::$templates);
    }

    public static function getValue(string $template)
    {
        $option = static::getOption($template);
        $attribute = static::getAttribute($template);

        return match ($option) {
            'user' => static::getUserAttribute($attribute),
            'prev' => static::getPrevious($attribute),
            default => 'Error while getValues',
        };
    }

    public static function getValues(array $data): array
    {
        foreach ($data as $iterate=>$item)
        {
            foreach ($item as $key=>$value)
            {
                if (self::isTemplate($value))
                    $data[$iterate][$key] = self::getValue($value);
            }
        }
        return $data;
    }

    public static function setCurrentModel (Model $model): void
    {
        if ($model::class == User::class)
            static::$user = $model;

        static::$previous = $model;
    }

    public static function getUserAttribute(string $attribute): mixed
    {
        return static::$user->getAttribute($attribute) ?? null;
    }

}
