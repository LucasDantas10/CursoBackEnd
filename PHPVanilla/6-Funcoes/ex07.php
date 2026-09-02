<?php
declare(strict_types=1);

function calcularMedia(array $notas): float
{
    return array_sum($notas) / count($notas);
}

function verificarAprovacao(float $media): string
{
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

$notas = [8.0, 7.5, 6.0, 9.0];

$media = calcularMedia($notas);
$situacao = verificarAprovacao($media);
$maior = max($notas);
$menor = min($notas);

echo "Média: " . number_format($media, 2, ',', '.') . "\n";
echo "Situação: " . $situacao . "\n";
echo "Maior nota: " . $maior . "\n";
echo "Menor nota: " . $menor;
