<?php
declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura ** 2);
}

function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return 'Abaixo do peso';
    }

    if ($imc < 25) {
        return 'Normal';
    }

    if ($imc < 30) {
        return 'Sobrepeso';
    }

    return 'Obesidade';
}

$nome = "";
$peso = "";
$altura = "";
$imc = null;
$classificacao = "  ";
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $peso = trim($_POST['peso'] ?? '');
    $altura = trim($_POST['altura'] ?? '');

    if ($peso === '' || !is_numeric($peso) || (float) $peso < 20 || (float) $peso > 300) {
        $erros[] = 'O peso deve estar entre 20 e 300 kg.';
    }

    if ($altura === '' || !is_numeric($altura) || (float) $altura < 0.5 || (float) $altura > 2.5) {
        $erros[] = 'A altura deve estar entre 0,5 e 2,5 metros.';
    }

    if (empty($erros)) {
        $imc = calcularIMC((float) $peso, (float) $altura);
        $classificacao = classificarIMC($imc);
    }
}

$classeResultado = '';

if ($classificacao === 'Normal') {
    $classeResultado = 'normal';
} elseif ($classificacao === 'Sobrepeso') {
    $classeResultado = 'sobrepeso';
} elseif ($classificacao === 'Obesidade') {
    $classeResultado = 'obesidade';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
        }

        form {
            padding: 20px;
            background: #f2f2f2;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
        }

        button {
            cursor: pointer;
            background: #0066cc;
            color: white;
            border: none;
            &:hover{
                transform: translateY(-3px);
            }
        }

        .erro {
            color: red;
            margin-top: 15px;
        }

        .resultado {
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }

        .normal {
            background: #c8f7c5;
            color: #176b18;
        }

        .sobrepeso {
            background: #fff3a3;
            color: #765f00;
        }

        .obesidade {
            background: #ffb3b3;
            color: #8b0000;
        }
    </style>
</head>
<body>

<h1>Calculadora de IMC</h1>

<form method="POST">

    <label>
        Nome:
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($nome) ?>"
        >
    </label>

    <label>
        Peso (kg):
        <input
            type="number"
            name="peso"
            step="0.1"
            value="<?= htmlspecialchars($peso) ?>"
        >
    </label>

    <label>
        Altura (m):
        <input
            type="number"
            name="altura"
            step="0.01"
            value="<?= htmlspecialchars($altura) ?>"
        >
    </label>

    <button type="submit">Calcular IMC</button>
</form>

<?php if (!empty($erros)): ?>
    <div class="erro">
        <?php foreach ($erros as $erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($imc !== null): ?>
    <div class="resultado <?= $classeResultado ?>">
        <h2>Resultado</h2>

        <p>
            Nome:
            <strong><?= htmlspecialchars($nome) ?></strong>
        </p>

        <p>
            IMC:
            <strong><?= number_format($imc, 2, ',', '.') ?></strong>
        </p>

        <p>
            Classificação:
            <strong><?= htmlspecialchars($classificacao) ?></strong>
        </p>
    </div>
<?php endif; ?>

</body>
</html>

</html>
