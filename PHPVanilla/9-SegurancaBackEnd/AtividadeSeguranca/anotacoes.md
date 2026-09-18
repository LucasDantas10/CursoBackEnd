# Parte A: Exercícios Teóricos de Fixação

## 1. Conceituação OWASP: O que significa a sigla XSS e por que ela é classificada como uma vulnerabilidade no lado do cliente (Client-Side) que deve ser prevenida pelo Back-End?

> Resposta: XSS significa Cross-Site Scripting. É uma vulnerabilidade que permite que um atacante coloque um código malicioso, geralmente JavaScript, dentro de uma página que será acessada por outros usuários. Ela é considerada uma vulnerabilidade do lado do cliente porque o código acaba sendo executado no navegador da vítima. Mesmo assim, o Back-End precisa ajudar a prevenir isso, principalmente validando os dados recebidos e codificando corretamente o conteúdo antes de enviá-lo para a página.

## 2. Reflected vs Stored: Qual é a diferença entre um ataque XSS Refletido e um XSS Gravado (Stored)? Qual dos dois apresenta maior potencial de estrago para uma empresa e por quê?

> Resposta: No XSS Refletido, o código malicioso normalmente vem em uma requisição, como em um link, e é devolvido pela aplicação para o navegador sem ser armazenado. Já no XSS Stored, o código malicioso fica salvo no sistema, por exemplo em um comentário ou cadastro, e depois pode ser executado para várias pessoas que acessarem aquele conteúdo. O Stored pode ter um impacto maior porque o ataque fica armazenado no sistema e pode atingir vários usuários sem precisar que cada um receba um link separado.

## 3. Mecanismo de Escapamento: Explique detalhadamente a transformação que a função htmlspecialchars() realiza nos caracteres < e >. Por que o navegador não executa o código após essa transformação?

> Resposta: A função htmlspecialchars() transforma caracteres especiais em entidades HTML. Por exemplo, o caractere < vira &lt; e o > vira &gt;. Dessa forma, se alguém tentar colocar algo como `<script>`, o navegador vai interpretar aquilo como texto, e não como uma tag HTML. Por isso o código não é executado, já que o navegador não entende mais aqueles caracteres como parte de uma tag.

## 4. Flags de Proteção: Qual é a função da flag ENT_QUOTES na chamada de htmlspecialchars()? O que pode acontecer se essa flag for omitida em um campo `<input value="...">`?

> Resposta: A flag ENT_QUOTES faz com que a função também escape as aspas simples (') e as aspas duplas ("). Isso é importante principalmente em campos como `<input value="...">`, porque as aspas são usadas para definir o valor do atributo. Se elas não forem tratadas, um atacante pode tentar fechar o atributo e colocar outro código HTML ou JavaScript dentro dele. Com ENT_QUOTES, essas aspas são convertidas para entidades HTML e fica mais difícil ocorrer esse tipo de problema.

## 5. Anti-Alucinação PHP: Por que não devemos utilizar o filtro FILTER_SANITIZE_STRING em projetos modernos desenvolvidos em PHP 8.3?

> Resposta: Porque o FILTER_SANITIZE_STRING foi depreciado no PHP 8.1 e não deve ser usado em projetos modernos. Além disso, ele não é uma solução completa contra XSS, porque sanitizar um texto não substitui a codificação correta na hora de mostrar esse texto na página. O mais correto é validar os dados de acordo com o que o sistema espera e usar funções de escape, como htmlspecialchars(), na saída.

## 6. Validação de E-mail: Qual é a diferença prática entre verificar um e-mail com empty($email) e verificar com filter_var($email, FILTER_VALIDATE_EMAIL)?

> Resposta: O empty($email) só verifica se a variável está vazia ou se o valor é considerado vazio pelo PHP. Ele não verifica se aquilo realmente parece um e-mail. Já o filter_var($email, FILTER_VALIDATE_EMAIL) verifica se o valor possui um formato válido de e-mail. Então, por exemplo, teste não seria considerado um e-mail válido pelo filter_var(), enquanto o empty() apenas verificaria se o campo está vazio ou não.

## 7. Roubo de Sessão: Como um atacante pode usar uma brecha XSS para capturar o cookie de sessão de um usuário logado?

> Resposta: Se existir uma vulnerabilidade XSS, o atacante pode conseguir executar JavaScript no navegador da vítima. Se o cookie de sessão estiver acessível pelo JavaScript, o código malicioso pode tentar acessar esse cookie usando document.cookie e enviar o valor para outro lugar controlado pelo atacante. Com o cookie roubado, dependendo das proteções usadas pela aplicação, o atacante pode tentar se passar pelo usuário. Uma forma importante de diminuir esse risco é usar cookies com a flag HttpOnly, que impede que o JavaScript acesse o cookie.

## 8. Segurança em Camadas: Por que sanitizar na entrada (ex: com strip_tags) não elimina a necessidade de codificar na saída com htmlspecialchars()?

> Resposta: Porque são proteções diferentes. O strip_tags() pode remover algumas tags HTML que foram enviadas pelo usuário, mas ele não deve ser usado como única proteção contra XSS. Além disso, os dados podem ser usados em diferentes lugares da aplicação e nem sempre o problema está somente nas tags. Já o htmlspecialchars() faz o escape dos caracteres especiais no momento em que o conteúdo vai ser colocado dentro do HTML. Por isso, o ideal é ter segurança em camadas: validar os dados na entrada e fazer a codificação correta na saída.
