<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthController extends Controller
{
        public function register(Request $request) {
            try {

                $request->validate([
                        'name' => 'required|string',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|string|min:6',
                    ]);


                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);
                    
                 // Create wallet for new user
                   $user->wallet()->create(['balance' => 100000]);

                    $token = $user->createToken('API Token')->accessToken;

                    return response()->json([
                        'token' => $token,
                        'message' => 'User registered successfully.',
                    ], 201); // 201 Created
                } catch (Exception $e) {
                    Log::error('User Registration Error: ' . $e->getMessage());

                    return response()->json([
                        'error' => 'User registration failed.',
                        'message' => $e->getMessage(), // You can remove this in production
                    ], 500); // 500 Internal Server Error
                }
        }


        public function login(Request $request)
        {

          $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
              ]);
              
            if (!auth()->attempt($request->only('email', 'password'))) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $token = auth()->user()->createToken('API Token')->accessToken;

            return response()->json(['token' => $token]);
        }

}




