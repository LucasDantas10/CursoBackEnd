# LISTA DE EXERCÍCIOS: PROCESSAMENTO HTTP E FORMULÁRIOS

## Parte A: Exercícios Teóricos de Fixação

### 1. Diferença Estrutural: Explique a diferença física entre onde os dados são anexados em uma requisição GET e em uma requisição POST.

> Resposta: Na requisição `GET`, os dados são colocados na própria `URL`, depois do `?`, ficando visíveis no endereço. Já na requisição `POST`, os dados são enviados no `corpo (body)` da requisição, sem aparecer diretamente na URL.
---
### 2. Segurança e Privacidade: Por que senhas de usuário nunca devem ser enviadas via método GET? Cite pelo menos dois locais onde essa senha ficaria gravada de forma insegura.

> Resposta: Porque no método `GET` os dados ficam visíveis na URL, o que pode deixar a senha exposta para todos verem. Ela poderia ficar gravada no `histórico do navegador` e nos `logs do servidor`.
---
### 3. Coalescência Nula: Por que a instrução $nome = $_POST['nome']; dispara um Warning na primeira vez que a página é carregada no navegador? Como o operador ?? resolve isso?

> Resposta: Porque se a variável nome não tiver sido criada vai dar um Warning. O `??` resolve porque, se ela não existir, ele coloca um valor vazio no lugar.
---
### 4. Idempotência: O que significa dizer que uma requisição GET é idempotente? Por que atualizar ou deletar dados no banco usando links GET é uma má prática de segurança?

> Resposta: Significa que fazer a mesma requisição `GET` várias vezes não deve mudar o resultado. Atualizar ou deletar dados usando links `GET` é uma má prática porque alguém pode acessar o link sem querer e acabar alterando ou apagando os dados.
---
### 5. Validação Client vs Server: Um desenvolvedor júnior afirma que o formulário dele é 100% seguro porque colocou required e type="email" em todas as tags HTML. Explique por que essa afirmação é falsa.

> Resposta: Porque essas validações podem ser burladas pelo usuário. Por isso, os dados também precisam ser validados no `BackEnd`, antes de serem processados ou salvos no banco.
---
### 6. XSS e Sanitização: Qual é o risco de exibir dados vindos de um $_POST diretamente na tela sem utilizar htmlspecialchars()?

> Resposta: O risco é alguém colocar um código malicioso no formulário e ele acabar sendo executado na página, causando um ataque `XSS`. O `htmlspecialchars()` evita que esse código seja interpretado pelo navegador.
---
### 7. Sticky Forms: O que é a técnica de Sticky Forms e qual é o seu impacto na experiência do usuário (UX)?

> Resposta: A técnica do `Sticky Form` consiste em imprimir de volta no atributo `value` do input os dados que o usuário acaba de digitar caso ocorra um erro de validação de dados. Isso melhora a experiência do usuário, porque ele não precisa preencher tudo de novo.
---
### 8. DevTools: Como você utilizaria a aba Network do navegador para comprovar que um formulário foi enviado via POST e não via GET?

> Resposta: Eu abriria o `DevTools`, entraria na aba `Network` e enviaria o formulário. Depois, eu clicaria na requisição e olharia o `Request Method`. Se estiver escrito `POST`, então o formulário foi enviado por `POST`.
---

