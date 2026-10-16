<?php
declare(strict_types=1);

const DB_HOST = '127.0.0.1';
const DB_PORT = '5432';
const DB_NAME = 'semana09';
const DB_USER = 'postgres';
const DB_PASS = 'postgres';

function conectar(): PDO
{
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function garantirColunaAtivo(PDO $pdo): void
{
    $pdo->exec('ALTER TABLE pecas_industriais ADD COLUMN IF NOT EXISTS ativo BOOLEAN DEFAULT TRUE');
    $pdo->exec('UPDATE pecas_industriais SET ativo = TRUE WHERE ativo IS NULL');
}

final class PecaDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function excluir(int $id): bool
    {
        $sql = 'UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function listarTodos(): array
    {
        $sql = 'SELECT id, codigo_sku, descricao, quantidade
                FROM pecas_industriais
                WHERE ativo = TRUE
                ORDER BY id ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodosSemFiltro(): array
    {
        $sql = 'SELECT id, codigo_sku, descricao, quantidade, ativo
                FROM pecas_industriais
                ORDER BY id ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function exibirLista(string $titulo, array $pecas, bool $mostrarAtivo = false): void
{
    echo $titulo, ' (', count($pecas), ' registro(s))', PHP_EOL;

    foreach ($pecas as $peca) {
        printf(
            '  #%d | %s | %s | qtd: %d%s%s',
            $peca['id'],
            $peca['codigo_sku'],
            $peca['descricao'],
            $peca['quantidade'],
            $mostrarAtivo ? ' | ativo: ' . ($peca['ativo'] ? 'TRUE' : 'FALSE') : '',
            PHP_EOL
        );
    }
}

function main(): void
{
    try {
        $pdo = conectar();
        garantirColunaAtivo($pdo);
    } catch (PDOException $erro) {
        echo 'Falha na conexao: ', $erro->getMessage(), PHP_EOL;

        return;
    }

    $dao = new PecaDAO($pdo);
    exibirLista('Antes da exclusao logica (listarTodos)', $dao->listarTodos());
    $idExcluido = 2;
    $resultado = $dao->excluir($idExcluido);
    echo 'excluir(', $idExcluido, ') executado com prepared statement: retorno = ', $resultado ? 'true' : 'false', PHP_EOL;
    exibirLista('Depois da exclusao logica (listarTodos)', $dao->listarTodos());
    exibirLista('Auditoria: todos os registros ainda presentes no banco', $dao->listarTodosSemFiltro(), true);
}

main();
