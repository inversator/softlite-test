<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * The controller class for handling authentication requests.
 */
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }


    /**
     * Registers a new user with the provided credentials.
     *
     * @param  RegisterRequest  $request  The request object containing the user's credentials.
     * @param  UserService  $userService  The user service instance.
     *
     * @return JsonResponse The JSON response containing the registration status.
     * @throws UnknownProperties
     * @throws Exception
     */
    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $user = $userService->register($request->toDTO());

        return response()->json([
            'status' => ResponseStatus::Success->value,
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'User registered successfully'
        ]);
    }

    /**
     * Logs in a user with the provided credentials.
     *
     * @param  AuthRequest  $request  The request object containing the user's credentials.
     * @param  UserService  $userService  The user service instance.
     *
     * @return JsonResponse The JSON response containing the login status and token.
     */
    public function login(AuthRequest $request, UserService $userService): JsonResponse
    {
        if ($request->username) {
            $request->merge(['name' => $request->username]);
        }

        try {
            [$user, $token] = $userService->login($request->toDTO());

        } catch (AuthenticationException $e) {
            return response()->json([
                'error' => 'Wrong credentials',
                'status' => ResponseStatus::Error->value
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => ResponseStatus::Error->value
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => ResponseStatus::Success->value,
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'User logged in successfully'
        ]);
    }

    /**
     * Logs out the currently authenticated user.
     *
     * @return JsonResponse The JSON response containing the logout status.
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();

        // Delete tokens
        $user->tokens()->delete();

        return response()->json([
            'status' => ResponseStatus::Success->value,
            'message' => 'User logged out successfully'
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return response()->json([
            'status' => ResponseStatus::Success->value,
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'Token refreshed successfully'
        ]);
    }
}
