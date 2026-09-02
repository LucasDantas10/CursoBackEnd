<?php
declare(strict_types=1);

function retirarEstoque(array &$produto, int $quantidade): bool
{
    if ($quantidade <= 0 || $quantidade > $produto["estoque"]) {
        return false;
    }

    $produto["estoque"] -= $quantidade;

    return true;
}

$produto = [
    "nome" => "Caderno",
    "estoque" => 10
];

// Retirada permitida
if (retirarEstoque($produto, 3)) {
    echo "Retirada realizada com sucesso!" . "\n";
    echo "Estoque atual: " . $produto["estoque"] . "\n";
} else {
    echo "Não foi possível realizar a retirada." . "\n";
}

// Retirada recusada
if (retirarEstoque($produto, 20)) {
    echo "Retirada realizada com sucesso!" . "\n";
} else {
    echo "Retirada recusada: estoque insuficiente." . "\n";
}

echo "Estoque final: " . $produto["estoque"];
