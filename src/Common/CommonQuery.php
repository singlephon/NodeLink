<?php

namespace Singlephon\Nodelink\Common;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Promise\PromiseInterface;
use Singlephon\Nodelink\Service\Intentions\QueryAbstraction;

/**
 *
 * Trait for querying the parent server
 *
 * This trait allows for querying a parent server for data. It provides a simple and
 * efficient way to retrieve data from a remote source.
 *
 * Here's an example of code
    $common = new Common();
    $data = $common->setRoute('/check')->post(function () {
        return [
            'user_id' => ...,
            'password' => '...'
        ];
    });
 *
 * Also trait provides a static methods for querying the parent server for data
    $data = Common::post(function () {
        return [
            'user_id' => ...,
            'password' => '...'
        ];
    }, '/check');
 *
 * Another method for querying the parent server is using Query classes which extends QueryAbstraction::class
    Common::post(CheckPassword::class, 'execute', ...args);
 */

trait CommonQuery
{
    protected string $url;
    protected string $name;
    protected string $key;
    protected string $version;
    protected string $testVersion;
    protected array $methods = [
        'post'
    ];

    public function __construct()
    {
        $this->url = env('COMMON_SERVICE_URL');
        $this->name = env('COMMON_SERVICE_APP_NAME');
        $this->key = env('COMMON_SERVICE_APP_KEY');
        $this->version = env('COMMON_SERVICE_APP_VERSION');
        $this->testVersion = env('COMMON_SERVICE_APP_TEST_VERSION');
    }

    public function __call(string $method, array $arguments)
    {
        if (!in_array($method, $this->methods))
            dd('No such method');

        $method = $method . 'Query';
        $handler = $arguments[0];
        $event = $arguments[1] ?? false;

        if (is_callable($handler)) {
            if ($event)
                $this->setRoute($event);

            return $this->$method(call_user_func($handler));
        }
        if (class_exists($handler)) {
            if (!is_a($handler, QueryAbstraction::class, true))
                dd("Your query class [$handler] does not extends QueryAbstraction class");

            $queryClass = new $handler();

            if (!method_exists($queryClass, $event))
                dd("Class [$handler] does not contain $event() function");

            $this->setRoute($queryClass->route);
            return $this->$method($queryClass->$event(...array_slice($arguments, 2)));
        }
    }

    public static function __callStatic(string $method, array $arguments)
    {
        return (new static)->$method(...$arguments);
    }

    public function setRoute(string $route): static
    {
        if (!$route)
            dd("Route cannot be null");

        $this->url = Str::of(env('COMMON_SERVICE_URL') . $route)->replace('//', '/');
        return $this;
    }

    private function postQuery (array $body = []): PromiseInterface|Response
    {
        return Http::withBody(collect($body)->toJson(), 'application/json')
            ->withHeaders([
                'service-key' => $this->key,
                'service-name' => $this->name
            ])
            ->post($this->url);
    }

}
