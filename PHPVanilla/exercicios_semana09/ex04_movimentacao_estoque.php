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

final class EstoqueDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registrarMovimentacao(int $pecaId, int $quantidade, string $tipo): bool
    {
        if ($quantidade <= 0) {
            return false;
        }

        $this->pdo->beginTransaction();

        try {
            $saldo = $this->obterSaldo($pecaId);
            $novoSaldo = $saldo === null ? null : $this->calcularNovoSaldo($saldo, $quantidade, $tipo);
            $concluido = $novoSaldo !== null
                && $this->atualizarSaldo($pecaId, $novoSaldo)
                && $this->inserirMovimentacao($pecaId, $quantidade, $tipo);

            return $concluido ? $this->confirmar() : $this->desfazer();
        } catch (Throwable $erro) {
            return $this->desfazer();
        }
    }

    private function obterSaldo(int $pecaId): ?int
    {
        $stmt = $this->pdo->prepare('SELECT quantidade FROM pecas_industriais WHERE id = :id AND ativo = TRUE');
        $stmt->execute([':id' => $pecaId]);
        $valor = $stmt->fetchColumn();

        return $valor === false ? null : (int) $valor;
    }

    private function calcularNovoSaldo(int $saldo, int $quantidade, string $tipo): ?int
    {
        $novoSaldo = match ($tipo) {
            'entrada' => $saldo + $quantidade,
            'saida' => $saldo - $quantidade,
            default => null
        };

        return $novoSaldo !== null && $novoSaldo >= 0 ? $novoSaldo : null;
    }

    private function atualizarSaldo(int $pecaId, int $novoSaldo): bool
    {
        $stmt = $this->pdo->prepare('UPDATE pecas_industriais SET quantidade = :quantidade WHERE id = :id');
        $stmt->bindValue(':quantidade', $novoSaldo, PDO::PARAM_INT);
        $stmt->bindValue(':id', $pecaId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function inserirMovimentacao(int $pecaId, int $quantidade, string $tipo): bool
    {
        $sql = 'INSERT INTO movimentacoes_estoque (peca_id, tipo, quantidade) VALUES (:peca_id, :tipo, :quantidade)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':peca_id', $pecaId, PDO::PARAM_INT);
        $stmt->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function confirmar(): bool
    {
        $this->pdo->commit();

        return true;
    }

    private function desfazer(): bool
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }

        return false;
    }

    public function saldo(int $pecaId): int
    {
        $saldo = $this->obterSaldo($pecaId);

        return $saldo ?? 0;
    }

    public function historico(PDO $pdo, int $pecaId): array
    {
        $stmt = $pdo->prepare('SELECT tipo, quantidade FROM movimentacoes_estoque WHERE peca_id = :id ORDER BY id');
        $stmt->execute([':id' => $pecaId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function executarCenario(EstoqueDAO $dao, int $pecaId, int $quantidade, string $tipo): void
{
    $antes = $dao->saldo($pecaId);
    $resultado = $dao->registrarMovimentacao($pecaId, $quantidade, $tipo);
    printf(
        '%-8s quantidade=%-5d saldo antes=%-5d depois=%-5d retorno=%s%s',
        $tipo,
        $quantidade,
        $antes,
        $dao->saldo($pecaId),
        $resultado ? 'true (commit)' : 'false (rollBack)',
        PHP_EOL
    );
}

function main(): void
{
    try {
        $pdo = conectar();
    } catch (PDOException $erro) {
        echo 'Falha na conexao: ', $erro->getMessage(), PHP_EOL;

        return;
    }

    $dao = new EstoqueDAO($pdo);
    $pecaId = 1;
    echo 'Controle de movimentacao com transacao ACID - peca id ', $pecaId, PHP_EOL;
    executarCenario($dao, $pecaId, 10, 'entrada');
    executarCenario($dao, $pecaId, 5, 'saida');
    executarCenario($dao, $pecaId, 9999, 'saida');
    echo 'Historico de movimentacoes gravado:', PHP_EOL;

    foreach ($dao->historico($pdo, $pecaId) as $registro) {
        printf('  %s de %d%s', $registro['tipo'], $registro['quantidade'], PHP_EOL);
    }
}

main();
