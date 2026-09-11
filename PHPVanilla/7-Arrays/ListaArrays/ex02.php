<?php

declare(strict_types=1);

// Exercício 2: Perfil do Usuário

$usuario = [
    "nome" => "Carlos Eduardo",
    "idade" => 28,
    "cidade" => "Americana",
    "estado" => "SP",
    "premium" => true
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div>
        <h2>
            <?php
            echo $usuario["nome"];

            if ($usuario["premium"]) {
                echo "⭐";
            }
            ?>
        </h2>
        <p> <strong>Idade:</strong> <?php echo $usuario["idade"]; ?> anos </p>

        <p>
            <strong>Localização:</strong>
            <?php echo $usuario["cidade"] . " - " . $usuario["estado"]; ?>
        </p>

    </div>


</body>

</html>