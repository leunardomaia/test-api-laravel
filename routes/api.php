<?php

use App\Http\Controllers\TarefaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/users',[UserController::class,'index']);
Route::get('/users/{user}',[UserController::class,'show']);

Route::get('/tarefas',[TarefaController::class,'index']);
Route::get('/tarefas/{tarefa}',[TarefaController::class,'show']);
Route::post('/tarefas',[TarefaController::class,'store']);
