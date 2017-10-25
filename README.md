# php-login-consulta
Projeto feito em Php e Boostrap para listar dados do banco de dados MySQL.
Possui um login basico e alguns filtros usando apenas php.
# Instruções
Execute o arquivo <i>selecao_php.sql</i> no seu banco de dados MySQL para criar o banco e a tabela já com os dados usados no projeto.
Em seguida é necessario criar a tabela de usuário e registrar um usuário no banco, basta executar o arquivo <i>susuario_login_php</i> no seu banco e já estara criado um usuário com login <b>admin</b> e senha <b>admin</b> 

Depois abra o arquivo na pasta 'includes/conexao_bd.php' e coloque na função mysqli_connect as informações para acessar o seu banco.
mysqli_connect("endereco_banco", "login", "senha", "nome_banco");


