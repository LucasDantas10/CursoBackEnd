<?php
declare(strict_types=1);

class ValorInvalidoException extends \Exception {}

class Titular {
    public function __construct(
        public readonly string $nome,
        public readonly string $cpf,
    ) {}
}

abstract class ContaBancaria {
    private string $numero;
    private readonly Titular $titular;
    private float $saldo = 0.0;

    public function __construct(string $numero, Titular $titular) {
        $this->numero = $numero;
        $this->titular = $titular;
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

class ContaCorrente extends ContaBancaria {
    public function sacar(float $valor): void {}
}

$conta = new ContaCorrente("001", new Titular("Lucas", "111.111.111-11"));

$bloqueadas = [];

try {
    $conta->saldo = 999999.0;
    $bloqueadas[] = "Alteracao direta de saldo: NAO bloqueada";
} catch (\Error $e) {
    $bloqueadas[] = "Alteracao direta de saldo: bloqueada (" . $e->getMessage() . ")";
}

try {
    new ContaBancaria("002", new Titular("X", "222.222.222-22"));
    $bloqueadas[] = "Instanciacao de classe abstrata: NAO bloqueada";
} catch (\Error $e) {
    $bloqueadas[] = "Instanciacao de classe abstrata: bloqueada (" . $e->getMessage() . ")";
}

try {
    $conta->depositar(-50.0);
    $bloqueadas[] = "Deposito com valor negativo: NAO bloqueado";
} catch (ValorInvalidoException $e) {
    $bloqueadas[] = "Deposito com valor negativo: bloqueado (" . $e->getMessage() . ")";
}

echo "Relatorio de encapsulamento\n";
echo str_repeat("=", 35) . "\n";
foreach ($bloqueadas as $item) {
    echo "- {$item}\n";
}
