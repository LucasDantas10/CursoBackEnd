<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'fabricante',
        'quantidade',
        'preco'
    ];

    protected function casts(): array
    {
        return [
            'quantidade' => 'integer',
            'preco' => 'decimal:2',
        ];
    }
}
