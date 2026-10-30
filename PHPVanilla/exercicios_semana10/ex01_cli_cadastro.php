<?php
declare(strict_types=1);

require_once 'conexao.php';
require_once 'UsuarioDAO.php';

echo "Nome: ";
$nome = trim(fgets(STDIN));

echo "Email: ";
$email = trim(fgets(STDIN));

echo "Senha: ";
$senha = trim(fgets(STDIN));

if (strlen($senha) < 8) {
    echo "Erro: senha deve ter pelo menos 8 caracteres\n";
    exit;
}

if (!preg_match('/[A-Z]/', $senha)) {
    echo "Erro: senha deve conter pelo menos uma letra maiuscula\n";
    exit;
}

if (!preg_match('/[a-z]/', $senha)) {
    echo "Erro: senha deve conter pelo menos uma letra minuscula\n";
    exit;
}

if (!preg_match('/[0-9]/', $senha)) {
    echo "Erro: senha deve conter pelo menos um numero\n";
    exit;
}

if (!preg_match('/[^A-Za-z0-9]/', $senha)) {
    echo "Erro: senha deve conter pelo menos um caractere especial\n";
    exit;
}

$dao = new UsuarioDAO($pdo);

try {
    $dao->cadastrar($nome, $email, $senha, 'OPERADOR');
    echo "Cadastro realizado com sucesso\n";
} catch (Exception $e) {
    echo "Erro ao cadastrar: " . $e->getMessage() . "\n";
}