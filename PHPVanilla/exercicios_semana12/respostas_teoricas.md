# Respostas - Questoes Teoricas (Parte A)

Respostas simples e diretas sobre os conceitos da Semana 12 (MVC com PHP Vanilla).

---

## 1. O colapso do codigo espaguete e os problemas de misturar SQL, validacao e HTML

Codigo espaguete e um script unico e longo onde tudo esta misturado: consulta ao banco de dados (SQL), regras de validacao e a saida em HTML. Isso gera varios problemas:

- Dificil de ler e manter: qualquer alteracao no banco força mudar tambem o HTML.
- Dificil de testar: nao e possivel testar a validacao isoladamente do layout.
- Inseguro: SQL injection e XSS se espalham por todo o arquivo porque nao ha camada de protecao centralizada.
- Codigo duplicado: a mesma consulta SQL pode aparecer em varios lugares.

Separar as responsabilidades evita esse colapso.

---

## 2. A tríade MVC e a responsabilidade de Model, View e Controller

MVC divide a aplicacao em tres camadas com responsabilidades unicas:

- **Model**: cuida dos dados e das regras de negocio. E a unica camada que fala com o banco de dados (consultas SQL, Prepared Statements).
- **View**: responsavel apenas por exibir informacoes ao usuario (HTML). Nao contem consulta SQL nem regras de negocio complexas.
- **Controller**: recebe a requisicao do usuario, chama o Model quando necessario e decide qual View renderizar. Faz a ligacao entre Model e View.

---

## 3. O papel do Composer, diferenca entre composer.json e composer.lock e a pasta vendor/

- **Composer**: gerenciador de dependencias do PHP. Instala bibliotecas e gerencia o autoload das classes.
- **composer.json**: arquivo onde voce declara as dependencias do projeto e o mapeamento de autoload (ex: PSR-4).
- **composer.lock**: registra as versoes exatas de todas as bibliotecas instaladas, garantindo que qualquer pessoa que instale o projeto obtenha as mesmas versoes.
- **vendor/**: pasta onde o Composer baixa as dependencias e gera o arquivo `autoload.php`, que carrega as classes automaticamente.

---

## 4. A especificacao PSR-4 e o funcionamento do autoload

A PSR-4 e um padrao que mapeia namespaces PHP para pastas de arquivos. No `composer.json`, configuramos:

```json
"autoload": {
    "psr-4": {
        "App\\": "src/"
    }
}
```

Isso significa que a classe `App\Models\Produto` e carregada automaticamente a partir do arquivo `src/Models/Produto.php`. Com o `vendor/autoload.php` incluido, nao e necessario usar `require_once` entre as classes da aplicacao; o Composer carrega a classe quando ela e instanciada pela primeira vez.

---

## 5. O Front Controller e a seguranca do public/index.php

O **Front Controller** e o ponto unico de entrada de toda a aplicacao. No nosso projeto, esse arquivo e `public/index.php`. Todas as requisicoes HTTP passam por ele, que inicializa o autoload e despacha a rota para o Controller correspondente.

Seguranca: como `index.php` fica dentro da pasta `public/`, somente esse arquivo e os arquivos estaticos ficam expostos ao navegador. O codigo fonte, modelos, controllers e configuracoes ficam fora da raiz publica (em `src/` e `config/`), impedindo acesso direto por navegador e reduzindo a superficie de ataque.

---

## 6. Como o roteador diferencia requisições GET e POST

O roteador armazena as rotas organizadas pelo metodo HTTP. Ao registrar uma rota, informamos se ela e `GET` ou `POST`. Ao despachar, o roteador pega o metodo da requisicao (`$_SERVER['REQUEST_METHOD']`) e compara com o metodo registrado para aquela URI. Assim, a mesma URI pode ter comportamentos diferentes dependendo se a requisicao e GET (consulta) ou POST (envio de formulario/escrita).

---

## 7. O funcionamento de extract() na passagem de dados para as Views

A funcao `extract()` transforma cada chave de um array associativo em uma variavel local no escopo atual. No Controller, chamamos:

```php
$this->renderizar('produtos/listar', ['produtos' => $lista, 'titulo' => 'Catalogo']);
```

Dentro de `renderizar`, o `extract($dados)` cria automaticamente as variaveis `$produtos` e `$titulo` disponiveis na view. Assim, a view pode usar essas variaveis diretamente no HTML sem precisar acessar um array.

---

## 8. A protecao contra XSS utilizando htmlspecialchars()

XSS (Cross-Site Scripting) acontece quando um script malicioso injetado pelo usuario e executado no navegador de outras pessoas. A funcao `htmlspecialchars()` converte caracteres especiais HTML (`<`, `>`, `"`, `'`, `&`) em entidades (`&lt;`, `&gt;`, `&quot;`, etc.), impedindo que o navegador interprete o texto como codigo HTML ou JavaScript.

Usamos `htmlspecialchars()` em todas as saidas dinamicas das Views (nomes, categorias, mensagens, etc.) para exibir o conteúdo do usuario com seguranca.

---

## 9. O princípio Single Responsibility nos Controllers

O Single Responsibility Principle (SRP) diz que uma classe ou metodo deve ter unica e unica responsabilidade — ou seja, so um motivo para mudar.

Nos Controllers, isso significa que cada metodo deve tratar apenas uma acao especifica. No `ProdutoController`, por exemplo, `detalhar()` so busca e exibe um produto, `excluir()` so remove um produto, e `catalogoJson()` so retorna JSON. Nao misturamos regras de negocio, validacao de banco e saida HTML no mesmo metodo. Isso torna o codigo mais facil de entender, testar e manter.

---

## 10. A relação entre o MVC artesanal e o Laravel 11

O MVC artesanal construído nesta atividade e o Laravel 11 compartilham a mesma ideia base: separar a aplicacao em Model, View e Controller, com um ponto unico de entrada (Front Controller) e roteamento de requisições.

Diferencas:
- O Laravel e um framework completo e maduro que ja traz roteador avançado, ORM (Eloquent), middleware, autenticacao, migrações e muito mais prontos para uso.
- O MVC artesanal e uma implementacao minima e didatica desses mesmos conceitos, feita com PHP Vanilla, sem dependencias externas, para aprender como a arquitetura funciona por baixo dos panos.

Em resumo: o Laravel 11 e uma versao profissional e evoluída do mesmo modelo MVC que aplicamos aqui de forma artesanal.
