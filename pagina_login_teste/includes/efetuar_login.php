<?php //FUNÇÃO QUE VERIFICA LOGIN

if (isset($_POST['btn_login'])) { //se botão btn_login for pressionado, é efetuado a tentativa de login

	include_once("includes/conexao_bd.php");

	$login = $_POST['user_input'];
	$senha = $_POST['pwd_input'];
		
	$sql = "SELECT * FROM USUARIO WHERE usuario = '$login' AND senha = '$senha'";
	$result = mysqli_query($dbconnection, $sql);

	$row = mysqli_fetch_assoc($result);

	if (empty($row)) { //se usuário não existir	no banco
		header('Location: '.$_SERVER['PHP_SELF'].'?&login=erro');
		exit;
	}
	else { // se usuário existir no banco
		header('Location: '.$_SERVER['PHP_SELF'].'?&login=sucesso');
		$_SESSION['usuario'] = $row['usuario'];
		exit;			
	}
}

if (isset($_POST['btn_sair'])) { //se botão btn_logout for pressionado, é efetuado a saida do usuario
	session_destroy();
	header('Location: '.$_SERVER['PHP_SELF']);
	exit;
}
?>
