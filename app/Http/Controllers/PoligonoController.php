<?php

namespace App\Http\Controllers;

use App\Models\Poligono;
use Illuminate\Http\Request;

class PoligonoController extends Controller
{
    public function index()
    {
        $poligonos = Poligono::all();
        return response()->json($poligonos);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $poligono = Poligono::create($request->all());
        return response()->json($poligono, 201);
    }

    public function show(Poligono $poligono)
    {
        return response()->json($poligono);
    }

    public function edit(Poligono $poligono)
    {
        //
    }

    public function update(Request $request, Poligono $poligono)
    {
        $poligono->update($request->all());
        return response()->json($poligono);
    }

    public function destroy(Poligono $poligono)
    {
        $poligono->delete();
        return response()->json(null, 204);
    }
}
