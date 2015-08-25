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
		echo "<div id = 'titulo' class = 'titulo'>Application Requirements</div>";
	?>
		<fieldset id = "idColNome">
			Para ler a análise de requisitos feita, clique no link abaixo...</br></br>
			<a href="GabLai.docx">Efetuar o download</a> 
		</fieldset>