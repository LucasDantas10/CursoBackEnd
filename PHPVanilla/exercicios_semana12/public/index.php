<?php
declare(strict_types=1);

// Front Controller - ponto unico de entrada da aplicacao.
// Inicializa o autoloader PSR-4 e despacha a requisicao para o Controller correspondente.

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\ProdutoController;
use App\Core\Roteador;

$roteador = new Roteador();

// Exercicio 5 - listagem de produtos e filtro por categoria (query string)
$roteador->registrar('GET', '/', [ProdutoController::class, 'listar']);
$roteador->registrar('GET', '/produtos', [ProdutoController::class, 'listar']);

// Exercicio 1 - rota com parametro dinamico: GET /produtos/{id}
$roteador->registrar('GET', '/produtos/{id}', [ProdutoController::class, 'detalhar']);

// Exercicio 2 - resposta JSON para API RESTful: GET /api/produtos
$roteador->registrar('GET', '/api/produtos', [ProdutoController::class, 'catalogoJson']);

// Exercicio 4 - exclusao segura via POST: POST /produtos/excluir
$roteador->registrar('POST', '/produtos/excluir', [ProdutoController::class, 'excluir']);

// O roteador registra o log de acesso antes de despachar (Exercicio 3)
$roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
