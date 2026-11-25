LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA 📚

### Parte A: Questões Teóricas de Fixação

1. **Evolução Arquitetural:** Quais foram os principais aprendizados técnicos obtidos na construção do MVC artesanal da Semana 12 que permitiram que você compreendesse o Laravel 11 com facilidade?
> Resposta:


2. **A Nova Arquitetura do Laravel 11:** O que mudou na estrutura de inicialização do Laravel 11 em relação às versões anteriores (Laravel 9 e 10)? Onde fica o novo ponto central de configuração?
> Resposta:


3. **Padrão 12-Factor App:** Por que é uma violação grave de segurança gravar senhas de banco de dados diretamente dentro do arquivo `config/database.php` em vez de utilizar o arquivo `.env`?
> Resposta:

4. **O Papel da `APP_KEY`:** Qual é o risco técnico de alterar a `APP_KEY` de uma aplicação que já está em produção há meses com usuários reais cadastrados?
> Resposta:

5. **Isolamento de Diretórios:** Por que um servidor web de produção (Nginx/Apache) deve apontar rigorosamente para a pasta `public/` e nunca para a raiz do projeto Laravel?
> Resposta:

6. **Artisan CLI:** Qual é a diferença prática entre executar um script PHP procedural com `php arquivo.php` e executar comandos através do `php artisan`?
> Resposta:

7. **O Arquivo `.env.example`:** Por que manter o arquivo `.env.example` sempre atualizado é indispensável para o sucesso de equipes de desenvolvimento que utilizam Git?
> Resposta:

8. **Motor de Templates Blade:** Qual é a diferença entre a diretiva Blade `{{ $variavel }}` e a diretiva `{!! $variavel !!}` em termos de proteção contra ataques Cross-Site Scripting (XSS)?
> Resposta:

9. **Responsabilidade do Controller:** Em uma aplicação profissional com Laravel, por que um método de Controller deve ser curto (≤ 20 linhas) e não deve conter consultas SQL cruas ou regras de negócio extensas?
> Resposta:

10. **A Ferramenta Tinker:** Para que serve o comando `php artisan tinker` e em quais situações ele economiza tempo do desenvolvedor durante testes de laboratório?
> Resposta:

---