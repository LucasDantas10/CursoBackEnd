<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Listar produtos
    public function index()
    {
        $produtos = Produto::all();

        return view('produtos.index', [
            'produtos' => $produtos,
            'titulo' => 'Gestão de Produtos'
        ]);
    }

    // Abrir formulário de cadastro
    public function create()
    {
        return view('produtos.create', [
            'titulo' => 'Cadastrar Produto'
        ]);
    }

    // Salvar produto
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0'
        ]);

        Produto::create($dados);

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    // Exibir detalhes do produto
    public function show(Produto $produto)
    {
        return view('produtos.show', [
            'produto' => $produto,
            'titulo' => 'Detalhes do Produto'
        ]);
    }

    // Abrir formulário de edição
    public function edit(Produto $produto)
    {
        return view('produtos.edit', [
            'produto' => $produto,
            'titulo' => 'Editar Produto'
        ]);
    }

    // Atualizar produto
    public function update(Request $request, Produto $produto)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0'
        ]);

        $produto->update($dados);

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    // Excluir produto
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('sucesso', 'Produto excluído com sucesso!');
    }

    // Filtrar produtos por estoque
    public function estoque($tipo)
    {
        if (!in_array($tipo, ['baixo', 'normal'])) {
            abort(404);
        }

        if ($tipo === 'baixo') {
            $produtos = Produto::where('quantidade', '<=', 5)->get();
        } else {
            $produtos = Produto::where('quantidade', '>', 5)->get();
        }

        return view('produtos.index', [
            'produtos' => $produtos,
            'titulo' => $tipo === 'baixo'
                ? 'Produtos com Estoque Baixo'
                : 'Produtos com Estoque Normal'
        ]);
    }
}
