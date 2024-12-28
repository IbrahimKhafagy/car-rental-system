<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\ResponseResource;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());

            return ResponseResource::success(['user' => $user], 'User registered successfully.', 201);
        } catch (\Exception $e) {
            return ResponseResource::error('An error occurred during registration.', 500, $e->getMessage());
        }
    }

    public function login(LoginRequest $request)    {
        try {
            $token = $this->authService->login($request->validated());

            return ResponseResource::success(['token' => $token], 'Login successful.');
        } catch (\Exception $e) {
            return ResponseResource::error('An error occurred during login.', 500, $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request->user());

            return ResponseResource::success([], 'Logged out successfully.');
        } catch (\Exception $e) {
            return ResponseResource::error('An error occurred during logout.', 500, $e->getMessage());
        }
    }
}
