<?php
declare(strict_types=1);

// Exercicio 1 - Rota com parametro dinamico (GET /produtos/{id})
// Busca o produto pelo identificador. Se nao existir, retorna HTTP 404.

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\ProdutoController;

$controller = new ProdutoController();

// Simula o parametro dinamico da rota /produtos/{id}
// Em producao isso vem do Roteador, aqui recebemos via query string para teste.
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo "Informe um ID valido. Exemplo: ex01_rota_parametro.php?id=1";
    exit;
}

$controller->detalhar($id);
