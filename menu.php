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
	?>
	<body>
	<div id = "master">
			
			<div id = "conteudo">
				<form name = "form1" action="cadastro.php" method="POST">		
		<ul class="ul">
			<li><a href="#"><input class="botao" type = "submit" value= "Home" name = "home"></a></li>
			<li><a href="#">About</a>
			<ul>
				<li><a href="#"><input class="botao" type = "submit" value= "App Requirements" name = "appR"></a></li>
				<li><a href="#"></a></li>
			</ul>
			</li>
			<li><a href="#"><input class="botao" type = "submit" value= "Show Table" name = "mTabela"></a>
			<li><a href="#"><input class="botao" type = "submit" value= "Register" name = "cadastrar"></a>
			<li><a href="#">Empty item</a>
				<ul>
					<li><a href="#">Empty item</a></li>
					<li><a href="#">Empty item</a></li>
					<li><a href="#"></a></li>
				</ul>
			</li>
			<li><a href="#"><input class="botao" type = "submit" value= "Exit" name = "sair"></a></li>
	</ul>
	</body>
</html>