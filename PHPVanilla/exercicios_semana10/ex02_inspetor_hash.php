<?php
declare(strict_types=1);

echo "Digite uma senha: ";
$senha = trim(fgets(STDIN));

$hash = password_hash($senha, PASSWORD_ARGON2ID, [
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 1
]);

$partes = explode('$', $hash);

echo "Algoritmo: argon2id\n";
echo "Versao: v=19\n";
echo "Custo de memoria: 65536 KB\n";
echo "Custo de tempo: 4\n";
echo "Paralelismo: 1\n";

$saltBase64 = base64_encode(hex2bin($partes[3]));
echo "Salt (Base64): " . $saltBase64 . "\n";

echo "Hash final: " . $hash . "\n";