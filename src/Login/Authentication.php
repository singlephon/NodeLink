<?php

namespace Singlephon\Nodelink\Login;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Singlephon\Nodelink\Login\Intention\Save;
use Singlephon\Nodelink\Requests\AuthRequest;
use Singlephon\Nodelink\Requests\TokenRequest;
use Singlephon\Nodelink\Service\Intentions\Common;
use Singlephon\Nodelink\Common\Query\CheckPassword;
use Singlephon\Nodelink\Login\Access\TokenProvider;


class Authentication
{
    public static User $user;

    public static function init (AuthRequest $request): JsonResponse
    {
        if ( !self::getUser($request) )
            return self::invalid();

        if ( !self::syncPassword($request) )
            return self::invalid();

        return self::validate($request);
    }

    public static function getUser (AuthRequest $request): User
    {
        return self::$user = User::where('login', $request->login)->first();
    }

    public static function syncPassword (AuthRequest $request): bool
    {
        $currentUser = self::$user;
        $checkQuery = Common::post(CheckPassword::class, 'user', self::$user)->json();

        if (!$checkQuery['isValid']){
            static::getUser($request);
            if (self::$user->password != $currentUser->password)
                $checkQuery = Common::post(CheckPassword::class, 'user', self::$user)->json();

            return $checkQuery['isValid'];
        }
        return true;
    }

    public static function commonTokenRequest (TokenRequest $request): JsonResponse
    {

        $user = User::find($request->id);

        return response()->json(
            Save::in( $user )
        );
    }

    public static function validate (AuthRequest $request): JsonResponse
    {
        if ( !TokenProvider::attempt($request->password, self::$user->password) )
            return self::invalid();

        return response()->json(
            Save::in( self::$user )
        );
    }

    public static function invalid (): JsonResponse
    {
        return response()->json(['message' => 'Invalid login or password'], 422);
    }

    public static function not_active (): JsonResponse
    {
        return response()->json(['message' => 'Unreachable service', 'solution' => 'User is not active'], 403);
    }
}
