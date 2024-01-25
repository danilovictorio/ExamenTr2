<?php

namespace App\Http\Controllers;
use App\Models\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    public function crear(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'contenido' => 'required|string|max:255',
        ]);

        $file = Archivo::create([
            'nombre' => $validatedData['nombre'],
            'contenido' => $validatedData['contenido'],
        ]);

        return response()->json($file);
    }
    public function mostrar(Request $request)
    {
        return response()->json($request->archivo());
    }

    public function modificar(Request $request, $id)
    {
        $fitxer = Archivo::find($id);
        $fitxer->nombre = $request->input('nombre');
        $fitxer->contenido = $request->input('contenido');
        $fitxer->save();

        return response()->json($fitxer);
    }

    public function borrar($id)
{
    $user = Archivo::find($id);

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
