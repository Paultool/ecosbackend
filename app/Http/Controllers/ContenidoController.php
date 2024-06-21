<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use Illuminate\Http\Request;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::all();
        return response()->json($contenidos);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $contenido = Contenido::create($request->all());
        return response()->json($contenido, 201);
    }

    public function show(Contenido $contenido)
    {
        return response()->json($contenido);
    }

    public function edit(Contenido $contenido)
    {
        //
    }

    public function update(Request $request, Contenido $contenido)
    {
        $contenido->update($request->all());
        return response()->json($contenido);
    }

    public function destroy(Contenido $contenido)
    {
        $contenido->delete();
        return response()->json(null, 204);
    }
}
