<?php

namespace App\Http\Controllers;

use App\Models\Escena;
use Illuminate\Http\Request;

class EscenaController extends Controller
{
    public function index()
    {
        $escenas = Escena::all();
        return response()->json($escenas);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $escena = Escena::create($request->all());
        return response()->json($escena, 201);
    }

    public function show(Escena $escena)
    {
        return response()->json($escena);
    }

    public function edit(Escena $escena)
    {
        //
    }

    public function update(Request $request, Escena $escena)
    {
        $escena->update($request->all());
        return response()->json($escena);
    }

    public function destroy(Escena $escena)
    {
        $escena->delete();
        return response()->json(null, 204);
    }
}
