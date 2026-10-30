<?php
declare(strict_types=1);

require_once 'guard.php';

verificarPermissao('ADMIN');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>RBAC Guard</title>
</head>
<body>
    <h1>Controle de Acesso RBAC</h1>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['perfil']); ?>)</p>
    <p>Voce tem acesso a esta pagina administrativa.</p>
    <p><a href="logout.php">Sair</a></p>
</body>
</html>