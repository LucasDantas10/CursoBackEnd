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

function lerOpcao(): string
{
    $entrada = fgets(STDIN);

    return $entrada === false ? '' : trim($entrada);
}

function exibirMenu(): void
{
    echo PHP_EOL, '=== Gerenciador de Ferramentas ===', PHP_EOL;
    echo '1 - Cadastrar nova ferramenta', PHP_EOL;
    echo '2 - Listar ferramentas ativas', PHP_EOL;
    echo '3 - Sair', PHP_EOL;
    echo 'Opcao: ';
}

function coletarDadosFerramenta(): array
{
    echo 'Nome: ';
    $nome = lerOpcao();
    echo 'Categoria: ';
    $categoria = lerOpcao();
    echo 'Quantidade: ';
    $quantidade = (int) lerOpcao();
    echo 'Preco unitario: ';
    $preco = (float) str_replace(',', '.', lerOpcao());

    return [$nome, $categoria, $quantidade, $preco];
}

function dadosValidos(array $dados): bool
{
    [$nome, $categoria] = $dados;

    return $nome !== '' && $categoria !== '';
}

function cadastrarFerramenta(PDO $pdo, array $dados): void
{
    [$nome, $categoria, $quantidade, $preco] = $dados;

    if (!dadosValidos($dados)) {
        echo 'Nome e categoria sao obrigatorios.', PHP_EOL;

        return;
    }

    $sql = 'INSERT INTO ferramentas (nome, categoria, quantidade, preco_unitario)
            VALUES (:nome, :categoria, :quantidade, :preco)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':categoria' => $categoria,
        ':quantidade' => $quantidade,
        ':preco' => $preco
    ]);

    echo 'Ferramenta cadastrada com sucesso. ID: ', $pdo->lastInsertId(), PHP_EOL;
}

function listarFerramentasAtivas(PDO $pdo): void
{
    $sql = 'SELECT id, nome, categoria, quantidade, preco_unitario
            FROM ferramentas
            WHERE ativo = TRUE
            ORDER BY nome ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ferramentas === []) {
        echo 'Nenhuma ferramenta ativa cadastrada.', PHP_EOL;

        return;
    }

    foreach ($ferramentas as $ferramenta) {
        printf(
            '#%d | %s | %s | qtd: %d | R$ %s%s',
            $ferramenta['id'],
            $ferramenta['nome'],
            $ferramenta['categoria'],
            $ferramenta['quantidade'],
            $ferramenta['preco_unitario'],
            PHP_EOL
        );
    }
}

function main(): void
{
    if (PHP_SAPI !== 'cli') {
        echo 'Este exercicio deve ser executado pela linha de comando.';

        return;
    }

    $pdo = iniciarAplicacao();

    if ($pdo instanceof PDO) {
        executarLoop($pdo);
    }
}

function iniciarAplicacao(): ?PDO
{
    try {
        $pdo = conectar();
        echo 'Conexao com o banco de dados estabelecida.', PHP_EOL;

        return $pdo;
    } catch (PDOException $erro) {
        echo 'Falha na conexao: ', $erro->getMessage(), PHP_EOL;

        return null;
    }
}

function executarLoop(PDO $pdo): void
{
    while (true) {
        exibirMenu();
        $opcao = lerOpcao();

        if ($opcao === '3') {
            echo 'Encerrando o programa.', PHP_EOL;

            break;
        }

        executarOpcao($pdo, $opcao);
    }
}

function executarOpcao(PDO $pdo, string $opcao): void
{
    try {
        match ($opcao) {
            '1' => cadastrarFerramenta($pdo, coletarDadosFerramenta()),
            '2' => listarFerramentasAtivas($pdo),
            default => opcaoInvalida()
        };
    } catch (PDOException $erro) {
        echo 'Erro ao executar a operacao: ', $erro->getMessage(), PHP_EOL;
    }
}

function opcaoInvalida(): void
{
    echo 'Opcao invalida.', PHP_EOL;
}

main();
