## 1. Procedural vs. OO: Quais são os três principais riscos técnicos de manter regras financeiras críticas implementadas puramente através de arrays associativos e scripts procedurais?

> Resposta: Manter regras financeiras críticas implementadas puramente através de scripts procedurais e arrays associativos expõe sistemas de missão crítica a sérios problemas de estabilidade e integridade dos dados, Ocupam memoria desnecessaria, não tem como deixar privado ou protegido as classes ou seus atributos, em uma manutenção, teria de alterar o código inteiro e ainda tem a margem do erro de "arrumar a parte errada" e também permitir que outras variavel herdem caracterirsticas dessa classe abstrata.

## 2. Ciclo de Vida do Objeto: O que ocorre na memória Heap do servidor quando a instrução new ContaCorrente(...) é executada? Qual é o papel do método __construct() nesse processo?

> Resposta:O PHP aloca espaço na memória Heap para a nova instância. O método `__construct()` é chamado imediatamente a seguir para inicializar o estado do objeto (atribuir dependências e valores iniciais), garantindo que ele nasça válido e pronto para uso.

## 3. A Pseudo-Variável $this: Explique por que o comando $this->saldo é obrigatório para acessar um atributo dentro da classe, diferenciando-o de uma variável local $saldo.

> Resposta: O $this->saldo é usado para acessar o saldo que pertence ao objeto atual. Já $saldo é uma variável local, que pode existir apenas dentro de um método. Por isso, usamos $this->saldo quando queremos acessar ou alterar o saldo guardado no próprio objeto, sem confundir com outras variáveis.

```php
class Financeiro {
    //atributo
    private float $saldo;

    //método de Acesso
    public function setSaldo(float $valor) {
        $saldo = $valor;
        $this->saldo += $saldo;
    }
}
financeiro->setSaldo(20.00)
```

## 4. Encapsulamento e Invariantes: Por que um desenvolvedor sênior de back-end nunca deve criar um método public function setSaldo(float $novoSaldo) para uma conta bancária?

> Resposta: Porque esse método permitiria que qualquer pessoa com acesso a ele alterasse o saldo diretamente, sem verificar se a operação é válida. Isso poderia causar erros, como adicionar dinheiro sem fazer um depósito real. O ideal é usar métodos como sacar() e depositar(), que verificam as regras antes de modificar o saldo e ajudam a manter a conta correta.

## 5. Modificadores de Acesso: Qual é a diferença prática entre os modificadores private e protected quando subclasses entram em cena através do extends?

> Resposta: O private permite acessar um atributo ou método somente dentro da própria classe. Já o protected também permite o acesso dentro das classes filhas que herdam características da classe principal usando extends. Assim, o protected permite compartilhar algumas informações com as classes filhas, enquanto o private mantém essas informações mais restritas.

## 6. Constructor Property Promotion: Como o recurso de promoção de propriedades introduzido no PHP 8 reduz o boilerplate e melhora a legibilidade do código?

> Resposta: Esse recurso do PHP 8 permite declarar os atributos diretamente nos parâmetros do construtor, sem precisar escrever várias linhas para criar os atributos e guardar seus valores. Isso diminui o código repetitivo, deixa a classe menor e facilita a leitura e a manutenção do programa.

## 7. Propriedades readonly: Explique o mecanismo de segurança proporcionado pela palavra-chave readonly em atributos de classes de valor como Titular ou CPF.

> Resposta: A palavra-chave readonly impede que o valor de uma propriedade seja alterado depois de ser definido e inicializado. Isso ajuda a proteger informações importantes, como o CPF de um titular, contra mudanças acidentais. Dessa forma, o programa mantém esses dados mais seguros, embora ainda seja necessário verificar se as informações recebidas são válidas.

## 8. Classes Abstratas: Por que faz todo sentido no modelo bancário que a classe ContaBancaria seja declarada como abstract enquanto ContaCorrente e ContaPoupanca são classes concretas?

> Resposta:  A classe ContaBancaria é abstrata porque serve como um modelo geral para os diferentes tipos de conta e reúne características comuns, como saldo e operações bancárias. Já ContaCorrente e ContaPoupanca são classes concretas porque representam tipos específicos de conta e podem ser usadas para criar objetos. Assim, evitamos repetir código e organizamos melhor as regras do sistema.

## 9. Polimorfismo: Como o método transferir(float $valor, ContaBancaria $destino) consegue operar transferências entre quaisquer tipos de contas filhas sem precisar saber qual é a classe exata da conta de destino?

> Resposta: Isso é possível porque ContaCorrente e ContaPoupanca herdam da classe ContaBancaria. Dessa forma, o método transferir() pode receber qualquer uma dessas contas pelo parâmetro $destino, sem precisar saber qual é o tipo exato. Isso facilita a reutilização do código e evita a necessidade de criar um método diferente para cada tipo de conta, desde que as regras necessárias para a transferência sejam respeitadas.

## 10. Exceções de Domínio: Por que é uma péssima prática retornar false ou null quando uma operação de saque é rejeitada por falta de saldo?

> Resposta: Retornar false ou null pode dificultar a identificação do motivo pelo qual o saque não foi realizado. Usar uma exceção permite informar claramente o problema, como saldo insuficiente, e facilita o tratamento desse erro pelo sistema. Assim, o programa consegue avisar o usuário sobre o que aconteceu e evitar que a falha passe despercebida.
