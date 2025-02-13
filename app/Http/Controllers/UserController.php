<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return $this->userResponse(JWTAuth::getToken());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $user = User::create($request->validated()['user']);

        $token = JWTAuth::fromUser($user);

        return $this->userResponse($token);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        auth()->user()->update($request->validated()['user']);

        return $this->userResponse(JWTAuth::getToken());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated()['user'];

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->userResponse($token);
        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
    }

    protected function userResponse(string|null $jwtToken): JsonResponse
    {
        if (!$jwtToken) {
            return response()->json(['error' => 'Token generation failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'user' => ['token' => $jwtToken] + auth()->user()->toArray()
        ]);
    }
}
