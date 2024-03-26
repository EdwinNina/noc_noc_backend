<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiAuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(ApiAuthLoginRequest $request){
        try {
            if (!Auth::attempt($request->all())) return response()->json([
                'message' => 'Credendiales invalidos',
            ], Response::HTTP_UNAUTHORIZED);

            $user = User::with('role')->where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'user' => new UserResource($user),
                'token' => $token
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], Response::HTTP_BAD_REQUEST);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        try {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            $frontAppUrl = config('app.frontend_url');
            $restorePasswordUrl = "$frontAppUrl/restore/$token";

            $data = ['restorePasswordUrl' => $restorePasswordUrl];
            Mail::to($request->email)->send(new ForgotPasswordMail($data));

            return response()->json(['message' => 'The hemos enviado un correo con las instrucciones'], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
        ]);

        try {
            $updatePasswordExists = DB::table('password_reset_tokens')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])->first();
            if(!$updatePasswordExists) {
                return response()->json(['message' => 'Token invalido'], Response::HTTP_BAD_REQUEST);
            }
            User::where('email', $request->email)->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            return response()->json(['message' => 'Contraseña actualizada correctamente'], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesion finalizada'], Response::HTTP_OK);
    }
}
