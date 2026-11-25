<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipamento extends Model
{
    protected $fillable = [
        "tag", "nome", "setor", "criticidade", "status"
        ];

    //Criar método para retornar as ordens de serviço vinculada ao equipamento
    public function ordensServico(): HasMany {
        return $this->hasMany(OrdemServico::class);
    }
}
