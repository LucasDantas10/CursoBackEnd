<?php
declare(strict_types=1);

const DB_HOST = '127.0.0.1';
const DB_PORT = '5432';
const DB_NAME = 'semana09';
const DB_USER = 'postgres';
const DB_PASS = 'postgres';

function conectar(): PDO
{
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', DB_HOST, DB_PORT, DB_NAME);

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function mostrarResultado(string $titulo, array $linhas): void
{
    echo $titulo, PHP_EOL;
    echo 'Registros retornados: ', count($linhas), PHP_EOL;

    foreach ($linhas as $linha) {
        printf('  id=%d | usuario=%s | senha=%s | nivel=%s%s', $linha['id'], $linha['usuario'], $linha['senha'], $linha['nivel'], PHP_EOL);
    }
}

function buscarVulneravel(string $termo): void
{
    $pdo = conectar();
    $sql = "SELECT id, usuario, senha, nivel FROM laboratorio_sqli WHERE usuario = '$termo' ORDER BY id";
    echo PHP_EOL, '--- ABORDAGEM VULNERAVEL (concatenacao) ---', PHP_EOL;
    echo 'SQL executado: ', $sql, PHP_EOL;

    try {
        $stmt = $pdo->query($sql);
        mostrarResultado('Resultado da consulta vulneravel:', $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $erro) {
        echo 'Consulta vulneravel falhou: ', $erro->getMessage(), PHP_EOL;
    }
}

function buscarProtegido(string $termo): void
{
    $pdo = conectar();
    $sql = 'SELECT id, usuario, senha, nivel FROM laboratorio_sqli WHERE usuario = :usuario ORDER BY id';
    echo PHP_EOL, '--- ABORDAGEM PROTEGIDA (prepare + parametro nomeado) ---', PHP_EOL;
    echo 'SQL executado: ', $sql, PHP_EOL;
    echo 'Valor vinculado em :usuario => ', $termo, PHP_EOL;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $termo]);

    try {
        mostrarResultado('Resultado da consulta protegida:', $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $erro) {
        echo 'Consulta protegida falhou: ', $erro->getMessage(), PHP_EOL;
    }
}

function main(): void
{
    $termo = "' OR '1'='1";
    echo 'Laboratorio forense de SQL Injection', PHP_EOL;
    echo 'Termo injetado utilizado: ', $termo, PHP_EOL;
    echo 'Tabela isolada laboratorio_sqli: 4 registros ficticios.', PHP_EOL;

    buscarVulneravel($termo);
    buscarProtegido($termo);

    echo PHP_EOL, 'CONCLUSAO: a concatenacao permite listar todos os registros da tabela;', PHP_EOL;
    echo 'o prepared statement trata o termo como texto e nao devolve registros.', PHP_EOL;
}

main();
