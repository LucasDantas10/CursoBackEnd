<?php declare(strict_types=1); ?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h2><?= htmlspecialchars($titulo) ?></h2>
        <a href="/produtos" class="btn">Limpar Filtro</a>
    </div>

    <?php if (!empty($categoria)): ?>
        <div class="aviso">Exibindo produtos da categoria: <?= htmlspecialchars($categoria) ?></div>
    <?php endif; ?>

    <form class="filtro" method="GET" action="/produtos">
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria">
            <option value="">Todas as categorias</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= ($categoria === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preco</th>
                <th>Estoque</th>
                <th style="text-align:center;">Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:#64748b;">Nenhum produto encontrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td>#<?= (int)$p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                        <td><?= htmlspecialchars($p['categoria']) ?></td>
                        <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                        <td><?= (int)$p['estoque'] ?> un</td>
                        <td style="text-align:center;">
                            <a href="/produtos/<?= (int)$p['id'] ?>" class="btn btn-detalhar">Detalhar</a>
                            <form action="/produtos/excluir" method="POST" style="display:inline;"
                                 onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                <button type="submit" class="btn btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
