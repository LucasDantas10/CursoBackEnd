# Atividade da Semana 12 - MVC com PHP Vanilla

Projeto acadêmico desenvolvido para a disciplina de Back-end, aplicando arquitetura MVC artesanal com PHP, Composer, PDO e PostgreSQL.

## 1. Estrutura de Diretórios

```text
exercicios_semana12/
├── composer.json               <- Autoload PSR-4 ("App\": "src/")
├── README.md                   <- Este arquivo
├── schema.sql                  <- Script DDL e dados iniciais (PostgreSQL)
├── .gitignore                  <- config/, vendor/, logs/
├── public/
│   └── index.php               <- Front Controller (ponto unico de entrada)
├── config/
│   └── database.ini            <- Credenciais do Banco de Dados
├── logs/
│   └── acessos.log             <- Gerado automaticamente pelo registro de acessos
├── src/
│   ├── Core/
│   │   ├── ConexaoBanco.php    <- Singleton de conexao PDO
│   │   ├── Controller.php      <- Classe base abstrata (renderizar, redirecionar, renderizarJson)
│   │   └── Roteador.php        <- Roteador HTTP com suporte a parametro dinamico e log de acesso
│   ├── Controllers/
│   │   └── ProdutoController.php  <- Detalhe, catalogo JSON, exclusao, listagem com filtro
│   └── Models/
│       └── Produto.php         <- Consultas SQL (Prepared Statements)
└── views/
    ├── layout/
    │   ├── header.php
    │   └── footer.php
    └── produtos/
        ├── listar.php          <- Tabela com filtro por categoria e botoes Excluir
        └── detalhar.php        <- Tela de detalhe do produto (ou 404)
```

## 2. Como Executar

1. Crie o banco de dados no PostgreSQL executando o script `schema.sql`.
2. Ajuste, se necessario, as credenciais em `config/database.ini`.
3. Instale o autoload do Composer:

```bash
composer dump-autoload
```

4. Inicie o servidor PHP apontando para a pasta `public`:

```bash
php -S localhost:8000 -t public
```

5. Acesse no navegador: `http://localhost:8000/`

> Obs.: As rotas que consultam o banco de dados exigem que o PostgreSQL esteja em execucao e o banco `semana12` criado.

## 3. Parte A - Questoes Teoricas

### Colapso do codigo espaguete
Misturar SQL, validacao e HTML em um mesmo arquivo cria codigo dificil de ler, testar e manter. Qualquer mudança no banco de dados força a alteração da camada de apresentacao, e erros de seguranca (SQL injection e XSS) se espalham por todo o script. Separar responsabilidades evita esse colapso.

### Tríade MVC
- **Model**: encapsula as regras de negocio e as consultas ao banco de dados. So ele fala com o banco.
- **View**: responsavel apenas por exibir os dados ao usuario (HTML). Nao contem consulta SQL.
- **Controller**: recebe a requisicao, chama o Model e escolhe qual View renderizar. Faz a ligacao entre os dois.

### Composer
O Composer é o gerenciador de dependencias do PHP. O `composer.json` declara as dependencias e o mapeamento de autoload. O `composer.lock` registra as versoes exatas instaladas para garantir reproduzibilidade. A pasta `vendor/` contem as bibliotecas instaladas e o `autoload.php`.

### PSR-4 e Autoload
A PSR-4 é uma padronização que mapeia namespaces para pastas de arquivos. Com `"App\": "src/"`, a classe `App\Models\Produto` e carregada automaticamente a partir de `src/Models/Produto.php`, eliminando a necessidade de `require_once` entre classes.

### Front Controller e seguranca
O `public/index.php` é o ponto unico de entrada da aplicacao. Como fica dentro de `public/`, somente este arquivo e os assets ficam expostos ao navegador; codigo fonte, configuracoes e modelos ficam fora da raiz publica, reduzindo a superfície de ataque.

### Roteador GET vs POST
O roteador armazena as rotas separadas por metodo HTTP. Ao despachar, compara o metodo da requisicao (`$_SERVER['REQUEST_METHOD']`) com o metodo registrado para a URI, permitindo que a mesma URI tenha comportamentos distintos para GET e POST.

### extract() nas Views
O `extract()` transforma cada chave do array de dados em uma variavel local na view. Assim, o controller passa `['produtos' => $lista]` e a view pode usar diretamente `$produtos`.

### Protecao contra XSS
A funcao `htmlspecialchars()` converte caracteres especiais (`<`, `>`, `"`, `'`, `&`) em entidades HTML, impedindo que scripts maliciosos injetados pelo usuario sejam executados no navegador. E usada em todas as saidas dinamicas das views.

### Single Responsibility nos Controllers
Cada controller deve ter um unico motivo para mudar. No `ProdutoController`, cada metodo trata apenas uma acao (listar, detalhar, excluir, catalogo JSON), sem misturar responsabilidades de outras entidades.

### MVC artesanal x Laravel 11
O MVC artesanal construído aqui e o Laravel 11 compartilham a mesma ideia de separar Model, View e Controller e usar um Front Controller. O Laravel e um framework maduro que ja traz roteador, ORM, middleware, autenticacao e muito mais prontos; nossa versao e uma implementacao minima e didatica dos mesmos conceitos.

## 4. Parte B - Exercicios Praticos

| Exercicio | Arquivo/Classe | Rota | O que faz |
|-----------|----------------|------|-----------|
| 1 - Rota com parametro dinamico | `ProdutoController::detalhar(int $id)` | `GET /produtos/{id}` | Busca o produto pelo ID. Se nao existir, retorna HTTP 404. |
| 2 - Resposta JSON API RESTful | `Controller::renderizarJson()` + `ProdutoController::catalogoJson()` | `GET /api/produtos` | Retorna o catalogo de produtos em JSON com `Content-Type: application/json`. |
| 3 - Middleware de log de acessos | `Roteador::registrarLog()` | Todas as rotas | Antes de despachar, grava em `logs/acessos.log`: data, hora, IP, metodo e URI. |
| 4 - Exclusao segura | `Produto::excluir(int $id)` + `ProdutoController::excluir()` | `POST /produtos/excluir` | Recebe o ID via `$_POST`, exclui com Prepared Statement. Botao Excluir em cada linha com `confirm()` do JavaScript. |
| 5 - Filtro de busca por categoria | `Produto::buscarPorCategoria(string $categoria)` | `GET /produtos?categoria=Usinagem` | Captura a categoria pela query string, passa ao Model e exibe apenas os produtos da categoria. Tela possui campo de selecao de categoria. |

## 5. Checklist de Qualidade

- [x] `composer.json` com autoload PSR-4 para `"App\": "src/"`
- [x] `composer dump-autoload` executado
- [x] Classes utilizando namespaces `App\....`
- [x] Autoload funcionando sem `require_once` manual entre classes
- [x] Entrada centralizada em `public/index.php`
- [x] Servidor executado com `php -S -t public`
- [x] Consultas SQL exclusivamente nos Models
- [x] Prepared Statements em todas as consultas com parametros
- [x] Credenciais em `config/database.ini`
- [x] Views utilizando `htmlspecialchars()` nas saidas dinamicas
- [x] Metodos com no maximo 20 linhas
- [x] Todos os arquivos PHP iniciando com `declare(strict_types=1);`
- [x] Comentarios em portugues brasileiro

## 6. Observacoes sobre Testes

O funcionamento completo das rotas que acessam o banco de dados (`/`, `/produtos`, `/produtos/{id}`, `/api/produtos`, `/produtos/excluir`) depende de um servidor PostgreSQL em execucao com o banco `semana12` criado via `schema.sql`. Os testes de sintaxe PHP, autoload PSR-4 e roteador (rota nao encontrada) foram verificados com sucesso neste ambiente.
