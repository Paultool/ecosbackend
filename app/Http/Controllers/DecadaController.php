<?php

namespace App\Http\Controllers;

use App\Models\Decada;
use Illuminate\Http\Request;

class DecadaController extends Controller
{
    public function index()
    {
        $decadas = Decada::all();
        return response()->json($decadas);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $decada = Decada::create($request->all());
        return response()->json($decada, 201);
    }

    public function show(Decada $decada)
    {
        return response()->json($decada);
    }

    public function edit(Decada $decada)
    {
        //
    }

    public function update(Request $request, Decada $decada)
    {
        $decada->update($request->all());
        return response()->json($decada);
    }

    public function destroy(Decada $decada)
    {
        $decada->delete();
        return response()->json(null, 204);
    }
}
