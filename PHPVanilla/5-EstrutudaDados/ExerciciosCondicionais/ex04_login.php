<?php 
declare(strict_types=1);
?>
<?php 
$cargoUsuario = "Gerente";
$senhaDigitada = "senhasegura123";
$senhaSistema = "senhasegura123";

$acesso = ($cargoUsuario === "Diretor" || $cargoUsuario === "Gerente") && ($senhaDigitada === $senhaSistema) ? "Acesso Liberado" : "Acesso Negado";
echo $acesso
?>