<?php
declare(strict_types=1);

function limparCPF(string $cpf): string
{
    return str_replace([".", "-"], "", $cpf);
}

function cpfValido(string $cpf): bool
{
    $cpfLimpo = limparCPF($cpf);

    return strlen($cpfLimpo) === 11 && is_numeric($cpfLimpo);
}

$cpf1 = "123.456.789-00";
$cpf2 = "123.456.789";
$cpf3 = "abc.def.ghi-jk";

echo "CPF 1: " . limparCPF($cpf1) . "\n";
echo cpfValido($cpf1) ? "CPF válido" : "CPF inválido";
echo "\n";

echo cpfValido($cpf2) ? "CPF válido" : "CPF inválido";
echo "\n";

echo cpfValido($cpf3) ? "CPF válido" : "CPF inválido";
