<?php

namespace Singlephon\Nodelink\Common\Query;

use Illuminate\Support\Facades\URL;
use Singlephon\Nodelink\Service\Intentions\QueryAbstraction;

class RegisterApplication extends QueryAbstraction
{
    public string $route = '/corelink/register';

    public function register (): array
    {
        return [
            'name' => env('NODELINK_SERVICE_APP_NAME'),
            'url' => URL::to(''),
            'version' => env('NODELINK_SERVICE_APP_VERSION'),
            'key' => env('NODELINK_SERVICE_APP_KEY')
        ];
    }
}
