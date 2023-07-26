<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCodeEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * 注册
     */
    public function register(Request $request): JsonResponse
    {
        $input = $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "mobile" => ['required', 'string', 'numeric', 'digits:11', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var User $user */
        $user = User::query()->create([
            "name" => $input['name'],
            "mobile" => $input['mobile'],
            "password" => Hash::make($input['password']),
        ]);

        return response()->json([
            "id" => $user['id'],
            "token" => $user['token'],
        ]);
    }

    /**
     * 登录
     */
    public function login(Request $request): JsonResponse
    {
        // 验证字段
        $input = $request->validate([
            "mobile" => 'required|string',
            'password' => 'required|string',
        ]);

        // 频率的 key
        $throttle_key = Str::transliterate(Str::lower($input['mobile']) . '|' . $request->ip());

        // 频率限制
        if (RateLimiter::tooManyAttempts($throttle_key, 5)) {
            $second = RateLimiter::availableIn($throttle_key);

            return $this->error(ErrorCodeEnum::ERROR, message: trans("auth.throttle", ['seconds' => $second]));
        };

        // 模拟实现 SessionGuard@attempt 方法
        $provider = Auth::getProvider();

        /** @var User $user */
        $user = $provider->retrieveByCredentials($input);

        if (!$user || !$provider->validateCredentials($user, $input)) {
            RateLimiter::hit($throttle_key);
            return $this->error(ErrorCodeEnum::ERROR, message: trans('auth.failed'));
        }

        // 登录成功
        RateLimiter::clear($throttle_key);

        $token = $user->createToken('pc');

        return $this->success(['token' => $token->plainTextToken]);
    }
}
