<?php
declare(strict_types=1);

// Função para escapar os textos e evitar XSS
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Captura o termo pesquisado
$busca = $_GET["q"] ?? "";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca Blindada</title>
</head>
<body>

    <h1>Busca de Produtos</h1>

    <form method="GET">

        <label for="q">Pesquisar:</label>
        <br>

        <input
            type="text"
            name="q"
            value="<?= e($busca) ?>"
        >

        <button type="submit">Buscar</button>

    </form>

    <?php if ($busca !== ''): ?>

        <h2>Resultado da busca</h2>

        <p>
            Você buscou por: <?= e($busca) ?>
        </p>

    <?php endif; ?>

</body>
</html>
