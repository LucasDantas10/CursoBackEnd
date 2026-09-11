<?php
declare(strict_types=1);

$email="";
$loginValidade=false;
$erros=[];

//pegar os dados do formulário
//verifica se o formulário está enviando os dados como post
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = trim($_POST["email"] ?? ""); //Limpar os espaços vazios antes e depois do texto.
    $senha = trim($_POST["senha"] ?? "");

    //Validações de dados
    if($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erros["email"] = "Informe um email válido";
    }

    //Validação da senha
    if(strlen($senha) < 6){
        $erros["senha"] = "A senha deve ter no mínimo 6 digitos!";
    }

    //Se senha e email estão OK
    if(empty($erros)){
        $emailCorreto = "admin@senai.br";
        $senhaCorreta = "senhaSegura123";

        //Validando o email e a senha
        if($email === $emailCorreto && $senha === $senhaCorreta){
            $loginValidade = true;
        } else{
            $erros["login"] = "Credenciais Inválidas";
        }
    }
}
?>