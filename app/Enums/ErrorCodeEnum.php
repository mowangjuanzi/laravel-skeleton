<?php

namespace App\Enums;

enum ErrorCodeEnum: int
{
    case SUCCESS = 0;
    case ERROR = 1;

    /**
     * 获取字符串表示
     */
    public function getMessage(...$params): string
    {
        return match ($this) {
            self::SUCCESS => "操作成功",
            self::ERROR => $params['message'] ?? "操作失败",
        };
    }
}
