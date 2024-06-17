<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TarefaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'usuario' => [
                'id' => $this->user->id,
                'nome' => $this->user->name,
                'email' => $this->user->email,
            ],
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_limite' => Carbon::parse($this->data_limite)->format('d/m/Y'),
            'status' => $this->concluida ? 'Concluída' : 'Pendente',
        ];
    }
}
