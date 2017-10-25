<?php //FUNÇÃO QUE VERIFICA OPÇÃO SELECIONADA PELO USUÁRIO E FILTRA AS INFORMAÇÕES ESCOLHIDAS.
if (isset($_POST['btn_listar'])) { //se botão lista é pressionado
include_once("conexao_bd.php");

	function resultadoFiltro($dbconnection) {


			if (isset($_POST['selectAno']) && isset($_POST['selectAno'])) {

			if (($_POST['selectAno'] == "todos") && ($_POST['selectMes'] == "todos")) {

				$sql = "SELECT id, ano, mes, SUM(valor) AS valor_total FROM consultas  
				GROUP BY ano, mes";

				$result = mysqli_query($dbconnection, $sql);

				return $result;			
			}

			if (($_POST['selectAno'] != "todos") && ($_POST['selectMes'] != "todos")) {
				$ano = $_POST['selectAno'];
				$mes = $_POST['selectMes'];

				$sql = "SELECT id, ano, mes, SUM(valor) AS valor_total FROM consultas  
				WHERE ano = $ano AND mes = $mes
				GROUP BY ano, mes";

				$result = mysqli_query($dbconnection, $sql);

				return $result;
			}

			if (($_POST['selectAno'] != "todos")) {
				$ano = $_POST['selectAno'];
				$mes = $_POST['selectMes'];

				$sql = "SELECT id, ano, mes, SUM(valor) AS valor_total FROM consultas
				WHERE ano = $ano 
				GROUP BY ano, mes";

				$result = mysqli_query($dbconnection, $sql);

				return $result;
			}

			if (($_POST['selectMes'] != "todos")) {
				$mes = $_POST['selectMes'];

				$sql = "SELECT id, ano, mes, SUM(valor) AS valor_total FROM consultas 
				WHERE mes = $mes
				GROUP BY ano, mes";	

				$result = mysqli_query($dbconnection, $sql);

				return $result;
			}
		}
	}

$result = resultadoFiltro($dbconnection);

}