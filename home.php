<html>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8"/>
	<?php
		if(!isset($_SESSION['permissao']))
			session_start();
		if($_SESSION['permissao'] <= 0 ){
			echo 	"<div class='negada'>Permissão negada!</div> 
					<div class='negada'>É necessário efetuar login para acessar essa página... </div>
					<div class='negada'><a href='index.php'>Logar</a></div>";
			exit();
		}
		$user = $_SESSION['usuario'];
		echo "<div id = 'titulo' class = 'titulo'>Olá $user !</div>";
	?>
		<fieldset id = "idColNome">
				Universidade Federal da Fronteira Sul</br>
				Ciência da Computação</br>
				Programação II</br></br><br>
				Trabalho integrador com Banco de Dados I e Programação II</br>
				Aplicação Para Controle de Salões de Beleza/Cabeleireiros</br></br></br></br>
				Developed by Gabrielle Souza and Lais Borin</br>
				Demo version
		</fielset>

	<body>
	</body>
</html>