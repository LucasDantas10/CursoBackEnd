<?php
declare(strict_types=1);
?>

<?php

function calcularIMC(float $peso, float $altura): float{
    return $peso / ($altura * $altura);
}

$imc = calcularIMC(88.00, 1.85);

echo "Seu IMC é " . number_format($imc, 2, ",", ".");
?>