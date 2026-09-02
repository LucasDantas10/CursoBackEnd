<?php
declare(strict_types=1);

function buscarCliente(array $clientes, string $nome): ?array
{
    foreach ($clientes as $cliente) {
        if ($cliente["nome"] === $nome) {
            return $cliente;
        }
    }

    return null;
}

$clientes = [
    [
        "nome" => "João",
        "email" => "joao@email.com"
    ],
    [
        "nome" => "Maria",
        "email" => "maria@email.com"
    ]
];

// Cliente encontrado
$cliente = buscarCliente($clientes, "Maria");

if ($cliente !== null) {
    echo "Cliente encontrado: " . $cliente["nome"] . "\n";
    echo "E-mail: " . $cliente["email"] . "\n";
} else {
    echo "Cliente não encontrado." . "\n";
}

// Cliente não encontrado
$cliente = buscarCliente($clientes, "Pedro");

if ($cliente !== null) {
    echo "Cliente encontrado: " . $cliente["nome"];
} else {
    echo "Cliente não encontrado.";
}
