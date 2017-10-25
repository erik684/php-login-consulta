<?php 
	$dbconnection = mysqli_connect("localhost", "root", "", "hospitais"); //endereco_servidor , usuario, senha, nome_banco

	if (!$dbconnection) {
		die("Conexão falhou: ".mysqli_connect_error());
	}

	/*if (mysql_errno()) {
		echo "Connection failed:".mysql_error();
		exit;
	}*/
	
?>