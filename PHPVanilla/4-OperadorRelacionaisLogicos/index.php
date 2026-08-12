<?php
declare(strict_types=1);

//Motor de análise de créditos

//Regras do negócio
//Regra da idade: O cliente precisa ter 18 anos ou mais e menos de 70 anos
//Regra da parcela (renda): O valor da parcela do empréstimo NÃO pode ser maior que 30% da renda mensal do cliente.
//Regra VIP: Se o cliente tiver um "Score de Crédito" maior que 800, ele tem aprovação automática. (As regras de Idade e renda não importam)
//Aprovação final: O crédito é liberado se (Regra 1 e regra 2 forem verdadeiras) OU se (Regra 3 for verdadeira)

//1. Dados que vieram do aplcativo do celular do cliente]
$idadeCliente = 25;
$rendaMensal = 4000.00;
$valorEmprestimo = 15000.00;
$numeroParcelas = 24;
$scoreCredito = 750; //Pontuação vai de 0 a 1000

//2. Cálculos aritméticos
$taxaJuros = 0.02; //Juros de 2$ ao mês
$valorJurosTotal = ($valorEmprestimo * $taxaJuros) * $numeroParcelas; //Juros simples
$valorTotalPagar = $valorEmprestimo + $valorJurosTotal;
$valorParcela = $valorTotalPagar / $numeroParcelas;

//3. O cerébro da Operação: Avaliação das regras de negócio

//Regra 1: Maior igual a 18 e Menor que 70
$idadeValida = ($idadeCliente >= 18 && $idadeCliente < 70);

//Regra 2: Parcela não pode ser maior que 30% da renda (renda*0.30)
$limiteRenda = ($rendaMensal * 0.30);
$rendaSuficiente = ($valorParcela <= $limiteRenda);

//Regra 3: Cliente VIP (Score maior que 800)
$isClienteVip = ($scoreCredito > 800);

//Aprovação final = idade e renda verdadeiras ou é clienteVip
$aprovado = (($idadeValida && $rendaSuficiente) || $isClienteVip);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de Crédito</title>
</head>
<body>
    <h2>Análise de Crédito</h2>
    <hr>
    <?php echo "<h4> Valor da Parcela: R$ " . number_format($valorParcela, 2, ",", ".") . "</h4>"; ?>
    <h4>Idade Válida: <?php echo ($idadeValida ? "sim" :  "não") ?></h4>
    <h4>Renda Suficiente: <?php echo ($rendaSuficiente ? "sim" :  "não") ?></h4>
    <h4>Cliente VIP: <?php echo ($isClienteVip ? "sim" :  "não") ?></h4>
    <h4>Resultado Final: <?php echo ($aprovado ? "sim" :  "não") ?></h4>
    

</body>
</html>