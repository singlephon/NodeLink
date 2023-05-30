<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Singlephon\Nodelink\Service\Intentions\Version;

function array_remove_null($array)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = array_remove_null($value);
        }

        if (is_null($array[$key]) or $value == '!@#') {
            unset($array[$key]);
        }
    }

    return $array;
}

function array_explode_special_character($array): array
{
    $last = [];
    foreach ($array as $model=>$info) {
        $first = [];
        $second = [];
        foreach ($info as $key=>$value) {
            if (Str::of($key)->contains('#')) $first[(string)Str::of($key)->after('#')] = $value;
            else $second[$key] = $value;
        }
        $last[$model] = [$first, $second];
    }
    return $last;
}

/**
 * The function is used to rename keys in an array
 *
 * @param $old_key
 * @param $new_key
 * @param $array
 * @return array
 */
function array_rename_key ($old_key, $new_key, $array): array
{
    if (Arr::exists($array, $old_key)) {
        $array[$new_key] = $array[$old_key];
        unset($array[$old_key]);
    }
    return $array;
}

/**
 * The function is identical to array_rename_key(), but in the first argument it takes an array of keys, in second is identification character (for instance: # -> primary)
 *
 * @param $keys
 * @param $insert
 * @param $array
 * @return array
 */
function array_rename_keys_add_in_start ($keys, $insert, $array): array
{
    foreach ($keys as $key)
    {
        $array = array_rename_key($key, $insert.$key, $array);
    }
    return $array;
}

function request_action(): string
{
    return Str::of(URL::current())->afterLast('nodelink/');
}

function getHeader(string $key)
{
    return app(Request::class)->header($key);
}

function getCommonRequestClass(): string
{
    return Version::getRequest(getHeader('resource'));
}



