<?php

declare(strict_types=1);


// Função para escapar os textos e evitar XSS
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$arquivo = 'chat.json';
$mensagens = [];
$erro = '';

// Se o arquivo já existir, carrega as mensagens salvas
if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $mensagens = json_decode($conteudo, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $operador = trim($_POST['operador'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Verifica se a mensagem não passa de 250 caracteres
    if (mb_strlen($mensagem) > 250) {
        $erro = 'A mensagem não pode ter mais de 250 caracteres.';
    } elseif ($mensagem === '') {
        $erro = 'A mensagem não pode ficar vazia.';
    } elseif ($operador === '') {
        $erro = 'Informe o nome do operador.';
    } else {

        // Adiciona a nova mensagem no array
        $mensagens[] = [
            'operador' => $operador,
            'mensagem' => $mensagem
        ];

        // Salva as mensagens no arquivo JSON
        file_put_contents(
            $arquivo,
            json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat da Operação</title>
</head>
<body>

    <h1>Chat Industrial</h1>

    <?php if ($erro): ?>

        <p style="color: red;">
            <?= e($erro) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label for="operador">Nome:</label>
        <br>

        <input
            type="text"
            id="operador"
            name="operador"
            required
        >

        <br><br>

        <label for="mensagem">Mensagem:</label>
        <br>

        <textarea
            id="mensagem"
            name="mensagem"
            maxlength="250"
            required
        ></textarea>

        <br><br>

        <button type="submit">Enviar</button>

    </form>

    <hr>

    <h2>Mensagens</h2>

    <?php foreach ($mensagens as $item): ?>

        <div>

            <strong>
                <?= e($item['operador']) ?>
            </strong>

            <p>
                <?= nl2br(e($item['mensagem'])) ?>
            </p>

        </div>

        <hr>

    <?php endforeach; ?>

</body>
</html>
