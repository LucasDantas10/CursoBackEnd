<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f172a;
            margin: 0;
            color: #f8fafc;
        }

        header {
            background: #1e293b;
            padding: 16px 30px;
            border-bottom: 1px solid #334155;
        }

        header h1 {
            font-size: 1.25rem;
            color: #38bdf8;
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: #1e293b;
            border-radius: 8px;
            padding: 25px;
            border: 1px solid #334155;
        }

        .produto-info {
            padding: 15px;
            background: #0f172a;
            border-radius: 6px;
            margin-bottom: 12px;
            border: 1px solid #334155;
        }

        .produto-info label {
            display: block;
            color: #94a3b8;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        .produto-info strong {
            font-size: 1rem;
            color: #f8fafc;
        }

        .badge {
            display: inline-block;
            background: #0369a1;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.85rem;
            margin-top: 15px;
        }

        .btn-editar {
            background: #0284c7;
            color: white;
        }

        .btn-voltar {
            background: #334155;
            color: white;
            margin-left: 8px;
        }
    </style>
</head>

<body>

<header>
    <h1>🏭 SENAI Client Flow — Gestão de Produtos</h1>
</header>

<div class="container">

    <div class="card">

        <h2>{{ $titulo }}</h2>

        <p style="color:#94a3b8;">
            Informações completas do produto cadastrado.
        </p>

        <div class="produto-info">
            <label>ID do Produto</label>
            <strong>#{{ $produto->id }}</strong>
        </div>

        <div class="produto-info">
            <label>Nome do Produto</label>
            <strong>{{ $produto->nome }}</strong>
        </div>

        <div class="produto-info">
            <label>Fabricante</label>
            <strong>{{ $produto->fabricante }}</strong>
        </div>

        <div class="produto-info">
            <label>Quantidade em Estoque</label>
            <span class="badge">
                {{ $produto->quantidade }} unidades
            </span>
        </div>

        <div class="produto-info">
            <label>Preço</label>
            <strong>
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </strong>
        </div>

        <div class="produto-info">
            <label>Data de Cadastro</label>
            <strong>
                {{ $produto->created_at->format('d/m/Y H:i') }}
            </strong>
        </div>

        <a href="{{ route('produtos.edit', $produto->id) }}"
           class="btn btn-editar">
            Editar Produto
        </a>

        <a href="{{ route('produtos.index') }}"
           class="btn btn-voltar">
            Voltar
        </a>

    </div>
</div>

</body>
</html>
