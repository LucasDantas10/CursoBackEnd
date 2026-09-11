<?php
declare(strict_types=1);

// Lista de produtos
$produtos = [
    ['id' => 1, 'nome' => 'iPhone 15', 'categoria' => 'Smartphone', 'preco' => 6500.00],
    ['id' => 2, 'nome' => 'Galaxy S24', 'categoria' => 'Smartphone', 'preco' => 5400.00],
    ['id' => 3, 'nome' => 'MacBook Air', 'categoria' => 'Notebook', 'preco' => 8900.00],
    ['id' => 4, 'nome' => 'Monitor Dell 27', 'categoria' => 'Perifericos', 'preco' => 1200.00],
    ['id' => 5, 'nome' => 'Mouse Logitech', 'categoria' => 'Perifericos', 'preco' => 450.00],
];


// Filtrar apenas os Smartphones
$smartphones = array_filter($produtos, function($p) {
    return $p['categoria'] == 'Smartphone';
});


// Aplicar 15% de desconto
$smartphonesComDesconto = array_map(function($p) {

    $p['preco'] = $p['preco'] * 0.85;

    return $p;

}, $smartphones);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Vitrine TechSenai</title>

    <link rel="stylesheet" href="../style.css">

</head>

<body>

    <h1 class="titulo1">TechSenai</h1>

    <h2 class="subtitulo1">
        Ofertas Especiais: Smartphones (15% OFF)
    </h2>


    <div class="cards">

        <?php foreach ($smartphonesComDesconto as $produto): ?>

            <div class="card">

                <span class="categoria">
                    <?php echo $produto['categoria']; ?>
                </span>

                <h2 class="nome">
                    <?php echo $produto['nome']; ?>
                </h2>

                <p class="preco">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </p>

                <span class="desconto">
                    15% OFF
                </span>

            </div>

        <?php endforeach; ?>

    </div>

</body>

</html>