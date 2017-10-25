<?php //FUNÇÃO QUE FILTRA A QUANTIDADE DE LINHAS SELECIONADA
if (isset($_GET['countRow'])) { //
include_once("conexao_bd.php");

	function resultadoCountFiltro($dbconnection) {	
	$count = $_GET['countRow']	;	
		if ($count == 'todas') {
			$sql = "SELECT idade, valor, ano, mes FROM consultas";

			$result_filter = mysqli_query($dbconnection, $sql);

			return $result_filter;
		}
		else {
			$sql = "SELECT idade, valor, ano, mes FROM consultas LIMIT $count";

			$result_filter = mysqli_query($dbconnection, $sql);


			return $result_filter;
		}
	}
	
	$result_filter = resultadoCountFiltro($dbconnection);
}

?>