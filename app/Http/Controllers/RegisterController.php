<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return Inertia::render('Pages/views/RegisterView');
    }

    public function store(Request $request)
    {
        $user_exist = User::all('email')->where('email', $request->email)->first();

        if (!$user_exist) {
            $user = new User;
            $user->email = $request->email;

            // Antes de guardar la contraseña esta es encriptada de forma segura
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => 'Usuario creado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'El usuario ya se encuentra registrado'
            ], 400);
        }
    }
}
