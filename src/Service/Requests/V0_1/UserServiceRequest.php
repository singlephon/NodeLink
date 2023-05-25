<?php

namespace Singlephon\Nodelink\Service\Requests\V0_1;

use App\Models\User;
use Singlephon\Nodelink\Service\Intentions\Bindings;
use Singlephon\Nodelink\Service\Intentions\Request;

class UserServiceRequest extends Request
{

    protected function bindings (object $data): array
    {
        return [
//            User::class => Bindings::primary('id', $data->user),
//            UserProperty::class => [
//                '#user_id' => Bindings::previous('id'),
//                'position_name' => @$data->position['name'],
//                'role_id' => (int) Bindings::notify(1)->produce(1)->get()
//            ]
        ];
    }

}
