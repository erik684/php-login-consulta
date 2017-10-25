<?php 

	$sql = "SELECT * FROM TB_USUARIO WHERE Email_Cli = '$Email_Cli' AND Senha_Cli = '$Senha_Cli' ";	

	$result = mysqli_query($dbconnection, $sql);

	$row = mysqli_fetch_assoc($result);	

		if (empty($row) || $row['Status_Cli'] == 'I' ) {		
			header("Location: ../index.php?login=erro");
		}
		else {
			$_SESSION['Id_Cliente'] = $row['Id_Cliente'];
			$_SESSION['Email_Cli'] = $row['Email_Cli'];
			$_SESSION['Nome_Cli'] = $row['Nome_Cli'];
			$_SESSION['Priv_Cli'] = $row['Priv_Cli'];
			$_SESSION['Tipo_Cli'] = $row['Tipo_Cli'];
			header("Location: ../index.php?login=successo");
?>