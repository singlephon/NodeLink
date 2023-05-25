<?php

namespace Singlephon\Nodelink\Login\Access;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken as Token;

class TokenProvider extends Tokenable
{
    public string $token;
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->clear();
        $this->token = $this->create($user);
    }

    public function clear()
    {
        Token::where('tokenable_id', [$this->user->id])->delete();
    }

    public function create(User $user): string
    {
        return $this->user->createToken(env('APP_NAME'), [])
            ->plainTextToken;
    }

}
