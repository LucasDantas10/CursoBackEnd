<?php

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;

//Rota Principal da Minha aplicação : Dashboard de Ativos Fabris
Route::get("/", [AtivoController::class, "index"])->name("ativos.index");

//Rota de Infraestrutura para exibir o status  em um json
Route::get("/status", [AtivoController::class, "status"])->name("ativos.status");

// Laravel possui uma técnica de criação de rotas usando resources
// Rota Restful com identificação numérica (GET/clientes; Get/clientes/id; POST/clientes; PUT/clientes/id; DELETE/clientes/id)
Route::resource("clientes", ClienteController::class)->whereNumber("clientes");

// Rota Customizada para a busca por setor
Route::get("/clientes/setor/{setor?}" , [ClienteController::class, "filtrarPorSetor"])
    ->name("clientes.setor")
    ->whereAlphaNumeric("setor");

use App\Http\Controllers\ProdutoController;

Route::resource('produtos', ProdutoController::class);

Route::get('/produtos/estoque/{tipo}', [
    ProdutoController::class,
    'estoque'
])->name('produtos.estoque');