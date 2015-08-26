<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8"/>

	</head>

	<?php
		include "conectar.php";
		error_reporting(E_WARNING);
		if(!isset($_SESSION['permissao']))
			session_start();
		if($_SESSION['permissao'] <= 0 ){
			echo 	"<div class='negada'>Permissão negada!</div> 
					<div class='negada'>É necessário efetuar login para acessar essa página... </div>
					<div class='negada'><a href='index.php'>Logar</a></div>";
			exit();
		}
	?>
	<body id="fundo">
		<div id = "master">
			
			<div id = "conteudo">
				<form name = "form1" id="form1" action="teste.php" method="POST">	
					<ul class="ul">
						<li><a href="home.php" target="frame">Home</a></li>
						<li><a href="#">About</a>
						<ul>
							<li><a href="appR.php" target="frame">App Requirements</a></li>
							<li><a href="#"></a></li>
						</ul>
						</li>
						<li><a href="#">Cadastros</a>
						<ul>
							<li><a href="Tfuncionario.php" target="frame">Funcionários</a></li>
							<li><a href="Tcliente.php" target="frame">Clientes</a></li>
							<li><a href="Tservico.php" target="frame">Serviços</a></li>
							<li><a href="#"></a></li>
						</ul>
						</li>
						<!--<li><a href="#"><input class="botao" type = "submit" value= "Funcionários" name = "mTabela"></a>-->
						<li><a target="frame" href="agenda.php">Agenda</a>
						<li><a target="frame" href="relatorioCaixa.php">Caixa</a></li>
						<li><a href="sair.php">Sair</a></li>
					</ul>
				</form>
			</div>
			<div id="page">
				<iframe name="frame" src='home.php' frameborder='0' id='page' ></iframe>
			</div>
		</div>
	</body>
</html>