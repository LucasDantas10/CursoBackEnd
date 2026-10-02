# Lista de Exercícios de Fixação e Prática

## Parte A: Exercícios Teóricos de Fixação

### 1. Definição de CRUD

**Pergunta:** O que significa o acrônimo CRUD e qual é a correspondência direta de cada uma de suas letras com as instruções SQL no PostgreSQL?

**Resposta:** CRUD significa Create, Read, Update e Delete, que representam as quatro operações básicas realizadas em um banco de dados. O Create corresponde ao comando `INSERT`, utilizado para inserir novos registros; o Read corresponde ao comando `SELECT`, utilizado para consultar dados; o Update corresponde ao comando `UPDATE`, utilizado para alterar registros existentes; e o Delete corresponde ao comando `DELETE`, utilizado para excluir registros.

---

### 2. Anatomia do SQL Injection

**Pergunta:** Explique com suas próprias palavras como um atacante consegue alterar a lógica de uma consulta quando o código utiliza concatenação de strings com `$_GET` ou `$_POST`.

**Resposta:** O SQL Injection acontece quando informações fornecidas pelo usuário por meio de `$_GET` ou `$_POST` são inseridas diretamente em uma consulta SQL utilizando concatenação de strings. Dessa forma, o banco de dados pode interpretar parte do conteúdo enviado pelo usuário como uma instrução SQL em vez de tratá-lo apenas como um dado. Com isso, um atacante pode modificar a lógica original da consulta e realizar operações que não deveriam ser permitidas pela aplicação. Para evitar esse problema, é recomendado utilizar Prepared Statements e parâmetros vinculados.

---

### 3. Mecanismo das Prepared Statements

**Pergunta:** Por que o envio de uma consulta em duas etapas (`prepare` e depois `execute`) impede que um texto digitado pelo usuário seja executado como instrução SQL pelo banco?

**Resposta:** As Prepared Statements separam a estrutura da consulta SQL dos dados fornecidos pelo usuário. Primeiro, a consulta é preparada por meio do `prepare`, definindo sua estrutura e seus parâmetros, e depois os valores são enviados separadamente pelo `execute`. Dessa forma, o conteúdo fornecido pelo usuário é tratado como um valor ou dado e não como parte da instrução SQL. Assim, mesmo que o usuário informe caracteres que poderiam representar comandos SQL, eles não são interpretados como código SQL pelo banco de dados, reduzindo o risco de SQL Injection.

---

### 4. Marcadores Nomeados

**Pergunta:** Qual é a vantagem de utilizar marcadores nomeados como `:sku` e `:preco` em vez de pontos de interrogação posicionais (`?`) em instruções SQL complexas?

**Resposta:** A principal vantagem dos marcadores nomeados é tornar a consulta SQL mais clara, organizada e fácil de entender, pois cada parâmetro possui um nome que indica qual informação será inserida naquele local. Por exemplo, utilizando `:sku` e `:preco`, fica mais fácil identificar que um parâmetro representa o código do produto e o outro representa seu preço. Em consultas complexas, isso também facilita a manutenção do código e reduz a possibilidade de erros relacionados à ordem dos parâmetros.

---

### 5. Diferença entre Bindings

**Pergunta:** Explique a diferença de comportamento entre os métodos `$stmt->bindValue()` e `$stmt->bindParam()`.

**Resposta:** A diferença principal é que o método `bindValue()` vincula o valor atual da variável ao parâmetro no momento em que o método é chamado, enquanto o `bindParam()` vincula uma variável por referência, fazendo com que o valor da variável seja utilizado no momento da execução da instrução. Portanto, `bindValue()` trabalha diretamente com o valor informado naquele momento, enquanto `bindParam()` mantém uma referência à variável vinculada.

---

### 6. Tipagem no PDO

**Pergunta:** Qual é o risco de omitir o tipo de dado (ex: `PDO::PARAM_INT`) ao vincular uma variável que deveria ser estritamente numérica em uma cláusula `LIMIT`?

**Resposta:** O risco de não informar o tipo correto é permitir que um valor que deveria ser tratado como inteiro seja interpretado de maneira diferente da esperada, podendo causar erros ou comportamentos inesperados na consulta. Ao utilizar `PDO::PARAM_INT`, é informado explicitamente ao PDO que aquele parâmetro deve ser tratado como um número inteiro, garantindo maior previsibilidade e segurança no processamento de valores numéricos, como os utilizados em uma cláusula `LIMIT`.

---

### 7. Padrão DAO

**Pergunta:** Qual é o benefício do padrão Data Access Object (DAO) em termos de manutenibilidade de software e do princípio de responsabilidade única (SOLID)?

**Resposta:** O padrão DAO tem como principal benefício separar a lógica de acesso ao banco de dados da lógica principal da aplicação, concentrando as operações de consulta, inserção, alteração e exclusão em classes específicas. Isso facilita a manutenção do sistema, pois alterações relacionadas ao banco podem ser feitas no DAO sem a necessidade de modificar diversas partes da aplicação. Essa organização também segue o princípio da Responsabilidade Única do SOLID, pois cada classe fica responsável por uma função específica.

---

### 8. Operações de Update

**Pergunta:** Por que a ausência de uma cláusula `WHERE` em um comando `UPDATE` é considerada um incidente gravíssimo em ambientes de produção?

**Resposta:** A ausência da cláusula `WHERE` em um comando `UPDATE` pode fazer com que todos os registros de uma tabela sejam alterados, pois não existe nenhuma condição determinando quais registros devem ser modificados. Por exemplo, um comando como `UPDATE produtos SET preco = 100;` pode alterar o preço de todos os produtos da tabela. Em um ambiente de produção, isso pode causar perda ou alteração massiva de informações, gerar prejuízos e comprometer a integridade dos dados, por isso é fundamental verificar as condições do `UPDATE` antes de executá-lo.

---

### 9. Impacto da LGPD

**Pergunta:** De acordo com a Lei Geral de Proteção de Dados (LGPD), quais são as penalidades e impactos que uma organização pode sofrer caso ocorra vazamento de dados de clientes por falha de SQL Injection?

**Resposta:** Um vazamento de dados pessoais causado por uma falha de segurança, como SQL Injection, pode gerar consequências administrativas, financeiras e jurídicas para a organização. De acordo com a LGPD, dependendo das circunstâncias e da gravidade da infração, podem ser aplicadas sanções pela Autoridade Nacional de Proteção de Dados (ANPD), incluindo advertência, multa simples de até 2% do faturamento da empresa no Brasil, limitada a R$ 50 milhões por infração, além de outras sanções previstas na legislação. A organização também pode precisar comunicar o incidente à ANPD e aos titulares dos dados quando aplicável, além de enfrentar custos para investigar e corrigir a vulnerabilidade, danos à reputação, perda de confiança dos clientes e possíveis responsabilidades civis relacionadas aos danos causados pelo incidente.
