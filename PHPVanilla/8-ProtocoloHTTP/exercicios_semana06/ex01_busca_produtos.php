<?php

declare(strict_types=1);

$produtos = [
    ['nome' => 'Notebook', 'categoria' => 'Informática', 'preco' => 3500.00],
    ['nome' => 'Mouse', 'categoria' => 'Periféricos', 'preco' => 80.00],
    ['nome' => 'Teclado', 'categoria' => 'Periféricos', 'preco' => 150.00],
    ['nome' => 'Monitor', 'categoria' => 'Informática', 'preco' => 1200.00],
    ['nome' => 'Headset', 'categoria' => 'Áudio', 'preco' => 250.00],
    ['nome' => 'Webcam', 'categoria' => 'Acessórios', 'preco' => 300.00],
];

$nomeBusca = trim($_GET['nome'] ?? '');
$precoMaximo = $_GET['preco_maximo'] ?? '';

$produtosFiltrados = array_filter($produtos, function (array $produto) use ($nomeBusca, $precoMaximo): bool {
    $correspondeNome = $nomeBusca === ''
        || stripos($produto['nome'], $nomeBusca) !== false;

    $correspondePreco = $precoMaximo === ''
        || $produto['preco'] <= (float) $precoMaximo;

    return $correspondeNome && $correspondePreco;
});
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Buscador de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
        }

        form {
            padding: 20px;
            background: #4982eb;
            border-radius: 8px;
        }

        input,button {
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
        }

        .produto {
            border: 1px solid #000000;
            padding: 15px;
            margin-top: 10px;
            border-radius: 6px;
            cursor: pointer;

            &:hover {
                transform: translateY(-3px);
            }
        }
    </style>
</head>

<body>

    <h1>Catálogo de Produtos</h1>

    <form method="GET">
        <label>
            Nome do produto:
            <input
                type="text"
                name="nome"
                value="<?= htmlspecialchars($nomeBusca) ?>">
        </label>

        <label>
            Preço máximo:
            <input
                type="number"
                name="preco_maximo"
                step="0.01"
                min="0"
                value="<?= htmlspecialchars((string) $precoMaximo) ?>">
        </label>

        <button type="submit">Filtrar</button>
    </form>

    <h2>Produtos encontrados</h2>

    <?php if (count($produtosFiltrados) > 0): ?>

        <?php foreach ($produtosFiltrados as $produto): ?>
            <div class="produto">
                <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                Categoria: <?= htmlspecialchars($produto['categoria']) ?><br>
                Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </div>
        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum produto encontrado.</p>

    <?php endif; ?>

</body>