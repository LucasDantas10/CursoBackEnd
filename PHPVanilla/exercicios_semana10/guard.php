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

$timeout = 15 * 60;

if (!isset($_SESSION['usuario'])) {
    header('Location: ex05_log_acessos.php');
    exit;
}

if (isset($_SESSION['ultima_atividade'])) {
    $inativo = time() - $_SESSION['ultima_atividade'];
    if ($inativo > $timeout) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header('Location: ex05_log_acessos.php');
        exit;
    }
}

$_SESSION['ultima_atividade'] = time();

function verificarPermissao(string $perfilMinimo): void
{
    if (!isset($_SESSION['usuario'])) {
        header('HTTP/1.1 403 Acesso Negado');
        echo '<h1>Acesso Negado</h1><p>Voce precisa estar autenticado.</p>';
        exit;
    }

    $perfil = $_SESSION['usuario']['perfil'];

    if ($perfilMinimo === 'ADMIN' && $perfil !== 'ADMIN') {
        header('HTTP/1.1 403 Acesso Negado');
        echo '<h1>Acesso Negado</h1><p>Apenas administradores podem acessar esta pagina.</p>';
        exit;
    }
}