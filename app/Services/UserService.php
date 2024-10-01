<?php

namespace App\Services;

use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Models\User;
use Exception;
use http\Exception\RuntimeException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @throws Exception
     */
    public function register(RegisterDTO $data): User
    {
        try {
            return User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
            ]);
        } catch (Exception $e) {
            throw new Exception('Failed to register user: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function login(LoginDTO $data): ?array
    {
        $credentials = $data->only('email', 'password')->toArray();

        if (!auth()->attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials provided.');
        }

        $user = Auth::user();
        $user->tokens()->delete();

        return [$user, $user->createToken('auth_token')->plainTextToken];
    }
}
