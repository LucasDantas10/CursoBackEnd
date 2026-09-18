<?php
declare(strict_types=1);

// Função para escapar os textos e evitar XSS
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$nome = '';
$linkValido = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $url = trim($_POST['url'] ?? '');

    // Validação do nome
    if (mb_strlen($nome) < 3) {
        $erro = "O nome precisa ter no mínimo 3 caracteres.";
    }

    // Verifica se a URL possui um formato válido
    elseif (filter_var($url, FILTER_VALIDATE_URL) === false) {
        $erro = "Digite uma URL válida.";
    }

    // Verifica se a URL começa com http:// ou https://
    elseif (
        !str_starts_with($url, 'http://') &&
        !str_starts_with($url, 'https://')
    ) {
        $erro = "O link precisa começar com http:// ou https://.";
    }

    else {
        $linkValido = $url;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Validador de Links</title>
</head>
<body>

    <h1>Validador de Links de Portfólio</h1>

    <?php if ($erro): ?>
        <p style="color: red;">
            <?= e($erro) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label for="nome">Nome:</label>
        <br>
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= e($nome) ?>"
            required
        >

        <br><br>

        <label for="url">Link do GitHub ou LinkedIn:</label>
        <br>
        <input
            type="text"
            id="url"
            name="url"
            placeholder="https://github.com/usuario"
            required
        >

        <br><br>

        <button type="submit">Cadastrar</button>

    </form>

    <?php if ($linkValido): ?>

        <hr>

        <h2>Portfólio de <?= e($nome) ?></h2>

        <a href="<?= e($linkValido) ?>" target="_blank">
            Visitar Portfólio
        </a>

    <?php endif; ?>

</body>
</html>
