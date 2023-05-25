<?php

namespace Singlephon\Nodelink\Service\Intentions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Singlephon\Nodelink\Common\CommonQuery;
use Singlephon\Nodelink\Service\Insertions\SensitiveInsertion;

/**
 * @method post(Closure|string $handler, ?string $event = null, ?mixed ...$args = null)
 */
class Common
{
    use CommonQuery;

    public static function notify(Request $request): JsonResponse
    {
        return self::extracted($request);
    }

    public static function produce(Request $request): JsonResponse
    {
        return self::extracted($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public static function extracted(Request $request): JsonResponse
    {
        $requestClass = getCommonRequestClass();

        if (!class_exists($requestClass))
            return response()->json([], HTTP_COMMON_RESOURCE_NOT_EXIST);

        $data = new $requestClass($request->all());
        $inserted = new SensitiveInsertion($data);

        return response()->json([
            'raw' => json_encode($data->raw, JSON_UNESCAPED_UNICODE),
            'validated' => $data->validated,
            'resource' => $request->header('resource'),
            'inserted_error' => $inserted->getErrors(),
            'inserted_successful' => $inserted->getSuccessful()
        ], $inserted->generateStatus());
    }


}
