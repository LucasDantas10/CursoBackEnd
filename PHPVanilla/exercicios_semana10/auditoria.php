<?php
declare(strict_types=1);

require_once 'conexao.php';
require_once 'guard.php';

verificarPermissao('ADMIN');

$stmt = $pdo->prepare('SELECT * FROM auditoria_logins ORDER BY data_hora DESC LIMIT 20');
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel de Auditoria</title>
</head>
<body>
    <h1>Painel de Auditoria</h1>

    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></p>

    <p><a href="logout.php">Sair</a></p>

    <table border="1">
        <tr>
            <th>Email</th>
            <th>IP</th>
            <th>Navegador</th>
            <th>Resultado</th>
            <th>Data/Hora</th>
        </tr>

        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?php echo htmlspecialchars($log['email']); ?></td>
            <td><?php echo htmlspecialchars($log['ip'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($log['user_agent'] ?? ''); ?></td>
            <td><?php echo $log['sucesso'] ? 'Sucesso' : 'Falha'; ?></td>
            <td><?php echo htmlspecialchars($log['data_hora']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>