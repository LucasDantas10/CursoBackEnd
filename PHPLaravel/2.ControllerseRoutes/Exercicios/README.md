LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA 📚

### Parte A: Questões Teóricas de Fixação

1. **Semântica RESTful:** Por que uma ação de exclusão de dados nunca deve ser implementada através de uma requisição HTTP do tipo GET? Explique o risco associado a robôs de busca.

2. **Idempotência:** O que significa o conceito de idempotência no protocolo HTTP e por que o método PUT é considerado idempotente enquanto o POST não é?

3. **Resource Controllers:** Quais são as 7 ações canônicas geradas pelo comando `php artisan make:controller --resource` e qual é a responsabilidade de cada uma?

4. **Injeção de Dependências:** Como o Service Container do Laravel entrega automaticamente uma instância de `Request` ao método do controller sem que tenhamos que instanciá-la com `new Request()`?

5. **Method Spoofing:** Por que os navegadores web não conseguem enviar requisições nativas de PUT e DELETE através de formulários HTML convencionais? Como o Laravel contorna essa limitação?

6. **Ataques CSRF:** O que é um ataque do tipo *Cross-Site Request Forgery* e como a diretiva Blade `@csrf` impede que sites maliciosos forjem requisições em nome do usuário?

7. **Constraints de Rota:** Para que servem métodos de restrição como `whereNumber('id')` ou `whereAlphaNumeric('codigo')` e qual código de status HTTP o Laravel retorna quando o formato é violado?

8. **Rotas Nomeadas:** Cite duas vantagens corporativas de utilizar a função auxiliar `route('clientes.show', $id)` nas views em vez de escrever strings estáticas como `"/clientes/{$id}"`.

9. **Single Responsibility no Controller:** Por que a validação de formulários com `$request->validate()` ou Form Requests deve ser mantida enxuta dentro do controller para respeitar o limite de 20 linhas por função?

10. **A Ferramenta `route:list`:** Como o comando `php artisan route:list` auxilia equipes multidisciplinares a documentar e auditar os endpoints disponíveis em uma API ou aplicação web?