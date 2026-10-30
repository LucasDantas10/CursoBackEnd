<?php
declare(strict_types=1);

ini_set('session.use_strict_mode', '1');

$secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? true : false;

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => $secure
]);

session_start();

require_once 'conexao.php';
require_once 'UsuarioDAO.php';

$dao = new UsuarioDAO($pdo);
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $usuario = $dao->buscarPorEmail($email);
    $sucesso = false;

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $sucesso = true;
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'perfil' => $usuario['perfil']
        ];
        session_regenerate_id(true);
        $_SESSION['ultima_atividade'] = time();
        header('Location: auditoria.php');
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO auditoria_logins (email, ip, user_agent, sucesso) VALUES (:email, :ip, :user_agent, :sucesso)');
    $stmt->execute([
        ':email' => $email,
        ':ip' => $ip,
        ':user_agent' => $userAgent,
        ':sucesso' => $sucesso
    ]);

    $mensagem = 'Email ou senha invalidos';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login com Auditoria</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($mensagem): ?>
        <p style="color:red"><?php echo htmlspecialchars($mensagem); ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Email:<br><input type="email" name="email" required><br></label>
        <label>Senha:<br><input type="password" name="senha" required><br></label>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>