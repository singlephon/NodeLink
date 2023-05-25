<?php

namespace Singlephon\Nodelink\Service\Bindings;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * Resource helper
 *
 * Use for templating input resource which comes from Common Source server when something changed in origins
 * Can be usable in ServiceResources
 *
 */
trait ResourceHelper
{

//Bindings::setCurrentModel(User::first());
//echo 'is template: '. Bindings::isTemplate('[user->fullname]');
//echo PHP_EOL;
//echo Bindings::getValue(Bindings::user('fullname'));
//exit();

    /**
     * Accept attribute name, and return string for catching by function getPrevious()
     * @param string $attribute
     * @return string [prev->id]
     */
    public static function previous(string $attribute): string
    {
        return "[prev->$attribute]";
    }

    /**
     * Accept attribute name, and return string for catching by function getUser()
     * @param string $attribute
     * @return string [prev->id]
     */
    public static function user(string $attribute): string
    {
        return "[user->$attribute]";
    }

    /**
     * Set primary key or keys
     *
     * @param array|string $key
     * @param array $data
     * @return array
     */
    public static function primary(array|string $key, array $data): array
    {
        if (is_array( $key ))
            return array_rename_keys_add_in_start($key, '#', $data);

        return array_rename_key($key, '#'.$key,  $data);
    }

    public static function getUser(): ?Model
    {
        return static::$user ?? User::find( self::getDataInRequest('user.id') );
    }

    public static function getDataInRequest(string $way): mixed
    {
        $request = app(Request::class)->all();
        return data_get($request, $way, null);
    }

}
