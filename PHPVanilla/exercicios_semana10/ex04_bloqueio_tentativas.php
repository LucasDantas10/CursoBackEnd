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

$senhaCorreta = 'senha123';
$maxTentativas = 3;
$tempoBloqueio = 60;

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senhaDigitada = $_POST['senha'] ?? '';

    if (isset($_SESSION['bloqueio_ate']) && time() < $_SESSION['bloqueio_ate']) {
        $restante = $_SESSION['bloqueio_ate'] - time();
        $mensagem = "Bloqueado. Tente novamente em $restante segundos.";
    } else {
        if ($senhaDigitada === $senhaCorreta) {
            $_SESSION['tentativas_login'] = 0;
            unset($_SESSION['bloqueio_ate']);
            $mensagem = "Login realizado com sucesso!";
        } else {
            $_SESSION['tentativas_login'] = ($_SESSION['tentativas_login'] ?? 0) + 1;

            if ($_SESSION['tentativas_login'] >= $maxTentativas) {
                $_SESSION['bloqueio_ate'] = time() + $tempoBloqueio;
                $mensagem = "Bloqueado por 60 segundos apos 3 tentativas incorretas.";
            } else {
                $restantes = $maxTentativas - $_SESSION['tentativas_login'];
                $mensagem = "Senha incorreta. Restam $restantes tentativa(s).";
            }
        }
    }
}

$contador = 0;
if (isset($_SESSION['bloqueio_ate']) && time() < $_SESSION['bloqueio_ate']) {
    $contador = $_SESSION['bloqueio_ate'] - time();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login com Bloqueio</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($mensagem): ?>
        <p style="color:red"><?php echo htmlspecialchars($mensagem); ?></p>
    <?php endif; ?>
    <?php if ($contador > 0): ?>
        <p>Bloqueado por <?php echo $contador; ?> segundos.</p>
    <?php else: ?>
        <form method="POST">
            <label>Senha:<br><input type="password" name="senha" required><br></label>
            <br>
            <button type="submit">Entrar</button>
        </form>
    <?php endif; ?>
</body>
</html>