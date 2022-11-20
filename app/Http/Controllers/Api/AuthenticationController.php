<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;

class AuthenticationController extends Controller
{
    /**
     * Register
     */
    public function register(RegisterUserRequest $request)
    {

        $user = User::create( [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ] );
        
        $token = $user->createToken('Hope4African')->plainTextToken;
        return ResponseHelper::success('Registration Successfully', $user, 201, $token);
       
    }
    
     /**
     * Login
     */
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {

            return ResponseHelper::error('Incorrect password or email', [], 401);
        }

        $token = $user->createToken('Hope4African')->plainTextToken;
        return ResponseHelper::success('Login Successfully', $user, 201, $token);
    }

    /**
     * Logout
     */
    public function logoutall(Request $request)
    {
       
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

   /**
     * Validate token
     */
    public function validate_token($token)
    {
        // Fetch the associated token Model
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

        // Get the assigned user
        $user = $user->tokenable;
        
        return ResponseHelper::success('Token Validation is Successfully', $user, 201, $token);
    }

    /**
     * Refresh authentication token
     */
    public function refresh()
    {
        
    }
}
