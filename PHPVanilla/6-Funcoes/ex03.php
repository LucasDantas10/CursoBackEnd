<?php
declare(strict_types=1);

function senhaForte(string $senha): bool
{
    return strlen($senha) >= 8;
}

$senha = "Senha123";

if (senhaForte($senha)) {
    echo "Senha forte!";
} else {
    echo "Senha fraca. A senha deve ter mais de 8 caracteres.";
}
