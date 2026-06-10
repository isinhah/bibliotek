<?php

namespace App\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function attemptLogin(LoginDTO $dto): bool
    {
        $credentials = [
            'email'    => $dto->email,
            'password' => $dto->password,
        ];

        if (!Auth::attempt($credentials, $dto->remember)) {
            throw new Exception('As credenciais fornecidas não correspondem aos nossos registros.');
        }

        request()->session()->regenerate();

        return true;
    }

    public function registerUser(RegisterDTO $dto): User
    {
        $user = User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password,
        ]);

        $user->assignRole('user');

        Auth::login($user);

        return $user;
    }

    public function logoutUser(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
