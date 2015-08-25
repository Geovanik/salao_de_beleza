<?php

include "conectar.php";

if(isset($_POST["acao"])) //Quando clicar em enserir
			fazbagaca();

function fazbagaca(){
	$conn = conectar();
	$nome_usuario=$_POST["nameUser"];
	$senha_usuario=$_POST["nameSenha"];
	$senha_usuario = md5($senha_usuario);
	$acao=$_POST["acao"];
	//echo "$nome_usuario $senha_usuario $acao";

	

		$sql="SELECT * FROM funcionario WHERE login='$nome_usuario' AND senha='$senha_usuario'";


		$resp = pg_query($sql);
		$linha = pg_fetch_array($resp);
		$permissao_usuario=$linha["cargo"];
		$cod_usuario=$linha["idfuncionario"];
		//echo "cod = $cod_usuario per = $permissao_usuario";
		if($cod_usuario>0)
		{
			session_start();
			$_SESSION['permissao'] = $permissao_usuario;
			$_SESSION['usuario'] = $nome_usuario;
			$_SESSION['cod'] = $cod_usuario;
			header("location:cadastro.php");
			exit();
		}
		else
			echo "Senha ou usuário não confere";
	
	desconectar($conn);
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8"/>
		<title>Login</title>
	</head>
	<body>
		
		<div id = "master">
			<div id = "titulo" class = "titulo">Login</div>
			<div id = "conteudo">
				<FORM name = "form1" action = "index.php" method = "post">
					<fieldset id = "idColNome">
						<legend>Login:</legend>
						<table style="text-align: center;">
							<tr> 
								<td><label for = "idUser">Username:</label></td>
								<td>
									<input type = "text" name = "nameUser" id = "idUser" size = "20">
								</td>
								<td><div id = "valUser"></div></td>
							</tr>
							<tr> 
								<td><label for = "idSenha">Senha:</label></td>
								<td>
									<input type = "password" name = "nameSenha" id = "idSenha" size = "20">
								</td>
								<td><div id = "valSenha"></div></td>
							</tr>
							<tr> 
								<td colspan = "2"><input type = "submit" name = "acao" value = "Logar"> </td>
							</tr>
						</table>
					</fieldset>
				</FORM>
			</div>
		</div>
	</body>
</html>