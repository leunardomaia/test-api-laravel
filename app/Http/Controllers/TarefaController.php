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
            'data_limite' => 'required|date_format:Y/m/d',
            'concluida' =>  'numeric|between:0,1',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), status: 400);
        }

        $tarefa = Tarefa::create($validator->validate());

        return response()->json(new TarefaResource($tarefa), 201);
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

        $tarefa = Tarefa::find($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
            'data_limite' => 'required|date_format:Y/m/d',
            'concluida' =>  'numeric|between:0,1'
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), status: 400);
        }

        $validated = $validator->validate();

        $tarefa->update([
            'user_id' => $validated['user_id'],
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'data_limite' => $validated['data_limite'],
            'concluida' => $validated['concluida'],
        ]);

        return new TarefaResource($tarefa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json(['mensagem' => 'Tarefa não encontrada.'], status: 404);
        }
        
        $tarefa->delete();

        return response()->json(['mensagem' => 'Tarefa removida.']);

    }
}
