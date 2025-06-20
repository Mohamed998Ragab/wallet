<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Requests\RegisterRequest;
use Modules\User\Requests\LoginRequest;
use Modules\User\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->register($request->validated());
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\InvalidArgumentException $e) {
            // Handle validation errors
            return response()->json([
                'message' => $e->getMessage(),
                'error_type' => 'validation_error'
            ], 422);
        } catch (\Exception $e) {
            // Handle other errors
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
                'error_type' => 'server_error'
            ], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $loginData = $this->userService->login($request->validated());
            return response()->json([
                'token' => $loginData['token'],
                'user' => $loginData['user']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
