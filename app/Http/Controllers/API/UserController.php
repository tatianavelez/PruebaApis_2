<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


//LOGIN
public function login(Request $request)
{
    // Validar
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    $user->tokens()->delete();

    $token = $user->createToken('authToken-' . $user->id)->plainTextToken;

    return response()->json(['message' => 'Inicio de sesión exitoso', 'token' => $token, 'user' => $user]);
}



public function traertodos()
{
    
    $users = User::all();
    
    return response()->json(['users' => $users]);
}



} 



