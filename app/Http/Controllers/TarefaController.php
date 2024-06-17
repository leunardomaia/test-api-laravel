<?php

namespace App\Http\Controllers;

use App\Http\Resources\TarefaResource;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TarefaResource::collection(Tarefa::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
            'data_limite' => 'required',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), status: 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TarefaResource(Tarefa::where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
