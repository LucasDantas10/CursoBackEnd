<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

// Classe base abstrata dos Controllers.
// Fornece renderizacao de views, redirecionamento e resposta JSON.

abstract class Controller {
    protected function renderizar(string $view, array $dados = []): void {
        extract($dados, EXTR_SKIP);
        $arquivoView = dirname(__DIR__, 2) . "/views/{$view}.php";
        if (!file_exists($arquivoView)) {
            throw new RuntimeException("View nao localizada: {$arquivoView}");
        }
        require_once dirname(__DIR__, 2) . "/views/layout/header.php";
        require_once $arquivoView;
        require_once dirname(__DIR__, 2) . "/views/layout/footer.php";
    }

    protected function redirecionar(string $rota): void {
        header("Location: {$rota}");
        exit;
    }

    public function renderizarJson(array $dados, int $status = 200): void {
        header("Content-Type: application/json; charset=utf-8");
        http_response_code($status);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
