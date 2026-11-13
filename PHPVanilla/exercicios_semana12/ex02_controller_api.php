<?php
declare(strict_types=1);

// Exercicio 2 - Resposta JSON para APIs RESTful (GET /api/produtos)
// Retorna o catalogo de produtos em JSON com Content-Type: application/json.

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\ProdutoController;

header('Content-Type: application/json; charset=utf-8');

$controller = new ProdutoController();
$controller->catalogoJson();
