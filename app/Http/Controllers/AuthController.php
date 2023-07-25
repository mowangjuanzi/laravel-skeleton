<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    public function login()
    {

    }
}
