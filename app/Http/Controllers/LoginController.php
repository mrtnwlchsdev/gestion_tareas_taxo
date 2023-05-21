<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Pages/views/LoginView');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json([
                'message' => 'La atenticación se realizó correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Las credenciales de acceso son incorrectas'
            ], 400);
        }
    }

    public function destroy()
    {
        Auth::logout();
    }
}
