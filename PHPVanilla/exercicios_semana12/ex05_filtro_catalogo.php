<?php
declare(strict_types=1);

// Exercicio 5 - Filtro de Busca por Categoria
// Captura a categoria pela query string (?categoria=Usinagem) e exibe somente os produtos da categoria selecionada.
// Inclui um campo de selecao (select) de categoria na tela.

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Produto;

$categoria = $_GET['categoria'] ?? '';

if ($categoria !== '') {
    $produtos = Produto::buscarPorCategoria($categoria);
} else {
    $produtos = Produto::listarTodos();
}

$categorias = Produto::listarCategorias();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exercicio 5 - Filtro de Catalogo por Categoria</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; background: #f1f5f9; color: #0f172a; }
        .card { background: #ffffff; padding: 20px; border-radius: 8px; max-width: 900px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #0284c7; margin-top: 0; }
        .filtro { margin-bottom: 15px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .aviso { background: #fef3c7; color: #92400e; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; }
        label { font-weight: 600; font-size: 0.85rem; color: #334155; }
        select, input { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; }
        .btn { background: #0284c7; color: #fff; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
        th { background: #f8fafc; color: #475569; font-weight: 700; }
    </style>
</head>
<body>
<div class="card">
    <h2>Exercicio 5 - Filtro de Catalogo por Categoria</h2>

    <?php if ($categoria !== ''): ?>
        <div class="aviso">Exibindo produtos da categoria: <?= htmlspecialchars($categoria) ?></div>
    <?php endif; ?>

    <form class="filtro" method="GET" action="ex05_filtro_catalogo.php">
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria">
            <option value="">Todas as categorias</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= ($categoria === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Filtrar</button>
        <a href="ex05_filtro_catalogo.php" class="btn" style="background:#64748b;">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preco</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr><td colspan="5" style="text-align:center; color:#64748b;">Nenhum produto encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td>#<?= (int)$p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                        <td><?= htmlspecialchars($p['categoria']) ?></td>
                        <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                        <td><?= (int)$p['estoque'] ?> un</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
