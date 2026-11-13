<?php
declare(strict_types=1);

// Exercicio 4 - Operacao de Exclusao Segura
// Recebe o ID via $_POST, exclui o produto com Prepared Statement.
// Exibe uma tabela com botao Excluir em cada linha usando confirm() do JavaScript.

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Produto;

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $sucesso = Produto::excluir($id);
        $mensagem = $sucesso ? 'Produto excluido com sucesso.' : 'Falha ao excluir o produto.';
    } else {
        $mensagem = 'ID invalido.';
    }
}

$produtos = Produto::listarTodos();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exercicio 4 - Exclusao Segura de Produto</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; background: #f1f5f9; color: #0f172a; }
        .card { background: #ffffff; padding: 20px; border-radius: 8px; max-width: 900px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #0284c7; margin-top: 0; }
        .aviso { background: #fef3c7; color: #92400e; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
        th { background: #f8fafc; color: #475569; font-weight: 700; }
        .btn-excluir { background: #e11d48; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; }
        .btn-excluir:hover { background: #be123c; }
        .btn { background: #0284c7; color: #fff; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Exercicio 4 - Exclusao Segura de Produto</h2>
    <?php if ($mensagem !== ''): ?>
        <div class="aviso"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preco</th>
                <th>Estoque</th>
                <th style="text-align:center;">Acao</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr><td colspan="6" style="text-align:center; color:#64748b;">Nenhum produto encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td>#<?= (int)$p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                        <td><?= htmlspecialchars($p['categoria']) ?></td>
                        <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                        <td><?= (int)$p['estoque'] ?> un</td>
                        <td style="text-align:center;">
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                <button type="submit" class="btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="ex05_filtro_catalogo.php" class="btn">Voltar ao Catalogo com Filtro</a></p>
</div>
</body>
</html>
