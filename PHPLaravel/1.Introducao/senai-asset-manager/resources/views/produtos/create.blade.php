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

        label {
            display: block;
            margin-bottom: 7px;
            color: #cbd5e1;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 20px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 6px;
            color: white;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-salvar {
            background: #0284c7;
            color: white;
        }

        .btn-voltar {
            background: #334155;
            color: white;
            margin-left: 8px;
        }

        .erro {
            color: #f87171;
            font-size: 0.8rem;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .alerta {
            background: #7f1d1d;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #fecaca;
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

        @if($errors->any())
            <div class="alerta">
                Existem erros no preenchimento do formulário.
            </div>
        @endif

        <form action="{{ route('produtos.store') }}" method="POST">

            @csrf

            <label>Nome do Produto</label>
            <input type="text" name="nome"
                   value="{{ old('nome') }}"
                   placeholder="Digite o nome do produto"
                   required>

            @error('nome')
                <div class="erro">{{ $message }}</div>
            @enderror

            <label>Fabricante</label>
            <input type="text" name="fabricante"
                   value="{{ old('fabricante') }}"
                   placeholder="Digite o fabricante"
                   required>

            @error('fabricante')
                <div class="erro">{{ $message }}</div>
            @enderror

            <label>Quantidade</label>
            <input type="number" name="quantidade"
                   value="{{ old('quantidade') }}"
                   min="0"
                   placeholder="Digite a quantidade"
                   required>

            @error('quantidade')
                <div class="erro">{{ $message }}</div>
            @enderror

            <label>Preço (R$)</label>
            <input type="number" name="preco"
                   value="{{ old('preco') }}"
                   step="0.01"
                   min="0"
                   placeholder="Ex: 150.00"
                   required>

            @error('preco')
                <div class="erro">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-salvar">
                Cadastrar Produto
            </button>

            <a href="{{ route('produtos.index') }}" class="btn btn-voltar">
                Voltar
            </a>

        </form>

    </div>
</div>

</body>
</html>
