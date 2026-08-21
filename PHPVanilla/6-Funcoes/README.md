# LISTA DE EXERCÍCIOS: FUNÇÕES EM PHP

### 1- Conceito de função: Explique com suas palavras o que é uma função e cite duas vantagens de dividir um programa em funções.

> Resposta: Uma função é um lugar em que você armazena seu código para realizar uma tarefa. Uma vantagem é que você quando quiser, você pode chamar essa função novamente e não precisará reescrever o código novamente. Outra vantagem é a organização do código.

---

### 2- Princípio DRY: Por que repetir o mesmo bloco de código em várias partes do sistema pode causar problemas de manutenção? Como uma função ajuda a evitar essa repetição?

> Resposta: Porque você pode acabar cometendo erros, pois terá que reescrever em vários lugares. Uma função ajuda a resolver isso, porque ela armazena seu código para determinada tarefa. Assim você só chama a função novamente e não precisa reescrever o código.

---

### 3- Parâmetros e retorno: Explique a diferença entre um parâmetro e um valor retornado por uma função. Use a função abaixo como exemplo:

> Resposta: Os parâmetros são os valores inseridos em uma função para ela realizar uma determinada tarefa. O valor retornado pela função é oque a função devolve depois de executar o código.

**Ex:**
```php
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}
```

O $preco e $quantidade são as variáveis usadas para fazer a conta. São os parâmetros da função

O return $preco * $quantidade, calcula o resultado e retorna.

---

### 4- Tipagem: Identifique o tipo de cada elemento na declaração
 `function cadastrar(string $nome, int $idade): bool.`

 > Resposta: `String` → Tipo do parâmetro $nome (texto).
 > `int` → Tipo do parâmetro $idade (número inteiro).
 > `$nome` → Nome do primeiro parâmetro.
 > `$idade` → Nome do segundo parâmetro.
 > `bool` → Tipo do retorno da função (bool: true or false). 

---

### 5- void e return: Qual é a diferença entre uma função que retorna string e uma função que retorna void? Dê um exemplo de uso para cada uma.

> Resposta: `void` é uma função que faz um trabalho interno, mas não retorna nada. É usada para apenas salvar em um arquivo de texto e não retornar nenhuma variável.
> `return` é uma função que retorna um valor.

> A diferença é que uma função não retorna nada (void) e a outra retorna (string), que pode ser armazenada em uma variável ou ser utilizada depois em outra parte do código.

Exemplo de string:
```php
function saudacao(string $nome): string {
    return "Olá, " . $nome;
}

$mensagem = saudacao("João");
```

Exemplo de void:

```php
function registroLog(string $mensagem): void{
    
    file_put_contents("erro.log", $mensagem);
}
```

---

### 6- Escopo: Por que a função abaixo não consegue acessar $cliente diretamente? Explique duas formas de corrigir o código e indique qual é a mais recomendada.


```php
$cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}

```

> Resposta: A função exibirCliente() não consegue acessar $cliente diretamente, pois a função não conhece a variável global $cliente.

1° Forma de corrigir:

```php
$cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}
// Cliente é passado para a função como parâmetro.
echo exibirCliente($cliente);
```

2° Forma de corrigir:

```php
function exibirCliente(): string {
    $cliente = "Mariana";
    return $cliente;
}

echo exibirCliente();
//$cliente existe dentro do escopo da função, então ela consegue acessar ele.

```

---

### 7- Referência: O que muda quando um parâmetro é declarado como float &$valor? Explique a diferença entre alterar uma cópia e alterar a variável original.
