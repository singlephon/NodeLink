<?php

namespace Singlephon\Nodelink\Login\Intention;

use App\Models\User;
use Singlephon\Nodelink\Login\Access\TokenProvider;

class Save
{
    public static function in(User $user): array
    {
        $token = (new TokenProvider($user))->token;

        return [
            'token' => $token
        ];
    }
}
