<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * 注册
     */
    public function register(Request $request): JsonResponse
    {
        return response()->json([], 403);

        $input = $request->validate([
            "name" => ['bail', 'required', 'string', 'max:255'],
            "mobile" => ['bail', 'required', 'string', 'numeric', 'digits:11', 'unique:' . User::class],
            'password' => ['bail', 'required', 'confirmed', Rules\Password::defaults()],
        ], [], [
            "name" => "昵称",
            "mobile" => "手机号",
            "password" => "密码",
        ]);

        /** @var User $user */
        $user = User::query()->create([
            "name" => $input['name'],
            "mobile" => $input['mobile'],
            "password" => Hash::make($input['password']),
        ]);

        $token = $user->createToken('pc');

        return response()->json([
            "token" => $token->plainTextToken,
        ]);
    }

    /**
     * 登录
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        // 验证字段
        $input = $request->validate([
            "mobile" => 'bail|required|string',
            'password' => 'bail|required|string',
        ], [], [
            "mobile" => "手机号",
            "password" => "密码",
        ]);

        // 频率的 key
        $throttle_key = Str::transliterate(Str::lower($input['mobile']) . '|' . $request->ip());

        // 频率限制
        if (RateLimiter::tooManyAttempts($throttle_key, 5)) {
            $second = RateLimiter::availableIn($throttle_key);
            throw ValidationException::withMessages(trans("auth.throttle", ['seconds' => $second]));
        };

        // 模拟实现 SessionGuard@attempt 方法
        $provider = Auth::getProvider();

        /** @var User $user */
        $user = $provider->retrieveByCredentials($input);

        if (!$user || !$provider->validateCredentials($user, $input)) {
            RateLimiter::hit($throttle_key);
            throw ValidationException::withMessages(trans('auth.failed'));
        }

        // 登录成功
        RateLimiter::clear($throttle_key);

        $token = $user->createToken('pc');

        return response()->json([
            "token" => $token->plainTextToken,
        ]);
    }

    /**
     * 销毁
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json();
    }
}
