<?php

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;

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

Route::get('/setores', [AtivoController::class, 'setores'])
    ->name('ativos.setores');

Route::get('/ativos/{codigo}', [AtivoController::class, 'detalhar'])
    ->name('ativos.detalhar');

Route::get('/healthz', function () {
    return response()->json([
        "status" => "UP",
        "uptime_segundos" => round(microtime(true) - LARAVEL_START, 2),
        "memoria_mb" => round(memory_get_usage(true) / 1024 / 1024, 2)
    ], 200);
})->name('healthz');


Route::get('/clientes/{cliente}/contratos/{ano}',
    [AtivoController::class, 'contratosPorAno'])
    ->whereNumber('cliente')
    ->where('ano', '[0-9]{4}')
    ->name('clientes.contratos');



// Rotas públicas somente para consulta de fornecedores
Route::resource('fornecedores', FornecedorController::class)
    ->only(['index', 'show']);

// Consulta os dados de origem da requisição
Route::get('/clientes/origem', [ClienteController::class, 'origemRequisicao'])
    ->name('clientes.origem');


// Grupo de rotas administrativas
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/auditoria/clientes', [
            ClienteController::class,
            'auditoriaClientes'
        ])->name('auditoria.clientes');

    });

// Rota para alternar o status do cliente
Route::patch('/clientes/{id}/status', [
    ClienteController::class,
    'alterarStatus'
])->name('clientes.status');