# LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA - Controllers e Routes no LARAVEL

## 1. Semântica RESTful: Por que uma ação de exclusão de dados nunca deve ser implementada através de uma requisição HTTP do tipo GET? Explique o risco associado a robôs de busca.
> Resposta: Porque o método GET serve apenas para consultar informações, não para excluir dados. Robôs de busca podem acessar links automaticamente e acabar excluindo informações sem querer.

## 2. Idempotência: O que significa o conceito de idempotência no protocolo HTTP e por que o método PUT é considerado idempotente enquanto o POST não é?
> Resposta: Idempotência significa que repetir uma requisição várias vezes gera o mesmo resultado. O PUT é idempotente porque atualiza um recurso com os mesmos dados, enquanto o POST pode criar vários registros a cada envio.

## 3. Resource Controllers: Quais são as 7 ações canônicas geradas pelo comando php artisan make:controller --resource e qual é a responsabilidade de cada uma?
> Resposta: As sete ações são: index (listar registros), create (exibir formulário de cadastro), store (salvar novo registro), show (exibir um registro), edit (exibir formulário de edição), update (atualizar um registro) e destroy (excluir um registro).

## 4. Injeção de Dependências: Como o Service Container do Laravel entrega automaticamente uma instância de Request ao método do controller sem que tenhamos que instanciá-la com new Request()?
> Resposta: O Service Container identifica o tipo Request indicado no método e cria automaticamente uma instância com os dados da requisição atual, entregando-a ao controller.

## 5. Method Spoofing: Por que os navegadores web não conseguem enviar requisições nativas de PUT e DELETE através de formulários HTML convencionais? Como o Laravel contorna essa limitação?
> Resposta: Porque os formulários HTML aceitam apenas GET e POST. O Laravel contorna essa limitação utilizando o campo oculto @method('PUT') ou @method('DELETE') para identificar o método desejado.

## 6. Ataques CSRF: O que é um ataque do tipo Cross-Site Request Forgery e como a diretiva Blade @csrf impede que sites maliciosos forjem requisições em nome do usuário?
> Resposta: É um ataque em que um site malicioso tenta realizar ações usando a sessão de um usuário sem sua autorização. O @csrf gera um token de segurança que o Laravel verifica para confirmar se a requisição é legítima.

## 7. Constraints de Rota: Para que servem métodos de restrição como whereNumber('id') ou whereAlphaNumeric('codigo') e qual código de status HTTP o Laravel retorna quando o formato é violado?
> Resposta: Servem para limitar os valores aceitos pelos parâmetros da rota, como permitir apenas números ou letras e números. Quando o formato não corresponde à restrição, o Laravel retorna o status HTTP 404 (Not Found).

## 8. Rotas Nomeadas: Cite duas vantagens corporativas de utilizar a função auxiliar route('clientes.show', $id) nas views em vez de escrever strings estáticas como "/clientes/{$id}".
> Resposta: As vantagens são facilitar a manutenção do sistema, pois o endereço pode mudar sem precisar alterar todas as views, e evitar erros na criação de links, tornando o código mais organizado.

## 9. Single Responsibility no Controller: Por que a validação de formulários com $request->validate() ou Form Requests deve ser mantida enxuta dentro do controller para respeitar o limite de 20 linhas por função?
> Resposta: Porque o controller deve ter apenas as responsabilidades principais da requisição. Manter a validação simples ou utilizar Form Requests deixa o código mais organizado, fácil de entender, testar e manter.

## 10. A Ferramenta route:list: Como o comando php artisan route:list auxilia equipes multidisciplinares a documentar e auditar os endpoints disponíveis em uma API ou aplicação web?
> Resposta: O comando mostra todas as rotas cadastradas, seus métodos HTTP, endereços, nomes e controllers responsáveis, facilitando a documentação, manutenção e identificação de possíveis problemas no sistema.
