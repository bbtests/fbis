<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * login user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'device_name' => 'required',
        ]);
        $response = $this->failed([], "Invalid credentials.", Response::HTTP_FORBIDDEN);
        if (\Auth::attempt(\Arr::only($credentials, ['email', 'password']))) {
            $user = $request->user();
            if ($user->user_verified_at) {
                $response = $this->success([
                    'token' => $user->createToken($request->device_name)->plainTextToken,
                    'user' => $user,
                ], "", Response::HTTP_ACCEPTED);
            } else {
                $response = $this->failed([], "Account Verification required", Response::HTTP_UNAUTHORIZED);
            }
        }

        return $response;
    }

    public function logout(Request $request)
    {
        if ($user = auth()->user()) {
            $user->currentAccessToken()->delete();
        }
        return $this->success([], "Logged out successfully", Response::HTTP_OK);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'sometimes|string|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);
        if (!Setting::where('key', 'user_verification')->first()->value) {
            $validated['user_verified_at'] = Carbon::now();
        }
        $user = User::create($validated);
        return $this->success(['user' => $user], "User created successfully", Response::HTTP_OK);
    }

}
