<?php 
declare(strict_types=1);

?>
<?php 

$idade = 18;

if($idade<16) {
    echo "Voto Proibido";
} elseif($idade<=17 || $idade>=70) {
    echo "Voto Facultativo";
} else {
    echo "Voto Obrigatório";
}
?>