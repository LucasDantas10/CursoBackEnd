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

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

header('Location: ex05_log_acessos.php');
exit;