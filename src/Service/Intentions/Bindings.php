<?php

namespace Singlephon\Nodelink\Service\Intentions;

use Closure;
use Singlephon\Nodelink\Service\Bindings\ResourceHelper;
use Singlephon\Nodelink\Service\Bindings\ResourceTemplate;

/**
 * This class isn't SINGLETON! Used similar logic but for another purposes
 * @method Bindings notify(?Closure|string $param = null)
 * @method static Bindings produce(?Closure|string $param = null)
 */
class Bindings
{
    use ResourceHelper;

    private ?string $conclusion = null;

    public function __call(string $name, array $arguments)
    {
        if (!$this->bindingIf($name))
            return $this;

        $option = $arguments[0] ?? null;

        if ( $option instanceof Closure )
            $option = $option();

        $this->conclusion = $option;

        return $this;

    }

    public static function __callStatic(string $method, array $arguments)
    {
        return (new static)->$method(...$arguments);
    }

    public static function decode(): string
    {
        return ResourceTemplate::class;
    }

    protected function bindingIf ($name): bool
    {
        return request_action() == $name;
    }

    public function __toString(): string
    {
        return $this->conclusion ?? '!@#';
    }

    public function get (): string|int|null
    {
        return $this->conclusion;
    }
}
