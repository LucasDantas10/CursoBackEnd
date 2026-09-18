<?php
declare(strict_types=1);

// Função para limpar textos
function sanitizarTexto(string $dado): string
{
    return strip_tags(trim($dado));
}

// Função para validar os dados do colaborador
function validarColaborador(array $dados): array
{
    $erros = [];

    // Validação do nome
    if (empty($dados['nome'])) {
        $erros['nome'] = 'O nome é obrigatório.';
    }

    // Validação do e-mail
    if (
        empty($dados['email']) ||
        filter_var($dados['email'], FILTER_VALIDATE_EMAIL) === false
    ) {
        $erros['email'] = 'Digite um e-mail válido.';
    }

    // Validação da matrícula
    if (
        empty($dados['matricula']) ||
        filter_var($dados['matricula'], FILTER_VALIDATE_INT) === false
    ) {
        $erros['matricula'] = 'A matrícula precisa ser um número inteiro.';
    }

    // Validação do salário
    if (
        empty($dados['salario']) ||
        filter_var($dados['salario'], FILTER_VALIDATE_FLOAT) === false
    ) {
        $erros['salario'] = 'Digite um salário válido.';
    }

    return $erros;
}

$dados = [
    'nome' => '',
    'email' => '',
    'matricula' => '',
    'salario' => ''
];

$erros = [];
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitização dos textos
    $dados['nome'] = sanitizarTexto($_POST['nome'] ?? '');
    $dados['email'] = sanitizarTexto($_POST['email'] ?? '');
    $dados['matricula'] = trim($_POST['matricula'] ?? '');
    $dados['salario'] = trim($_POST['salario'] ?? '');

    // Validação dos dados
    $erros = validarColaborador($dados);

    if (empty($erros)) {
        $sucesso = true;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaborador</title>
</head>
<body>

    <h1>Cadastro de Colaborador</h1>

    <?php if (!empty($erros)): ?>

        <div style="color: red;">
            <h2>Erros encontrados:</h2>

            <?php foreach ($erros as $erro): ?>
                <p><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <?php if ($sucesso): ?>

        <div style="color: green;">

            <h2>Colaborador cadastrado com sucesso!</h2>

            <p>
                Nome: <?= htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <p>
                E-mail: <?= htmlspecialchars($dados['email'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <p>
                Matrícula: <?= htmlspecialchars($dados['matricula'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <p>
                Salário: R$ <?= htmlspecialchars($dados['salario'], ENT_QUOTES, 'UTF-8') ?>
            </p>

        </div>

    <?php endif; ?>

    <form method="POST">

        <label for="nome">Nome:</label>
        <br>
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($dados['nome'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <br><br>

        <label for="email">E-mail:</label>
        <br>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($dados['email'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <br><br>

        <label for="matricula">Matrícula:</label>
        <br>
        <input
            type="number"
            id="matricula"
            name="matricula"
            value="<?= htmlspecialchars($dados['matricula'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <br><br>

        <label for="salario">Salário:</label>
        <br>
        <input
            type="text"
            id="salario"
            name="salario"
            value="<?= htmlspecialchars($dados['salario'], ENT_QUOTES, 'UTF-8') ?>"
            required
        >

        <br><br>

        <button type="submit">Cadastrar</button>

    </form>

</body>
</html>
