<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'Sistema') ?></title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f1f5f9; padding: 20px; color: #0f172a; margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; }
        .card { background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; }
        h1, h2 { color: #0284c7; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; }
        th { background: #f8fafc; color: #475569; font-weight: 700; }
        .btn { background: #0284c7; color: #ffffff; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0369a1; }
        .btn-excluir { background: #e11d48; }
        .btn-excluir:hover { background: #be123c; }
        .btn-detalhar { background: #059669; font-size: 0.8rem; padding: 6px 10px; }
        .filtro { margin-bottom: 15px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .aviso { background: #fef3c7; color: #92400e; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; }
        .nao-encontrado { text-align: center; padding: 40px; color: #64748b; }
        label { font-weight: 600; font-size: 0.85rem; color: #334155; }
        select, input { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="container">
