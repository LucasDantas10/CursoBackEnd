<?php
declare(strict_types=1);

class ValorInvalidoException extends \Exception {}
class SaldoInsuficienteException extends \Exception {}

class Titular {
    public function __construct(
        public readonly string $nome,
        public readonly string $email,
        public readonly string $telefone,
    ) {}
}

interface NotificadorInterface {
    public function notificar(Titular $titular, string $mensagem): bool;
}

class NotificadorEmail implements NotificadorInterface {
    public function notificar(Titular $titular, string $mensagem): bool {
        echo "Email para {$titular->nome}: {$mensagem}\n";
        return true;
    }
}

class NotificadorSMS implements NotificadorInterface {
    public function notificar(Titular $titular, string $mensagem): bool {
        echo "SMS para {$titular->telefone}: {$mensagem}\n";
        return true;
    }
}

class NotificadorWhatsApp implements NotificadorInterface {
    public function notificar(Titular $titular, string $mensagem): bool {
        echo "WhatsApp para {$titular->telefone}: {$mensagem}\n";
        return true;
    }
}

abstract class ContaBancaria {
    private string $numero;
    private readonly Titular $titular;
    protected float $saldo = 0.0;
    private array $notificadores = [];

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

    public function adicionarNotificador(NotificadorInterface $notificador): void {
        $this->notificadores[] = $notificador;
    }

    protected function notificarTodos(string $mensagem): void {
        foreach ($this->notificadores as $notificador) {
            $notificador->notificar($this->titular, $mensagem);
        }
    }

    public function depositar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor invalido.");
        }
        $this->saldo += $valor;
        $this->notificarTodos("Deposito de R$ {$valor} realizado.");
    }

    abstract public function sacar(float $valor): void;
}

class ContaCorrente extends ContaBancaria {
    public function sacar(float $valor): void {
        if ($valor <= 0) {
            throw new ValorInvalidoException("Valor invalido.");
        }
        if ($this->saldo < $valor) {
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }
        $this->saldo -= $valor;
        $this->notificarTodos("Saque de R$ {$valor} realizado.");
    }
}

$titular = new Titular("Lucas", "lucas@email.com", "11999999999");
$conta = new ContaCorrente("001", $titular);
$conta->adicionarNotificador(new NotificadorEmail());
$conta->adicionarNotificador(new NotificadorSMS());
$conta->adicionarNotificador(new NotificadorWhatsApp());
$conta->depositar(500.0);
$conta->sacar(100.0);
echo "Saldo final: R$ " . $conta->getSaldo() . "\n";
