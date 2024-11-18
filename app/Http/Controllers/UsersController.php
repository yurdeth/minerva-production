<?php

namespace App\Http\Controllers;

use App\Enum\ValidationTypeEnum;
use App\Models\User;
use App\Rules\OnlyUesMail;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\AuthController;

class UsersController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = DB::table('users')
            ->orderBy('users.id', 'asc')
            ->where('users.id', '!=', 1)
            ->join('careers', 'users.career_id', '=', 'careers.id')
            ->join('departments', 'careers.department_id', '=', 'departments.id')
            ->select('users.id', 'users.name', 'users.email', 'careers.career_name', 'departments.department_name', 'users.remote_user_id')
            ->get();

//        return view('usuarios', compact('users'));
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        // AuthController::register($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        if (Auth::user()->id != $id && Auth::user()->roles_id != 1) {
            return response()->json([
                "message" => "Usuario no encontrado", // No tienes permiso para ver este usuario
                "success" => false,
                "redirectTo" => route('HomeVR'),
            ]);
        }

        $user = DB::table('users')
            ->where('users.id', $id)
            ->join('careers', 'users.career_id', '=', 'careers.id')
            ->join('departments', 'careers.department_id', '=', 'departments.id')
            ->select('users.id', 'users.name', 'users.email', 'users.career_id', 'careers.career_name',
                'careers.department_id', 'departments.department_name', 'users.remote_user_id')
            ->get();

        if (!$user) {
            return response()->json([
                "message" => "Usuario no encontrado",
                "success" => false,
            ], 500);
        }

        return response()->json([
            "user" => $user,
            "success" => true,
        ]);
    }

    public function showByEmail(Request $request) {
        if (Auth::user()->roles_id != 1) {
            return response()->json([
                "message" => "No tienes permiso para ver este usuario",
                "success" => false,
                "redirectTo" => route('HomeVR'),
            ]);
        }

        $user = DB::table('users')
            ->where('users.email', $request->email)
            ->join('careers', 'users.career_id', '=', 'careers.id')
            ->join('departments', 'careers.department_id', '=', 'departments.id')
            ->select('users.id', 'users.name', 'users.email', 'users.career_id', 'careers.career_name', 'careers.department_id', 'departments.department_name')
            ->first();

        if (!$user) {
            return response()->json([
                "message" => "Usuario no encontrado",
                "success" => false,
            ], 404);
        }

        return response()->json([
            "user" => $user,
            "success" => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        if (Auth::user()->id != $id && Auth::user()->roles_id != 1) {
            return redirect()->route('HomeVR');
        }

        $validationService = new ValidationService($request, ValidationTypeEnum::UPDATE_USER);
        $response = $validationService->ValidateRequest();
        if ($response) {
            return $response;
        }

        // Actualizar los datos del usuario
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "message" => "Usuario no encontrado",
                "success" => false,
            ], 500);
        }

        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => [
                "required",
                "string",
                new OnlyUesMail(),
            ],
            "password" => "nullable|string|min:8|confirmed",
            "career" => "required",
        ]);

        if ($validate->fails()) {
            return response()->json([
                "message" => "Error en los datos",
                "error" => $validate->errors(),
                "success" => false,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->career_id = $request->career;
        $user->roles_id = 2;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if(Auth::id() == 1){
            $redirectTo = '/dashboard/usuarios';
        } else{
            $redirectTo = '/home';
        }

        return response()->json([
            "message" => "Usuario actualizado",
            "success" => true,
            "redirectTo" => $redirectTo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        if (Auth::user()->id != $id && Auth::user()->roles_id != 1) {
            return redirect()->route('HomeVR');
        }

        if ($id != 1) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
            }
        }

        if (Auth::user()->roles_id == 1) {
            return response()->json([
                "message" => "Usuario eliminado",
                "success" => true,
                "redirectTo" => route('usuarios.index'),
            ]);
        }

        return response()->json([
            "message" => "Usuario eliminado",
            "success" => true,
            "redirectTo" => route('iniciarSesion'),
        ]);
    }

    public function generateRandomPassword(){
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+}{|:"<>?ñ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return response()->json([
            "password" => $randomPassword,
            "success" => true,
        ]);
    }

}
