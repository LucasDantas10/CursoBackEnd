<?php

declare(strict_types=1);

// Função para escapar os textos e evitar XSS
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

// Array para guardar os recados
$recados = [];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Validação do nome
    if (mb_strlen($nome) < 3) {
        $erro = "O nome precisa ter no mínimo 3 caracteres.";
    }

    // Validação da mensagem
    elseif (mb_strlen($mensagem) < 5) {
        $erro = "A mensagem precisa ter no mínimo 5 caracteres.";
    }

    // Se estiver tudo certo, salva o recado
    else {
        $recados[] = [
            'nome' => $nome,
            'mensagem' => $mensagem
        ];

        $sucesso = "Recado enviado com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mural de Recados</title>
</head>
<body>

    <h1>Mural de Recados</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;">
            <?= e($erro) ?>
        </p>
    <?php endif; ?>

    <?php if (isset($sucesso)): ?>
        <p style="color: green;">
            <?= e($sucesso) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label for="nome">Nome:</label>
        <br>
        <input type="text" id="nome" name="nome" required>

        <br><br>

        <label for="mensagem">Mensagem:</label>
        <br>
        <textarea id="mensagem" name="mensagem" required></textarea>

        <br><br>

        <button type="submit">Enviar Recado</button>

    </form>

    <hr>

    <h2>Recados</h2>

    <?php foreach ($recados as $recado): ?>

        <div>
            <strong><?= e($recado['nome']) ?></strong>

            <p>
                <?= nl2br(e($recado['mensagem'])) ?>
            </p>
        </div>

        <hr>

    <?php endforeach; ?>

</body>
</html>
