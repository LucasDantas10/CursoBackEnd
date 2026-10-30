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
            throw new ValorInvalidoException("Valor invalido.");
        }
        $this->saldo += $valor;
    }

    abstract public function sacar(float $valor): void;
}

class ContaInvestimento extends ContaBancaria {
    private float $iof = 0.0038;
    private float $irCurtoPrazo = 0.225;

    public function __construct(string $numero, Titular $titular, float $saldoInicial = 0.0) {
        parent::__construct($numero, $titular);
        $this->saldo = $saldoInicial;
    }

    public function getTaxaAdministracao(): float {
        if ($this->saldo >= 10000.0) {
            return 0.005;
        }
        if ($this->saldo >= 5000.0) {
            return 0.01;
        }
        return 0.02;
    }

    public function sacar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor invalido.");
        }
        if ($this->saldo < $valor) {
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }
        $this->saldo -= $valor;
    }

    public function resgatar(float $valor, ContaBancaria $destino): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor de resgate invalido.");
        }
        if ($this->saldo < $valor) {
            throw new SaldoInsuficienteException("Saldo insuficiente para resgate.");
        }
        $iof = $valor * $this->iof;
        $ir = $valor * $this->irCurtoPrazo;
        $taxa = $valor * $this->getTaxaAdministracao();
        $liquido = $valor - $iof - $ir - $taxa;
        if ($liquido < 0) {
            $liquido = 0.0;
        }
        $this->saldo -= $valor;
        $destino->depositar($liquido);
        echo "Resgate de R$ {$valor} realizado.\n";
        echo "IOF: R$ {$iof} | IR: R$ {$ir} | Taxa admin: R$ {$taxa}\n";
        echo "Valor liquido creditado: R$ {$liquido}\n";
    }
}

$titular = new Titular("Lucas", "111.111.111-11");
$investimento = new ContaInvestimento("001", $titular, 20000.0);
$corrente = new class("002", $titular) extends ContaBancaria {
    public function sacar(float $valor): void {}
};
echo "Saldo investimento: R$ " . $investimento->getSaldo() . "\n";
echo "Taxa administracao: " . ($investimento->getTaxaAdministracao() * 100) . "%\n";
$investimento->resgatar(5000.0, $corrente);
echo "Saldo investimento apos resgate: R$ " . $investimento->getSaldo() . "\n";
