<?php
declare(strict_types=1);

class ValorInvalidoException extends \Exception {}
class SaldoInsuficienteException extends \Exception {}

class Titular {
    public function __construct(
        public readonly string $nome,
        public readonly string $cpf,
    ) {}
}

abstract class ContaBancaria {
    private string $numero;
    private readonly Titular $titular;
    protected float $saldo = 0.0;

    public function __construct(string $numero, Titular $titular) {
        $this->numero = $numero;
        $this->titular = $titular;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getTitular(): Titular {
        return $this->titular;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function depositar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor de deposito invalido.");
        }
        $this->saldo += $valor;
    }

    abstract public function sacar(float $valor): void;
}

class ContaSalario extends ContaBancaria {
    public readonly string $cnpjEmpregador;
    private int $saquesMes = 0;

    public function __construct(string $numero, Titular $titular, string $cnpjEmpregador) {
        parent::__construct($numero, $titular);
        $this->cnpjEmpregador = $cnpjEmpregador;
    }

    public function depositarPorEmpregador(float $valor, string $cnpjEmpregador): void {
        if ($cnpjEmpregador !== $this->cnpjEmpregador) {
            throw new ValorInvalidoException("Deposito so permitido pelo empregador.");
        }
        parent::depositar($valor);
    }

    public function sacar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor de saque invalido.");
        }
        $custo = $valor;
        if ($this->saquesMes >= 2) {
            $custo += 4.0;
        }
        if ($this->saldo < $custo) {
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }
        $this->saldo -= $custo;
        $this->saquesMes++;
    }

    public function transferir(float $valor, ContaBancaria $destino): void {
        if ($destino->getTitular()->cpf !== $this->getTitular()->cpf) {
            throw new ValorInvalidoException("Transferencia so para o mesmo titular.");
        }
        $this->sacar($valor);
        $destino->depositar($valor);
    }
}

$titular = new Titular("Lucas", "111.111.111-11");
$conta = new ContaSalario("001", $titular, "12.345.678/0001-90");
$conta->depositarPorEmpregador(1000.0, "12.345.678/0001-90");
echo "Saldo apos deposito: R$ " . $conta->getSaldo() . "\n";
$conta->sacar(100.0);
echo "Saldo apos 1o saque: R$ " . $conta->getSaldo() . "\n";
$conta->sacar(100.0);
echo "Saldo apos 2o saque: R$ " . $conta->getSaldo() . "\n";
$conta->sacar(100.0);
echo "Saldo apos 3o saque (com taxa): R$ " . $conta->getSaldo() . "\n";

$outra = new Titular("Maria", "222.222.222-22");
$contaMaria = new ContaSalario("002", $outra, "12.345.678/0001-90");
try {
    $conta->transferir(50.0, $contaMaria);
} catch (\Throwable $e) {
    echo "Transferencia bloqueada: " . $e->getMessage() . "\n";
}
