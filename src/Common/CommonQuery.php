<?php

namespace Singlephon\Nodelink\Common;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Singlephon\Nodelink\Service\Intentions\QueryAbstraction;
use Singlephon\Nodelink\Service\Intentions\Security;

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
    use Security;

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
        $this->url = env('CORELINK_SERVICE_URL');
        $this->name = env('NODELINK_SERVICE_APP_NAME');
        $this->key = env('NODELINK_SERVICE_APP_KEY');
        $this->version = env('NODELINK_SERVICE_APP_VERSION');
        $this->testVersion = env('NODELINK_SERVICE_APP_TEST_VERSION');
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

        $this->url = Str::of(env('CORELINK_SERVICE_URL') . $route)->replace('//', '/');
        return $this;
    }

    private function postQuery (array $body = []): PromiseInterface|Response
    {
        $body = collect($body)->toJson();
        return Http::withBody($body, 'application/json')
            ->withHeaders([
                'checksum' => $this->checksumGenerate($body, $this->key),
                'service-name' => $this->name
            ])
            ->post($this->url);
    }

}
