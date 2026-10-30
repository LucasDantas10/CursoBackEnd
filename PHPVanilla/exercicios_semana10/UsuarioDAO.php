<?php
declare(strict_types=1);

require_once 'conexao.php';

class UsuarioDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $resultado = $stmt->fetch();
        if ($resultado) {
            return $resultado;
        }
        return null;
    }

    public function cadastrar(string $nome, string $email, string $senha, string $perfil): bool
    {
        $senhaHash = password_hash($senha, PASSWORD_ARGON2ID);
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)');
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senhaHash,
            ':perfil' => $perfil
        ]);
        return true;
    }
}