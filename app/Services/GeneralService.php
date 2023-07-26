<?php

namespace App\Services;

use App\Enums\ErrorCodeEnum;
use Illuminate\Http\JsonResponse;
use stdClass;

class GeneralService
{
    /**
     * 响应成功
     */
    public static function success(mixed $data = null, ?string $message = null): JsonResponse
    {
        if (empty($data)) {
            $data = new stdClass();
        }

        $code = ErrorCodeEnum::SUCCESS;

        return response()->json([
            "code" => $code->value,
            "message" => $message ?: $code->getMessage(),
            "data" => $data,
        ]);
    }

    /**
     * 响应失败
     */
    public static function error(ErrorCodeEnum $code = ErrorCodeEnum::SUCCESS, ...$param): JsonResponse
    {
        return response()->json([
            "code" => $code->value,
            "message" => $code->getMessage(...$param),
        ]);
    }
}
