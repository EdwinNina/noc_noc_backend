<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Mail\RegisterMail;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserId = Auth::id();
        $users = User::with('role')->where('id', '!=', $currentUserId)->get();
        $roles = Role::get();

        return response()->json([
            'users' => UserResource::collection($users),
            'roles' => RoleResource::collection($roles)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $user->setPassword = true;
            $user->save();

            $data = [
                'username' => $user->name,
                'team' => 'NOC NOC'
            ];
            Mail::to($user->email)->send(new RegisterMail($data));
            return response()->json(['message' => 'Usuario guardado correctamente'], Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex, 'message' => 'Hubo un error al guardar la tarea, intentalo de nuevo'], Response::HTTP_BAD_REQUEST);
        }
    }
}
