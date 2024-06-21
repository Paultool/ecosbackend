<?php

// app/Http/Controllers/EscenaController.php

namespace App\Http\Controllers;

use App\Models\Escena;
use Illuminate\Http\Request;

class EscenaController extends Controller
{
    public function index()
    {
        $escenas = Escena::with(['contenido', 'poligonos'])->get();
        return response()->json($escenas);
    }

    public function show($id)
    {
        $escena = Escena::with(['contenido', 'poligonos'])->findOrFail($id);
        return response()->json($escena);
    }

    public function store(Request $request)
    {
        $escena = Escena::create($request->all());
        return response()->json($escena, 201);
    }

    public function update(Request $request, $id)
    {
        $escena = Escena::findOrFail($id);
        $escena->update($request->all());
        return response()->json($escena);
    }

    public function destroy($id)
    {
        Escena::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
