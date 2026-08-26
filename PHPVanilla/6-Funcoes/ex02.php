<?php
declare(strict_types=1);
?>

<?php
$imc = 30;
function classificarIMC(float $imc): string{
    if ($imc < 18.5){
        return "Abaixo do peso";
    } elseif ($imc < 25){
        return "Peso Normal";
    } elseif ($imc < 30){
        return "Sobrepeso";
    } else{
        return "Obesidade";
    }
}

echo classificarIMC($imc)

?>