<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'data_limite',
        'concluida'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
