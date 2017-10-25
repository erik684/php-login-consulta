<?php 
session_start();

include_once("includes/efetuar_login.php");
include_once("includes/filtrar_valortotal.php");
include_once("includes/filtrar_todosvalores.php");

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>	
	<link rel="stylesheet" href="css/bootstrap.min.css"> 	
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Página principal e menu</title>
</head>
<body>

<!-- ALERTAS BOOTSTRAP -->
<?php 
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	

	if (strpos($url, 'login=sucesso') !== false) { 		
		echo '<div class="alert alert-success alert-dismissable fade in text-center" id="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Você entrou com sucesso!</strong> Bem Vindo <strong>'.$_SESSION['usuario'].'</strong>
				</div>';
	}
	if (strpos($url, 'login=erro') !== false) { 		
		echo '<div class="alert alert-danger alert-dismissable fade in text-center" id="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Houve um erro ao efetuar login!</strong> tente novamente.
				</div>';
	}

	if (strpos($url, 'filtro=sucesso') !== false) { 		
		echo '<div class="alert alert-success alert-dismissable fade in text-center" id="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Resultados filtrado!</strong> Clique novamente na guia para verificar.
				</div>';
	}

	if (strpos($url, 'filtro=erro') !== false) { 		
		echo '<div class="alert alert-info alert-danger fade in text-center" id="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Houve um erro!</strong> Clique novamente no filtro ou na guia para verificar.
				</div>';
	}	

?>	

<!-- CONTAINER-PRINCIPAL -->
<div class="container">
	<!-- NAVBAR -->
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header"><a href="#" class="navbar-brand"><strong>Página principal</strong></a></div>
			<ul class="nav navbar-nav navbar-right">
				<?php 
				if (!isset($_SESSION['usuario'])) {
					echo 
					'<li class="active li-navbar" href=""><a class="btn btn-confirm pull-right" data-toggle="modal" data-target="#loginpopUpWindow" href="">LOGIN</a></li>';
				}
				else {
					echo '
					<li class="active li-navbar" href="">
						<form method="POST" action="">
							<button id="btn_sair" class="btn btn-danger btn-sair" name="btn_sair" type="submit">SAIR</button>
						</form>
					</li>';					
				}
				?>				
			</ul>
		</div>
	</nav>

	<?php if (isset($_SESSION['usuario'])) { //exibe a página com os dados caso usuário esteja logado
	include_once("includes/converter_ano.php"); //função que converte o numero do ano para valor legivel ex.: 13 -> 2013
	include_once("includes/converter_mes.php"); //função que converte o numero do campo 'mes' para nome do mês ex.: 1 -> Janeiro	
	include_once("includes/conexao_bd.php");
	
	$sql = "SELECT DISTINCT ano FROM consultas";
	$result_ano = mysqli_query($dbconnection, $sql);
	$sql = "SELECT DISTINCT mes FROM consultas";
	$result_mes = mysqli_query($dbconnection, $sql);

	?>
	<!-- CONTAINER-TABS -->
	<div class="container"> 
	  <div class="row">	  	
	    <div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Selecione uma opcão no lado direito: </h3>
                    <span class="pull-right">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="active"><a href="#valorMensal" data-toggle="tab">VALOR TOTAL POR MÊS</a></li>
                            <li><a href="#todosValores" data-toggle="tab">TODOS OS DADOS</a></li>
                        </ul>
                    </span>
                </div>

	      <!-- Tab valorMensal -->
	      <div class="tab-content">
	        <div role="tabpanel" class="tab-pane active" id="valorMensal">
	        <div class="container jumbotron">
				<div class="panel panel-default panel-custom">
				    <div class="panel-body">
				        <form class="form-inline" name="input" method="POST" action="" id="filter-tables">
				        	<div class="row">
				            	<div class="col-lg-4">
				                    <div class="panel panel-default">
				                        <div class="panel-body">
				                    		<h4 class="muted">Selecione o ano: </h4>
				                            <div class="row">
				                                <div class="col-sm-12">
				                                    <select class="input-sm form-control" name="selectAno">
				                                      <option value="todos">Todos</option>
				                                      <?php while ($row = mysqli_fetch_array($result_ano)) { ?>
				                                      <option value=<?php echo $row['ano'] ?>> <?php echo numAno($row['ano']); ?></option>
				                                      <?php } ?>
				                                    </select>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                
				                <div class="col-lg-4">
				                    <div class="panel panel-default">
				                        <div class="panel-body">
				                        	<h4 class="muted">Selecione o mês: </h4>
				                            <div class="row">
				                                <div class="col-sm-12">
				                                    <select class="input-sm form-control" name="selectMes">
				                                      <option value="todos">Todos</option>
				                                      <?php while ($row = mysqli_fetch_array($result_mes)) { ?>
				                                      <option value=<?php echo $row['mes']?> > <?php echo nomeMes($row['mes'])?> </option>
				                                      <?php } ?>
				                                    </select>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				        	</div>
				            <button id="btn_listar" name="btn_listar"  class="btn btn-success" type="submit">Listar</button>
				            </form>
				    </div>
				</div>
			</div>

			<div class="container jumbotron"> <!-- LISTA DE VALORES -->

				<?php if (isset($_POST['selectAno']) || isset($_POST['selectMes']) ) { ?>
					<legend>Lista de ano: "/<?php echo numAno($_POST['selectAno']) ?>" e mês: "/<?php echo nomeMes($_POST['selectMes']) ?>"</legend>
				<?php } ?>

				<div class="widget-content">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th id="table_id">Valor total
								</th><th id="">Mês
								</th><th id="">Ano
							</tr>
						</thead>

						<tbody>
						<?php
						if (isset($result)) {						   
							while ($row = mysqli_fetch_array($result)) {
							?>
								<tr>
									<td><?php echo 'R$'.number_format(round($row['valor_total']), 2, ',', '.') ?></td> <!-- MOSTRA VALOR EM FORMATO MOEDA PT-BR E ARREDONDA -->
									<td><?php echo nomeMes($row['mes']) ?></td>
									<td><?php echo '20'.$row['ano'] ?></td>
								</tr>
							<?php 
							}
						}  
						?>
						</tbody>
					</table>
				</div>	
			</div>

	        </div>

			<!-- Tab todos os valores -->
			<?php 
			include_once("includes/conexao_bd.php");

			$sql = "SELECT COUNT(*) FROM consultas"; //conta numeros de linhas para criar Filtro de Linhas
			$result = mysqli_query($dbconnection, $sql);
			$count = mysqli_fetch_array($result);
			$count = $count['COUNT(*)'];

			?>
	        <div role="tabpanel" class="tab-pane" id="todosValores">
	        	<div class="container jumbotron">
					<div class="row">
				        <div id="filter-panel" class="collapse filter-panel">
				            <div class="panel panel-default">
				                <div class="panel-body">
				                    <form class="form-inline" role="form" method="GET" action="">				                    	
				                        <div class="form-group">
				                            <label class="filter-col" style="margin-right:0;" for="pref-perpage">Máximo de linhas:</label>
				                            <select id="pref-perpage" class="form-control" name="countRow">
				                                <option value="todas">Todas</option>				                                
				                                <?php while ($count > 50) { $count = $count -100;?>
				                                <option value= <?php echo $count ?> > <?php echo $count ?> </option>
				                                <?php } ?>
				                            </select>                                
				                        </div>
				                        	<input type="hidden" name="filtro" value="sucesso">
				                            <button type="submit" class="btn btn-warning filter-col" >Filtrar</button>  				                   
				                    </form>
				                </div>
				            </div>
				        </div>    
				        <button type="button" id="btn_pesquisar" name="btn_pesquisar" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">Filtrar pesquisa</button>
					</div>
					<div class="container">
						<div class="widget-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th id="table_id">Valor
									</th><th id="">Mês
									</th><th id="">Ano
									</th><th id="">Idade
								</tr>
							</thead>

							<tbody>
							<?php
							if (isset($result_filter)) {

								while ($row = mysqli_fetch_array($result_filter)) {
								?>
									<tr>
										<td><?php echo 'R$'.number_format(round($row['valor']), 2, ',', '.') ?></td> <!-- MOSTRA VALOR EM FORMATO MOEDA PT-BR E ARREDONDA -->
										<td><?php echo nomeMes($row['mes']) ?></td>
										<td><?php echo numAno($row['ano']) ?></td>
										<td><?php echo $row['idade'] ?></td>
									</tr>
								<?php 
								}
							}  
							?>
							</tbody>
						</table>
					</div>
					</div>					
				</div>
	        </div>
	     </div>
	    </div>
	  </div>
	</div>

	<?php } ?>
			
		
	<hr class="divider"> <!-- FIM CONTAINER-DADOS -->
	<!-- FOOTER -->
    <footer class="blockquote-footer stick-footer">		  
    	<i>Erik Aleixo: <a class="btn btn-link" href="https:\\www.github.com/erik684/php-login-consulta">github.com/erik684/php-login-consulta</a>
    </footer>

</div> <!-- FIM CONTAINER-PRINCIPAL -->


<!-- LOGIN MODAL -->
<div class="modal fade" id="loginpopUpWindow">
	<div class="modal-dialog">
		<div class="modal-content">

		<!-- modal-header -->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<legend>Insira os dados abaixo:</legend>
		</div>

		<div class="modal-body">
			<!-- FORM LOGIN -->
			<form class="form-horizontal" method="POST" id="form" action="">

			<!-- USER INPUT-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="user_input">Usuário: </label>  
			  <div class="col-md-4">
			  <input id="user_input" name="user_input" type="text" placeholder="Digite nome de usuário" class="form-control input-md" required="" maxlength="30">
			  <span class="help-block">Ex.: lucas_silva, araujo_lima, pedro354</span>  
			  </div>
			</div>

			<!-- PASSWORD INPUT-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="pwd_input">Senha: </label>
			  <div class="col-md-4">
			    <input id="pwd_input" name="pwd_input" type="password" placeholder="Digite a senha" class="form-control input-md" required="" maxlength="16">			    
			  </div>
			</div>

			<!-- BOTÃO FORM FORM-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="btn_form"></label>
			  <div class="col-md-4">
			    <button id="btn_login" name="btn_login" class="btn btn-success" type="submit">Entrar</button>
			  </div>
			</div>				
			</fieldset>
			</form>
		</div>
	</div>
</div>

<script src="js/jquery-3.1.1.min"></script>
<script src="js/bootstrap.min.js"></script> 

</body>

</html>
