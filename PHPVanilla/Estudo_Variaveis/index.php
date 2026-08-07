<?php
declare(strict_types=1); //blinda o sistema contra mistura acidentais de tipos de dados.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudo de variáveis</title>
</head>
<body>
    <h3>Estudo de variáveis</h3>
    <?php
    // Sintaxe de variáveis em PHP
    // Variáveis são representadas pelo símbolo "$" seguido do nome da variável
    // Exemplo
    $nome = "João"; // Variável do tipo String
    $idade = 25; // Variável do tipo number(int)
    $status = true; // Variável do tipo Boolean
    $altura = 1.75; //Variável do tipo Number(float)
    $email = null; //Variável do tipo Null(Não tem nada)
    $idade2 = 0;   //Variável de texto vazia
    $nome2 = "";   //Variável de texto vazia
    #$endereco; -> Não é possível declarar uma variável sem atribuir um valor a ela, não existe undefined em PHP

    //Exibir as variáveis na tela
    echo"Nome: $nome <br>";
    echo "Idade: $idade <br>";
    echo "Status: $status <br>";
    echo "Altura: $altura <br>";
    echo "Email: $email <br>";

    echo "<br> <h3> Constantes </h3> <br>";

    // Constantes são representadas pela palavra "const" ou "define" seguida do nome da constante
    // Exemplos de constantes
    const PI = 3.14; // Constante do tipo Number (float)
    const EMPRESA = "Google"; // Constante do tipo String
    define("SITE", "www.google.com"); //Constante do tipo String
    // Uma boa prática é utilizar letras maiúscula para nomear constantes, para diferenciar as variáveis

    // Exibir as constantes na tela
    echo "Valor de PI: " . PI . "<br>";
    echo "Nome da empresa: " . EMPRESA . "<br>";
    echo "Site: " . SITE . "<br>";

    // Tentando alterar o valor de uma constante, isso irá gerar um erro, pois constanes não podem ser alteradas
    # PI = 3.14159; -> Isso é um erro
    // Redeclarar uma constante também irá gerar um erro
    # const SITE = "www.google.com"; -> Isso é um erro
    
    // Regra de ouro: Sempre coloque a instrução declare(strict_types=1); no início do seu código PHP
    // Isso blinda o seu sistema contra mistura acidentais de tipos de dados.

    // Utilização de TEXTO (concatenação VS interpolação)
    // Exemplo de concatenação -> juntar duas ou mais string utilizando o operador "." (ponto)
    echo "Olá, " . $nome . "! Seja bem-vindo ao nosso site !<br>";

    // Exemplo de interpolação => Utilização de variáveis dentro de um texto, utilizando aspas duplas
    echo "$nome, tem $idade anos e sua altura é $altura metros. <br>"; //forma mais correta de misturar texto e variáveis



    ?>
    
    
</body>
</html>