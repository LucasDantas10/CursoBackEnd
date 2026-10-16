<?php
declare(strict_types=1);

const DB_HOST = '127.0.0.1';
const DB_PORT = '5432';
const DB_NAME = 'semana09';
const DB_USER = 'postgres';
const DB_PASS = 'postgres';
const ITENS_POR_PAGINA = 5;

function conectar(): PDO
{
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function paginaAtual(): int
{
    $pagina = (int)($_GET['p'] ?? 1);

    return $pagina < 1 ? 1 : $pagina;
}

function deslocamento(int $pagina): int
{
    $offset = ($pagina - 1) * 5;

    return $offset;
}

function listarPagina(PDO $pdo, int $offset): array
{
    $sql = 'SELECT id, codigo_sku, descricao, categoria, quantidade, preco_unitario
            FROM pecas_industriais
            WHERE ativo = TRUE
            ORDER BY id ASC
            LIMIT :limite OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', 5, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function totalDePaginas(PDO $pdo): int
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pecas_industriais WHERE ativo = TRUE');
    $stmt->execute();
    $total = (int) $stmt->fetchColumn();

    return (int) ceil($total / ITENS_POR_PAGINA);
}

function montarCabecalho(string $titulo): void
{
    echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>', $titulo, '</title></head><body>';
    echo '<h1>', $titulo, '</h1>';
}

function montarTabela(array $pecas): void
{
    echo '<table border="1" cellpadding="6" cellspacing="0">';
    echo '<tr><th>ID</th><th>SKU</th><th>Descricao</th><th>Categoria</th><th>Qtd</th><th>Preco</th></tr>';

    foreach ($pecas as $peca) {
        printf('<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>R$ %s</td></tr>', $peca['id'], $peca['codigo_sku'], $peca['descricao'], $peca['categoria'], $peca['quantidade'], $peca['preco_unitario']);
    }

    echo '</table>';
}

function montarPaginacao(int $pagina, int $totalPaginas): void
{
    echo '<p>Pagina ', $pagina, ' de ', $totalPaginas, ' (5 itens por pagina via LIMIT e OFFSET parametrizados)</p>';

    for ($numero = 1; $numero <= $totalPaginas; $numero++) {
        printf(
            '<a href="?p=%d"%s> %d </a> | ',
            $numero,
            $numero === $pagina ? ' style="font-weight:bold"' : '',
            $numero
        );
    }
}

function main(): void
{
    $pagina = paginaAtual();
    $offset = deslocamento($pagina);
    montarCabecalho('Catalogo de Pecas Industriais - Pagina ' . $pagina);

    try {
        $pdo = conectar();
        $pecas = listarPagina($pdo, $offset);
        $totalPaginas = totalDePaginas($pdo);
        montarTabela($pecas);
        montarPaginacao($pagina, $totalPaginas);
    } catch (PDOException $erro) {
        echo '<p>Erro ao consultar o banco: ', htmlspecialchars($erro->getMessage()), '</p>';
    }

    echo '</body></html>';
}

main();
