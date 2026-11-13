<?php
declare(strict_types=1);

namespace App\Core;

// Roteador HTTP artesanal.
// Suporta rotas estaticas e rotas com parametro dinamico (ex: /produtos/{id}).
// Registra um log de acesso antes de despachar a requisicao.

final class Roteador {
    private array $rotas = [];

    public function registrar(string $metodo, string $uri, array $acao): void {
        $uriNormalizada = '/' . trim($uri, '/');
        $this->rotas[strtoupper($metodo)][$uriNormalizada] = $acao;
    }

    public function despachar(string $metodo, string $uri): void {
        $this->registrarLog($metodo, $uri);

        $uriLimpa = '/' . trim((string)parse_url($uri, PHP_URL_PATH), '/');
        $metodoHttp = strtoupper($metodo);
        $segmentosUri = $this->segmentos($uriLimpa);

        foreach ($this->rotas[$metodoHttp] ?? [] as $rotaRegistrada => $acao) {
            $segmentosRota = $this->segmentos($rotaRegistrada);
            if (count($segmentosRota) !== count($segmentosUri)) {
                continue;
            }
            $parametros = [];
            $ok = true;
            foreach ($segmentosRota as $i => $segRota) {
                if (preg_match('/^\{(\w+)\}$/', $segRota, $m)) {
                    $valor = $segmentosUri[$i];
                    $parametros[] = is_numeric($valor) ? (int)$valor : $valor;
                } elseif ($segRota !== $segmentosUri[$i]) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) {
                if (!empty($parametros)) {
                    (new $acao[0]())->{$acao[1]}(...$parametros);
                } else {
                    (new $acao[0]())->{$acao[1]}();
                }
                return;
            }
        }

        $this->responderNaoEncontrado();
    }

    private function segmentos(string $uri): array {
        $uri = trim($uri, '/');
        return $uri === '' ? [] : explode('/', $uri);
    }

    private function registrarLog(string $metodo, string $uri): void {
        $caminho = dirname(__DIR__, 2) . '/logs/acessos.log';
        $pasta = dirname($caminho);
        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }
        $dataHora = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $linha = sprintf("[%s] [%s] [%s] %s%s", $dataHora, $ip, $metodo, $uri, PHP_EOL);
        file_put_contents($caminho, $linha, FILE_APPEND | LOCK_EX);
    }

    private function responderNaoEncontrado(): void {
        http_response_code(404);
        echo "<h1 style='font-family:sans-serif;text-align:center;margin-top:50px;'>404 - Rota Nao Encontrada</h1>";
    }
}
