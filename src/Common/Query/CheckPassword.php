<?php

namespace Singlephon\Nodelink\Common\Query;

use Singlephon\Nodelink\Service\Intentions\QueryAbstraction;

class CheckPassword extends QueryAbstraction
{
    public string $route = '/check';

    public function user ($user): array
    {
        return [
            'user_id' => $user->id,
            'password' => $user->password
        ];
    }
}
