<?php
declare(strict_types=1);

$funcionarios = [
    ["id" => 1, "nome" => "Ana Souza", "cargo" => "Dev Front-End", "salario" => 4500.00],
    ["id" => 2, "nome" => "Bruno Costa", "cargo" => "Dev Back-End", "salario" => 5200.00],
    ["id" => 3, "nome" => "Carla Dias", "cargo" => "Tech Lead", "salario" => 8900.00],
    ["id" => 4, "nome" => "Daniel Silva", "cargo" => "Estagiário", "salario" => 1500.00],
];

$totalFolha = 0;

foreach ($funcionarios as $funcionario) {
    $totalFolha += $funcionario["salario"];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Folha de Pagamento</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>Folha de Pagamento do RH</h1>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Salário</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($funcionarios as $funcionario): ?>

                    <tr>
                        <td>
                            <?php echo $funcionario["id"]; ?>
                        </td>

                        <td>
                            <?php echo $funcionario["nome"]; ?>
                        </td>

                        <td>
                            <?php echo $funcionario["cargo"]; ?>
                        </td>

                        <td>
                            <?php
                            echo "R$ " . number_format(
                                $funcionario["salario"],
                                2,
                                ",",
                                "."
                            );
                            ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3">
                        <strong>Total da folha</strong>
                    </td>

                    <td>
                        <strong>
                            <?php
                            echo "R$ " . number_format(
                                $totalFolha,
                                2,
                                ",",
                                "."
                            );
                            ?>
                        </strong>
                    </td>
                </tr>
            </tfoot>

        </table>

    </div>

</body>

</html>
