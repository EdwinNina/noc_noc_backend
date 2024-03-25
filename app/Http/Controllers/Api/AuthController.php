<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiAuthLoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(ApiAuthLoginRequest $request){
        try {
            if (!Auth::attempt($request->all())) return response()->json([
                'message' => 'Invalid authentication credentials',
            ], Response::HTTP_UNAUTHORIZED);

            $user = User::with('role')->where('email', $request->email)->select('name','email','id')->first();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Log In successfully'
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], Response::HTTP_BAD_REQUEST);
        }
    }
}
