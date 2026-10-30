# LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA - SESSÕES, COOKIES e AUTENTICAÇÃO DE USUÁRIOS

## Pergunta 1: Protocolo Stateless

O que significa afirmar que o protocolo HTTP é "stateless" e por que o mecanismo de cookies/sessões é necessário para aplicações modernas?

> **Resposta:**
>
> Significa que o protocolo HTTP não armazena automaticamente informações sobre as requisições anteriores de um usuário. Cada requisição é independente. Os cookies e as sessões permitem manter informações entre diferentes acessos, como manter o usuário conectado e armazenar dados de navegação.

---

## Pergunta 2: Cookies vs. Sessões

Qual é a diferença entre os dados armazenados em um cookie e os dados mantidos no array superglobal `$_SESSION`? Qual dos dois apresenta maior segurança para informações confidenciais?

> **Resposta:**
>
> Os cookies armazenam informações diretamente no navegador do usuário, enquanto as sessões armazenam os dados no servidor, utilizando um identificador para reconhecer o usuário. As sessões são mais seguras para informações confidenciais, pois os dados não ficam diretamente expostos no navegador.

---

## Pergunta 3: A Flag HttpOnly

Explique detalhadamente como a configuração `httponly => true` impede o sequestro de sessão (Session Hijacking) mesmo se a aplicação possuir uma vulnerabilidade de Cross-Site Scripting (XSS).

> **Resposta:**
>
> A configuração `HttpOnly` impede que códigos JavaScript acessem os cookies por meio de funções como `document.cookie`. Assim, mesmo que um invasor explore uma vulnerabilidade XSS, terá dificuldade para roubar o identificador da sessão. Porém, essa proteção não impede todos os ataques XSS, apenas dificulta o roubo de cookies por JavaScript.

---

## Pergunta 4: A Flag SameSite

Qual é a finalidade do atributo `SameSite=Lax` em cookies e contra qual tipo de ataque ele atua?

> **Resposta:**
>
> O atributo `SameSite=Lax` controla quando os cookies podem ser enviados em requisições originadas de outros sites. Ele ajuda a proteger contra ataques CSRF (Cross-Site Request Forgery), evitando o envio automático de cookies em grande parte das requisições entre sites, mas permitindo determinadas navegações comuns, como acessar um link externo.

---

## Pergunta 5: Ataque de Fixação de Sessão

O que é o ataque de Session Fixation e por que é mandatório executar `session_regenerate_id(true)` imediatamente após o login do usuário?

> **Resposta:**
>
> Session Fixation acontece quando um invasor consegue fazer a vítima utilizar um identificador de sessão conhecido por ele. Após o login, o sistema deve executar `session_regenerate_id(true)` para gerar um novo identificador e excluir o anterior. Isso impede que o invasor utilize o identificador antigo para acessar a conta da vítima.

---

## Pergunta 6: MD5 e Rainbow Tables

Por que é considerado negligência técnica armazenar senhas com algoritmos rápidos como MD5 ou SHA256? Como as Rainbow Tables operam contra esses hashes?

> **Resposta:**
>
> MD5 e SHA256 são algoritmos muito rápidos, permitindo que invasores testem milhões de senhas por segundo em ataques de força bruta. As Rainbow Tables são tabelas pré-computadas que relacionam possíveis senhas aos seus respectivos hashes, facilitando a descoberta de senhas armazenadas sem proteção adequada. Por isso, devem ser utilizados algoritmos específicos para senhas, como Argon2id ou Bcrypt.

---

## Pergunta 7: O Papel do Salt

O que é o Salt criptográfico e por que ele garante que dois usuários com a mesma senha possuam hashes completamente distintos no banco de dados?

> **Resposta:**
>
> Salt é um valor aleatório adicionado à senha antes do processo de geração do hash. Ele faz com que senhas iguais produzam hashes diferentes, dificultando ataques com Rainbow Tables e impedindo que invasores identifiquem facilmente usuários que possuem a mesma senha. Cada senha deve possuir um Salt exclusivo.

---

## Pergunta 8: Argon2id vs Bcrypt

Por que o algoritmo Argon2id é considerado superior ao Bcrypt na proteção contra ataques de força bruta realizados por placas de vídeo (GPUs) e circuitos ASIC?

> **Resposta:**
>
> O Argon2id permite configurar o consumo de memória e o tempo de processamento, tornando os ataques de força bruta mais caros e difíceis. Ele é especialmente resistente ao uso de GPUs e circuitos ASIC porque exige uma quantidade significativa de memória. O Bcrypt também é seguro, mas possui menor resistência a ataques que utilizam processamento paralelo com grande capacidade de memória.

---

## Pergunta 9: Timing Attacks

Por que a verificação de senhas deve ser feita com `password_verify()` em vez do operador de comparação comum `===`?

> **Resposta:**
>
> A função `password_verify()` realiza a verificação da senha utilizando o algoritmo e os parâmetros armazenados no hash, além de oferecer uma comparação resistente a ataques de temporização (Timing Attacks). Já o operador `===` faz uma comparação comum de strings, que pode apresentar diferenças no tempo de execução dependendo dos dados comparados. Por isso, `password_verify()` é a opção recomendada para verificar senhas em PHP.

