<?php
declare(strict_types=1);

class ValorInvalidoException extends \Exception {}
class SaldoInsuficienteException extends \Exception {}

class Transacao {
    public function __construct(
        public string $tipo,
        public float $valor,
        public string $dataHora,
        public bool $sucesso,
    ) {}
}

abstract class ContaBancaria {
    private string $numero;
    private readonly string $titular;
    protected float $saldo = 0.0;
    protected array $historico = [];

    public function __construct(string $numero, string $titular) {
        $this->numero = $numero;
        $this->titular = $titular;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getTitular(): string {
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
        $this->historico[] = new Transacao("Deposito", $valor, date("d/m/Y H:i:s"), true);
    }

    abstract public function sacar(float $valor): void;

    public function getExtrato(): array {
        return $this->historico;
    }
}

class ContaCorrente extends ContaBancaria {
    public function sacar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor invalido.");
        }
        if ($this->saldo < $valor) {
            $this->historico[] = new Transacao("Saque", $valor, date("d/m/Y H:i:s"), false);
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }
        $this->saldo -= $valor;
        $this->historico[] = new Transacao("Saque", $valor, date("d/m/Y H:i:s"), true);
    }
}

$conta = new ContaCorrente("001", "Lucas");
$conta->depositar(1000.0);
$conta->sacar(300.0);
try {
    $conta->sacar(900.0);
} catch (\Throwable $e) {
    echo "Saque negado: " . $e->getMessage() . "\n";
}

echo "Extrato da conta {$conta->getNumero()} - Titular: {$conta->getTitular()}\n";
echo str_repeat("-", 50) . "\n";
printf("%-12s | %-10s | %-16s | %-8s\n", "Tipo", "Valor", "Data/Hora", "Sucesso");
echo str_repeat("-", 50) . "\n";
foreach ($conta->getExtrato() as $transacao) {
    printf("%-12s | %-10s | %-16s | %-8s\n",
        $transacao->tipo,
        "R$ " . $transacao->valor,
        $transacao->dataHora,
        $transacao->sucesso ? "Sim" : "Nao"
    );
}
echo str_repeat("-", 50) . "\n";
printf("Saldo final: R$ %s\n", $conta->getSaldo());
