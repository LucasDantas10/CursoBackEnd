<?php
declare(strict_types=1);

// Exercicio 3 - Middleware de Log de Acessos
// Registra data, hora, IP do cliente, metodo HTTP e URI solicitada antes de despachar a rota.

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Roteador;
use App\Controllers\ProdutoController;

$roteador = new Roteador();

// Registra rotas de exemplo (o Roteador grava o log de acesso antes de despachar)
$roteador->registrar('GET', '/produtos', [ProdutoController::class, 'listar']);
$roteador->registrar('GET', '/produtos/{id}', [ProdutoController::class, 'detalhar']);

// Despacha a requisicao (executa o registro de log antes)
$roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

echo "<p>Log de acesso gravado em logs/acessos.log</p>";
echo "<p><a href='/produtos'>Ver Catalogo</a></p>";
