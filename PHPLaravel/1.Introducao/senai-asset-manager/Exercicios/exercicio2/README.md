
# LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA - INTRODUÇÃO AO FRAMEWORK LARAVEL 11.X E ARTISAN CLI

## 1. Evolução Arquitetural: Quais foram os principais aprendizados técnicos obtidos na construção do MVC artesanal da Semana 12 que permitiram que você compreendesse o Laravel 11 com facilidade?
> Resposta: Na construção do MVC artesanal, aprendi a separar o sistema em Model, View e Controller, entendendo a função de cada parte. Também aprendi a organizar rotas, trabalhar com requisições e separar a lógica do sistema da parte visual. Esses conhecimentos facilitaram o entendimento do Laravel, pois ele utiliza os mesmos conceitos, mas oferece ferramentas que tornam o desenvolvimento mais rápido e organizado.

## 2. A Nova Arquitetura do Laravel 11: O que mudou na estrutura de inicialização do Laravel 11 em relação às versões anteriores (Laravel 9 e 10)? Onde fica o novo ponto central de configuração?
> Resposta: O Laravel 11 trouxe uma estrutura mais simples e enxuta, reduzindo a quantidade de arquivos de configuração e organização inicial do projeto. Nas versões anteriores, algumas configurações ficavam espalhadas em vários arquivos e diretórios. Agora, o principal ponto de inicialização e configuração fica no arquivo bootstrap/app.php, onde são configuradas rotas, middlewares e tratamento de exceções.

## 3. Padrão 12-Factor App: Por que é uma violação grave de segurança gravar senhas de banco de dados diretamente dentro do arquivo config/database.php em vez de utilizar o arquivo .env?
> Resposta: Porque colocar senhas diretamente no código pode expor informações confidenciais, principalmente quando o projeto é compartilhado pelo Git. O arquivo .env permite armazenar senhas, usuários e outras configurações separadamente do código-fonte. Dessa forma, cada ambiente pode ter suas próprias configurações, evitando que informações importantes sejam divulgadas.

## 4. O Papel da APP_KEY: Qual é o risco técnico de alterar a APP_KEY de uma aplicação que já está em produção há meses com usuários reais cadastrados?
> Resposta: A APP_KEY é utilizada pelo Laravel para proteger informações por meio de criptografia. Se ela for alterada, dados que foram criptografados com a chave antiga podem não ser mais descriptografados. Isso pode causar problemas em sessões, cookies e informações criptografadas, além de obrigar os usuários a realizar login novamente. Por isso, a chave deve ser mantida protegida e não deve ser alterada sem planejamento.

## 5. Isolamento de Diretórios: Por que um servidor web de produção (Nginx/Apache) deve apontar rigorosamente para a pasta public/ e nunca para a raiz do projeto Laravel?
> Resposta: Porque a pasta public contém os arquivos que podem ser acessados pelos visitantes, como imagens, CSS, JavaScript e o arquivo index.php. A raiz do projeto possui arquivos internos e informações importantes, como o .env, configurações e códigos da aplicação. Se o servidor apontar para a raiz, esses arquivos podem ficar expostos, colocando a segurança do sistema em risco.

## 6. Artisan CLI: Qual é a diferença prática entre executar um script PHP procedural com php arquivo.php e executar comandos através do php artisan?
> Resposta: O comando php arquivo.php executa um arquivo PHP comum, sem carregar automaticamente toda a estrutura do Laravel. Já o php artisan utiliza a estrutura do framework, permitindo executar tarefas administrativas e de desenvolvimento, como criar controllers, models, migrations, limpar caches e iniciar o servidor local. Isso facilita o trabalho e economiza tempo durante o desenvolvimento.

## 7. O Arquivo .env.example: Por que manter o arquivo .env.example sempre atualizado é indispensável para o sucesso de equipes de desenvolvimento que utilizam Git?
> Resposta: Porque o arquivo .env.example funciona como um modelo de configuração do projeto, mostrando quais informações são necessárias para executar a aplicação. Ele facilita o trabalho em equipe, pois novos desenvolvedores podem copiar esse arquivo e criar seu próprio .env. Além disso, permite compartilhar as configurações necessárias sem divulgar senhas, tokens ou outras informações confidenciais.

## 8. Motor de Templates Blade: Qual é a diferença entre a diretiva Blade {{ $variavel }} e a diretiva {!! $variavel !!} em termos de proteção contra ataques Cross-Site Scripting (XSS)?
> Resposta: A diretiva {{ $variavel }} exibe o conteúdo com proteção, convertendo caracteres especiais para impedir que códigos HTML ou JavaScript sejam executados no navegador. Já a diretiva {!! $variavel !!} exibe o conteúdo diretamente, sem essa proteção. Por isso, deve ser utilizada com muito cuidado, pois conteúdos maliciosos podem executar scripts e causar ataques XSS.

## 9. Responsabilidade do Controller: Em uma aplicação profissional com Laravel, por que um método de Controller deve ser curto (≤ 20 linhas) e não deve conter consultas SQL cruas ou regras de negócio extensas?
> Resposta: Porque o Controller deve ser responsável principalmente por receber as requisições, validar os dados e direcionar as ações do sistema. Quando possui muitas linhas, consultas SQL e regras de negócio, o código fica difícil de entender, testar e manter. Separar essas responsabilidades em Models, Services e Form Requests deixa a aplicação mais organizada, facilita futuras alterações e evita repetição de código.

## 10. A Ferramenta Tinker: Para que serve o comando php artisan tinker e em quais situações ele economiza tempo do desenvolvedor durante testes de laboratório?
> Resposta: O Tinker é uma ferramenta interativa do Laravel que permite executar comandos PHP diretamente no terminal, utilizando os recursos da aplicação. Com ele, é possível testar Models, consultar e cadastrar informações no banco de dados, verificar relacionamentos e testar funções sem precisar criar páginas ou controllers. Isso economiza tempo e facilita a identificação de erros durante o desenvolvimento.
