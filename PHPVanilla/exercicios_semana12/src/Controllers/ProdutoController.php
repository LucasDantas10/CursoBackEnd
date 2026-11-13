<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Produto;

// Controller dos Produtos.
// Implementa os exercicios: detalhe (parametro dinamico), catalogo JSON, exclusao segura e filtro por categoria.

final class ProdutoController extends Controller {
    public function listar(): void {
        $categoria = $_GET['categoria'] ?? '';
        if ($categoria !== '') {
            $produtos = Produto::buscarPorCategoria($categoria);
        } else {
            $produtos = Produto::listarTodos();
        }
        $this->renderizar('produtos/listar', [
            'titulo'     => 'Catalogo de Produtos',
            'produtos'   => $produtos,
            'categoria'  => $categoria,
            'categorias' => Produto::listarCategorias()
        ]);
    }

    public function detalhar(int $id): void {
        $produto = Produto::buscarPorId($id);
        if ($produto === null) {
            http_response_code(404);
            $this->renderizar('produtos/detalhar', [
                'titulo'  => 'Produto nao encontrado',
                'produto' => null
            ]);
            return;
        }
        $this->renderizar('produtos/detalhar', [
            'titulo'  => 'Detalhe do Produto',
            'produto' => $produto
        ]);
    }

    public function excluir(): void {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            Produto::excluir($id);
        }
        $this->redirecionar('/produtos');
    }

    public function catalogoJson(): void {
        $produtos = Produto::listarTodos();
        $this->renderizarJson(['produtos' => $produtos], 200);
    }
}
