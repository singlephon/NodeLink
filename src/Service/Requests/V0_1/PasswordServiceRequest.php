<?php

namespace Singlephon\Nodelink\Service\Requests\V0_1;

use Singlephon\Nodelink\Service\Intentions\Bindings;
use Singlephon\Nodelink\Service\Intentions\Request;

class PasswordServiceRequest extends Request
{

    protected function bindings (object $data): array
    {
        return [
            // User::class => Bindings::primary('id', (array) $data)
        ];
    }

}
