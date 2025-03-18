<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(),
        [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',  
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status'=> false,
                'message' => 'Validation error',
                'error' => $validateUser->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }



    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'password' => 'required|string|min:8',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
            ], 401);
        }

        // Check if the user exists
        $user = User::where('name', $request->name)->first();

        // If the user doesn't exist or the password doesn't match
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }



    public function logout(Request $request)
    {
        $user = $request->user();

        // delete all of the user's tokens
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
        ], 200);
    }


}
