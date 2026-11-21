AULA - PERSISTÊNCIA DE DADOS COM PHP + MYSQL

Conteúdos:
- INSERT
- PDO
- Prepared Statements
- Parâmetros nomeados
- Validação antes da gravação
- Prevenção de SQL Injection

ARQUIVOS

01_banco.sql
Cria o banco aula_php e a tabela alunos.

02_conexao.php
Cria a conexão PDO com o MySQL.

03_cadastro_aluno.php
Exemplo principal da aula:
HTML -> POST -> validação -> prepared statement -> INSERT.

04_exemplo_nao_fazer.php
Exemplo exclusivamente didático mostrando a montagem insegura de SQL.
Não executar como solução final.

COMO EXECUTAR

1. Inicie o MySQL pelo XAMPP ou outro servidor MySQL local.

2. Execute o arquivo 01_banco.sql no phpMyAdmin ou cliente MySQL.

3. Abra um terminal na pasta dos arquivos.

4. Inicie o servidor PHP:

php -S localhost:8000

5. No navegador, acesse:

http://localhost:8000/03_cadastro_aluno.php

FLUXO DA AULA

FORMULÁRIO
   ↓
POST
   ↓
trim()
   ↓
VALIDAÇÃO
   ↓
PDO
   ↓
prepare()
   ↓
PARÂMETROS NOMEADOS
   ↓
bindValue()
   ↓
execute()
   ↓
INSERT
   ↓
MYSQL

PONTO PRINCIPAL

Evite montar SQL concatenando diretamente valores fornecidos pelo usuário.
Utilize prepared statements e parâmetros para separar a estrutura do comando SQL dos dados.