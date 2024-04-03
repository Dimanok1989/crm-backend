<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Регистрация нового пользователя
     * 
     * @param string $login
     * @param string $password
     * @return \App\Models\User
     */
    public function registration(string $login, string $password): User
    {
        return $this->create([
            'email' => $login,
            'password' => Hash::make($password)
        ]);
    }

    /**
     * Поиск пользователя по логину и пролю
     * 
     * @param string $login
     * @param string $password
     * @return null|\App\Models\User
     */
    public function attempt(string $login, string $password): ?User
    {
        if (Auth::attempt(['email' => $login, 'password' => $password])) {
            return User::where('email', $login)->first();
        }

        return null;
    }

    /**
     * Создаение новой учетной записи
     * 
     * @param array $data
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        return User::create($data)->refresh();
    }

    /**
     * Авторизация пользователя
     * 
     * @param \App\Models\User $user
     * @return array
     */
    public function auth(User $user)
    {
        $token = $user->createToken("crm token");

        return [
            'token' => $token->plainTextToken
        ];
    }
}
