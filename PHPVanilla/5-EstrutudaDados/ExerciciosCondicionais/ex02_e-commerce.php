<?php 
declare(strict_types=1);
?>
<?php 
$valorCompra = 250;

$statusFrete = ($valorCompra>=250) ? "Frete Grátis" : "Frete R$ 25";

echo $statusFrete
?>