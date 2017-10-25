<?php 
	function numAno($numero_ano) {

		switch ($numero_ano) {
			case (is_numeric($numero_ano)):
				return ($numero_ano = '20'.$numero_ano);
				break;
			
			case (is_string($numero_ano)):
				return "Todos";
				break;			
		}
	}
?>