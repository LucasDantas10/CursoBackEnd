<?php 
declare(strict_types=1);
?>

<?php 
$peso = 85.5;
$altura = 2.50;
$imc = $peso / ($altura * $altura);
if($imc<18.5) {
    echo "Abaixo do Peso";
} elseif($imc<25) {
    echo "Peso Normal";
} elseif($imc<30) {
    echo "Sobrepeso";
} elseif($imc<35) {
    echo "Obesidade Grau I";
} else {
    echo "Obesidade Grau II ou III";
};
?>