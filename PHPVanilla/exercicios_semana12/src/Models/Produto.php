<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

// Model dos Produtos.
// Toda a consulta SQL fica concentrada nesta camada, utilizando Prepared Statements.

final class Produto {
    private static function pdo(): PDO {
        $caminho = dirname(__DIR__, 2) . '/config/database.ini';
        return ConexaoBanco::obterConexao($caminho);
    }

    public static function listarTodos(): array {
        $sql = "SELECT id, nome, categoria, preco, estoque FROM produtos ORDER BY nome ASC";
        return self::pdo()->query($sql)->fetchAll();
    }

    public static function buscarPorId(int $id): ?array {
        $sql = "SELECT id, nome, categoria, preco, estoque FROM produtos WHERE id = :id LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function excluir(int $id): bool {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = self::pdo()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function buscarPorCategoria(string $categoria): array {
        $sql = "SELECT id, nome, categoria, preco, estoque FROM produtos WHERE categoria = :categoria ORDER BY nome ASC";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        return $stmt->fetchAll();
    }

    public static function listarCategorias(): array {
        $sql = "SELECT DISTINCT categoria FROM produtos ORDER BY categoria ASC";
        $stmt = self::pdo()->query($sql);
        $categorias = [];
        foreach ($stmt->fetchAll() as $linha) {
            $categorias[] = $linha['categoria'];
        }
        return $categorias;
    }
}
