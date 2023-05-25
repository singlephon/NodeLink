<?php

namespace Singlephon\Nodelink;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Singlephon\Nodelink\Skeleton\SkeletonClass
 */
class NodelinkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nodelink';
    }
}
