<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
{
    // Validar los datos del formulario de registro
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:3',
    ]);

    // Crear un nuevo usuario
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
    ]);

    // Generar un token para el usuario
    $token = $user->createToken('authToken')->plainTextToken;

    // Devolver una respuesta JSON con el usuario y el token
    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}
public function login(Request $request)
{
    // Validar los datos del formulario de inicio de sesión
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Intentar autenticar al usuario
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Si la autenticación es exitosa, regenerar la sesión
        $request->session()->regenerate();

        // Devolver una respuesta JSON con el usuario autenticado
        return response()->json([
            'user' => Auth::user(),
            'message' => 'Logged in successfully',
        ]);
    } else {
        // Si la autenticación falla, devolver un mensaje de error
        return response()->json([
            'message' => 'The provided credentials are incorrect.',
        ], 401);
    }
}
public function show(Request $request)
{
    return response()->json($request->user());
}

public function update(Request $request)
{
    // Validar la solicitud...
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Actualizar el nombre del usuario
    $user->name = $request->input('name');
    $user->save();

    // Devolver una respuesta JSON con el usuario actualizado
    return response()->json($user);
}

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out']);
}
public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }

    $user->delete();

    return response()->json([
        'message' => 'User deleted successfully',
    ]);
}

}