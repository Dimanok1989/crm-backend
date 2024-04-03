<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppResource;
use App\Http\Resources\User\ProfileResource;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Http\Services\UserService $service
     * @return \App\Http\Resources\AppResource
     */
    public function registration(Request $request, UserService $service)
    {
        $request->validate([
            'login' => [
                "required",
                "email",
                Rule::unique(User::class, 'email'),
            ],
            'password' => [
                "required",
                "confirmed",
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ]);

        return new AppResource(
            $service->registration($request->login, $request->password)
        );
    }

    /**
     * Авторизация пользователя
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Http\Services\UserService $service
     * @return \App\Http\Resources\AppResource
     */
    public function login(Request $request, UserService $service)
    {
        $request->validate([
            'login' => ["required", "email"],
            'password' => ["required", "string"],
        ]);

        if (!$user = $service->attempt($request->login, $request->password)) {
            abort(403, "Неверный логин или пароль");
        };

        return new AppResource($user);
    }
}
