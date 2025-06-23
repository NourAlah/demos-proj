<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // Validate input
        $Validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $Validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Create access token
        $token = $user->createToken('authToken')->accessToken;

        // Return response with token
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        // Check if user exists
        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => 'This email is not registered. Please register first.'
            ], 404);
        }

        $tokenRequest = \Illuminate\Http\Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
        ]);
   
        $response = app()->handle($tokenRequest);
        $responseJson = (array)json_decode($response->getContent());

        $data['user'] = $user;
        $data['access_token'] = $responseJson['access_token'];
        $data['refresh_token'] = $responseJson['refresh_token'];


        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => $data
        ]);
    }
}
