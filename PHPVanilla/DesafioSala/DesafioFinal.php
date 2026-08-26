<?php
declare(strict_types=1);

$produtos = [
    1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10],
    2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8],
    3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5],
    4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6]
];

$pedido = [];

do {
    echo "\n1 - Listar Produtos\n";
    echo "2 - Adicionar Produto\n";
    echo "3 - Ver Pedido\n";
    echo "4 - Finalizar Compra\n";
    echo "0 - Sair\n";

    $opcao = (int) readline("Escolha: ");

    if ($opcao == 1) {
        foreach ($produtos as $id => $produto) {
            echo "$id - {$produto['nome']} - R$ {$produto['preco']}\n";
        }

    } elseif ($opcao == 2) {
        $id = (int) readline("Digite o código: ");

        if (isset($produtos[$id])) {
            $pedido[] = $produtos[$id];
            echo "Produto adicionado!\n";
        } else {
            echo "Produto inválido!\n";
        }

    } elseif ($opcao == 3) {
        print_r($pedido);

    } elseif ($opcao == 4) {
        echo "Compra finalizada!\n";
        break;

    } elseif ($opcao != 0) {
        echo "Opção inválida!\n";
    }

} while ($opcao != 0);
