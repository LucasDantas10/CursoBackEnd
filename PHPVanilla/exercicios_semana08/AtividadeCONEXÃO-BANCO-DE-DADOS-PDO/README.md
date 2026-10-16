# Parte A: Exercícios Teóricos de Fixação

## 1- Abstração de Dados: O que é o PDO no PHP e por que ele é preferível em relação a extensões especializadas procedurais como o antigo pgsql em projetos corporativos?

>Resposta: PDO é uma ferramenta do PHP usada para fazer conexão com bancos de dados. Ele é preferível em projetos corporativos porque permite trabalhar com diferentes bancos de dados, como PostgreSQL, MySQL e SQLite, usando uma estrutura parecida. Já o pgsql é específico para PostgreSQL.
---

## 2. Ciclo do DSN: Explique o que é a string DSN e detalhe a finalidade de cada um dos parâmetros configurados para o PostgreSQL (host, port, dbname).

>Resposta: DSN significa Data Source Name e é uma string que informa ao PHP qual banco de dados será acessado e onde ele está. No PostgreSQL, podemos ter uma string como "pgsql:host=localhost;port=5432;dbname=empresa". O host informa onde está o servidor do banco, o port informa a porta usada para a conexão e o dbname informa o nome do banco de dados que será acessado.
---

## 3. Padrão de Portas: Qual é a porta padrão de escuta do SGBD PostgreSQL (5432) e como ela é referenciada dentro da string de conexão?

>Resposta: A porta padrão do PostgreSQL é a 5432. Ela é informada dentro da string de conexão usando "port=5432". Por exemplo: "pgsql:host=localhost;port=5432;dbname=empresa".
---

## 4. Flags de Integridade: O que acontece quando definimos o atributo PDO::ATTR_ERRMODE com o valor PDO::ERRMODE_EXCEPTION? Qual seria o comportamento padrão caso essa flag não fosse definida?

>Resposta: Quando usamos PDO::ATTR_ERRMODE com PDO::ERRMODE_EXCEPTION, estamos dizendo ao PDO para lançar uma exceção quando acontecer algum erro na conexão ou em uma operação com o banco. Assim, podemos usar try e catch para tratar o erro. Se essa configuração não for definida, o comportamento padrão é PDO::ERRMODE_SILENT, no qual o PDO não lança uma exceção automaticamente e o programador precisa verificar os erros manualmente.
---

## 5. Fetch Mode: Qual é a vantagem de utilizar PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC para o consumo de memória RAM do servidor?

>Resposta: PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC faz com que os resultados das consultas sejam retornados usando o nome das colunas, sem criar também índices numéricos para os mesmos dados. Isso pode diminuir o uso de memória RAM, principalmente quando existem muitos registros sendo retornados.
---

## 6. Padrão Singleton: Por que abrir uma nova conexão com new PDO() a cada consulta executada no PostgreSQL pode esgotar o limite de max_connections do servidor?

>Resposta: Quando usamos new PDO() várias vezes, podemos criar várias conexões com o banco de dados. O PostgreSQL possui um limite de conexões chamado max_connections. Se o sistema abrir muitas conexões desnecessariamente, esse limite pode ser atingido e novas conexões podem ser recusadas. O padrão Singleton ajuda a evitar a criação desnecessária de várias instâncias da conexão.
---

## 7. Encapsulamento do Singleton: Por que o construtor da classe ConexaoBanco precisa ser declarado como private e quais métodos mágicos devem ser bloqueados para garantir a unicidade da instância?

>Resposta: O construtor da classe ConexaoBanco deve ser private para impedir que outras partes do sistema criem uma nova conexão usando new diretamente. Além disso, o método __clone() deve ser bloqueado para impedir que a instância seja clonada. Também podemos bloquear o __wakeup() para impedir a criação de outra instância por desserialização. Dessa forma, ajudamos a garantir que exista apenas uma instância da classe.
---

## 8. Segurança de Credenciais: Por que nunca devemos deixar o usuário e senha do banco de dados salvos de forma estática (hardcoded) dentro dos scripts PHP do projeto?

>Resposta: Nunca devemos deixar usuário e senha do banco escritos diretamente no código PHP porque essas informações podem ser descobertas por outras pessoas, principalmente se o código for enviado para um repositório, compartilhado ou exposto por algum problema no servidor. O mais seguro é guardar as credenciais em variáveis de ambiente ou em um sistema próprio para armazenar senhas e segredos.
---

## 9. Tratamento de Exceções & LGPD: Por que a exibição direta de $e->getMessage() de uma PDOException na tela do navegador é considerada uma falha grave de segurança (Information Disclosure)?

>Resposta: Mostrar diretamente $e->getMessage() na tela do navegador é perigoso porque a mensagem de erro do banco pode revelar informações internas do sistema, como nomes de tabelas, colunas, banco de dados, comandos SQL ou outras informações do servidor. Isso é chamado de Information Disclosure, ou divulgação de informações. O correto é guardar o erro nos logs para que o desenvolvedor possa analisá-lo e mostrar ao usuário apenas uma mensagem simples, como "Ocorreu um erro ao acessar o sistema".
