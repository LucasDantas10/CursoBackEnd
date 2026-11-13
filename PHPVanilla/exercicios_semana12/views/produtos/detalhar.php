<?php declare(strict_types=1); ?>
<div class="card">
    <h2><?= htmlspecialchars($titulo) ?></h2>
    <?php if ($produto === null): ?>
        <div class="nao-encontrado">
            <p>Produto nao encontrado.</p>
            <a href="/produtos" class="btn">Voltar ao Catalogo</a>
        </div>
    <?php else: ?>
        <table>
            <tr><th>ID</th><td>#<?= (int)$produto['id'] ?></td></tr>
            <tr><th>Nome</th><td><?= htmlspecialchars($produto['nome']) ?></td></tr>
            <tr><th>Categoria</th><td><?= htmlspecialchars($produto['categoria']) ?></td></tr>
            <tr><th>Preco</th><td>R$ <?= number_format((float)$produto['preco'], 2, ',', '.') ?></td></tr>
            <tr><th>Estoque</th><td><?= (int)$produto['estoque'] ?> un</td></tr>
        </table>
        <p><a href="/produtos" class="btn">Voltar ao Catalogo</a></p>
    <?php endif; ?>
</div>
