<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCodeEnum;
use App\Services\GeneralService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 成功的时候返回
     */
    protected function success(mixed $data = null, ?string $message = null): JsonResponse
    {
        return GeneralService::success($data, $message);
    }

    /**
     * 失败的时候返回
     */
    protected function error(ErrorCodeEnum $code = ErrorCodeEnum::ERROR, ...$param): JsonResponse
    {
        return GeneralService::error($code, ...$param);
    }
}
