<?php
	include 'conectar.php';
	error_reporting(E_WARNING);
	if(!isset($_SESSION['permissao']))
		session_start();
	if($_SESSION['permissao'] <= 0 ){
		echo 	"<div class='negada'>Permissão negada!</div> 
				<div class='negada'>É necessário efetuar login para acessar essa página... </div>
				<div class='negada'><a href='index.php'>Logar</a></div>";
		exit();
	}
	$nome = '';
	$fone = '';
	$cpf = '';
	$login = '';
	$flag = '0';

	if(isset($_GET['op'])){
    	if($_GET['op']== 2){
			editar();
			$nome = $_POST['nome'];
			$fone = $_POST['fone'];
			$cpf = $_POST['cpf'];
			$login = $_POST['login'];
			$flag = '1';
		}
	}
	function editar()
	{
		$conn = conectar();
		$cod = $_GET['cod'];
		$sql = "SELECT * FROM funcionario WHERE cpf = '$cod'";
		$sql2 = pg_query($sql) or die("Erro na consulta!");

		$n = pg_fetch_array($sql2);

		$_POST['nome'] 		= $n['nome'];
		$_POST["cpf"] 		= $n['cpf'];
		$_POST["login"] 	= $n['login'];
		$_POST["senha"] 	= "";
		$_POST["fone"]		= $n['fone'];
		$_POST["nameCargo"]		= $n['cargo'];
		desconectar($conn);

	}
?>
<html>
	<link rel="stylesheet" type="text/css" href="style.css">
	 <link rel="stylesheet" type="text/css" href="colorbox.css">
	<meta charset="UTF-8"/>
	<head>
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.colorbox.js" type="text/javascript"></script>
		<script src="jquery.maskedinput.js" type="text/javascript"></script>
	</head>
	<script language= "JavaScript" type = "text/JavaScript" >
		
        jQuery(function($){
        	$("#idCPF").mask("999.999.999-99",{placeholder:" "});
        	$("#idFone").mask("(99) 9999-9999",{placeholder:" "});
        });
        var count = 1;

		function validarNome()
		{ 
				var nome = form1.nameNome.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+(\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+)*$/;
				var OK = re.exec(nome);  
				if(nome == "")
				{
					document.getElementById("idNome").style.border = "2px solid red";
					document.getElementById("valNome").innerHTML = "*";
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idNome").style.border = "2px solid red";
						document.getElementById("valNome").innerHTML = "Nome Inválido";
						return false;
					}
					else
					{
						document.getElementById("idNome").style.border = "1px solid green";
						document.getElementById("valNome").innerHTML = "";
						return true;
						
					}
				return true;
			}
			function validarFone()
				{
					var fone = form1.nameFone.value;
					var re = /^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/;
					var OK = re.exec(fone);
					if(fone == "")
					{
						document.getElementById("idFone").style.border = "2px solid red";
						document.getElementById("valFone").innerHTML = "*";
						return false;
					}
					if(!OK)
					{
						document.getElementById("idFone").style.border = "2px solid red";
						document.getElementById("valFone").innerHTML = "Telefone Inválido";
						return false;
					}
						else
						{
							document.getElementById("idFone").style.border = "1px solid green";
							document.getElementById("valFone").innerHTML = "";
							return true;
						}
					return true;
				}
				function validarCPF()
				{
					var cpf = form1.nameCPF.value;
					var re = /^\d{2,3}\.?\d{3}\.?\d{3}\-?\d{2}$/;
					var OK = re.exec(cpf);
					if(cpf == "")
					{
						document.getElementById("idCPF").style.border = "2px solid red";
						document.getElementById("valCPF").innerHTML = "*";
						return false;
					}
					if(!OK)
					{
						document.getElementById("idCPF").style.border = "2px solid red";
						document.getElementById("valCPF").innerHTML = "CPF Inválido";
						return false;
					}
						else
						{
							document.getElementById("idCPF").style.border = "1px solid green";
							document.getElementById("valCPF").innerHTML = "";
							return true;
						}
					return true;
				}
			function validarSenha()
			{
				var senha = form1.nameSenha.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]{6,12}$/;
				var OK = re.exec(senha);
				if(senha == "")
				{
					document.getElementById("idSenha").style.border = "2px solid red";
					document.getElementById("valSenha").innerHTML = "*";
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idSenha").style.border = "2px solid red";
						document.getElementById("valSenha").innerHTML = "Senha Inválida (A senha deve ter de 6 à 12 caracteres)";
						return false;
					}
					else
					{
						document.getElementById("idSenha").style.border = "1px solid green";
						document.getElementById("valSenha").innerHTML = "";
						return true;
					}
				return true;
			}
			function validarLogin()
			{
				var login = form1.nameLogin.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]{6,10}$/;
				var OK = re.exec(login);
				if(login == "")
				{
					document.getElementById("idLogin").style.border = "2px solid red";
					document.getElementById("valLogin").innerHTML = "*";
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idLogin").style.border = "2px solid red";
						document.getElementById("valLogin").innerHTML = "Login Inválido (O login deve ter de 6 à 10 caracteres)";
						return false;
					}
					else
					{
						document.getElementById("idLogin").style.border = "1px solid green";
						document.getElementById("valLogin").innerHTML = "";
						return true;
					}
				return true;
			}
			function validarCargo()
			{
				var cargo = form1.nameCargo.value;
				if(cargo == "")
				{
					document.getElementById("idCargo").style.border = "2px solid red";
					document.getElementById("valCargo").innerHTML = "*";
					return false;
				}
				else
				{
					document.getElementById("idCargo").style.border = "1px solid green";
					document.getElementById("valCargo").innerHTML = "";
					return true;
				}
				return true;
			}
			function validarGeral(){
				var erro = '';
				if (validarNome() == false) 
					erro = erro + 'O campo nome inválido.\n';
				if (validarCPF() == false) 
					erro = erro + 'O campo CPF inválido.\n';
				if (validarFone() == false) 
					erro = erro + 'O campo Telefone inválido.\n';
				if (validarCargo() == false) 
					erro = erro + 'O campo Cargo inválido.\n';
				if (validarLogin() == false) 
					erro = erro + 'O campo Login inválido.\n';
				if (validarSenha() == false) 
					erro = erro + 'O campo Senha inválido.\n';
				if(erro =='')
					return true;
				else{
					alert(erro);
					return false;
				}
				return false;
			}
				</script>
	<body >		
		<div id = 'titulo' class = 'titulo'>Novo Funcionário</div>		
		<form name="form2" id="form1" class="form" action="Tfuncionario.php" method="POST">
			<fieldset id="idColNome">
				<table>
					<input type="hidden" value='<?php echo $_GET['cod']; ?>' name="nameCod">
					<input type="hidden" value="3" name="flag">
					<tr> 
						<td><label for = "idNome">Nome Completo:</label></td>
						<td>
							<input onBlur = "return validarNome()" type = "text" value='<?php echo $nome ; ?>' name = "nameNome" id = "idNome" size = "25">
						</td>
						<td><div id = "valNome"></div></td>
					</tr>
					<tr> 
						<td><label for = "idFone">Telefone:</label></td>
						<td>
							<input class="fone" onBlur = "return validarFone()" type = "text" value='<?php echo $fone; ?>' name = "nameFone" id = "idFone" size = "15">
						</td>
						<td><div id = "valFone"></div></td>
					</tr>
					<tr> 
						<td><label for = "idCargo">Cargo:</label></td>
						<td>
							<?php
							if (isset($_POST['nameCargo'])) {
							
								if($_POST['nameCargo'] == "")
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = 'Caixa'> Caixa </option>
												<option  value = 'Cabeleireiro'> Cabeleireiro </option>
												<option  value = 'Administrador'> Administrador </option>
											</select>";
								else if ($_POST['nameCargo'] =='Caixa')
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option selected value = 'Caixa'> Caixa </option>
												<option  value = 'Cabeleireiro'> Cabeleireiro </option>
												<option  value = 'Administrador'> Administrador </option>
											</select>";
								else if ($_POST['nameCargo'] == 'Cabeleireiro')
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = 'Caixa'> Caixa </option>
												<option selected value = 'Cabeleireiro'> Cabeleireiro </option>
												<option  value = 'Administrador'> Administrador </option>
											</select>";
								else if ($_POST['nameCargo'] == 'Administrador')
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = 'Caixa'> Caixa </option>
												<option value = 'Cabeleireiro'> Cabeleireiro </option>
												<option selected value = 'Administrador'> Administrador </option>
											</select>";
						}
						else
							echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = 'Caixa'> Caixa </option>
												<option value = 'Cabeleireiro'> Cabeleireiro </option>
												<option value = 'Administrador'> Administrador </option>
											</select>";
					
						?>


						</td>
						<td><div id = "valCargo"></div></td>
					</tr>
					<tr> 
						<td><label for = "idCPF">CPF:</label></td>
						<td>
							<input class="CPF" onBlur = "return validarCPF()" type = "text" value='<?php echo $cpf; ?>' name = "nameCPF" id = "idCPF" size = "20">
						</td>
						<td><div id = "valCPF"></div></td>
					</tr>
					<tr> 
						<td><label for = "idLogin">Login:</label></td>
						<td>
							<input onBlur = "return validarLogin()" type = "text" value='<?php echo $login; ?>' name = "nameLogin" id = "idLogin" size = "20">
						</td>
						<td><div id = "valLogin"></div></td>
					</tr>
					<tr> 
						<td><label for = "idSenha">Senha:</label></td>
						<td>
							<input onBlur = "return validarSenha()" type = "password" value='123456' name = "nameSenha" id = "idSenha" size = "20">
						</td>
						<td><div id = "valSenha"></div></td>
					</tr>
					<tr> 
						<?php if($flag== '1')
								echo"<td colspan = '3'><input onClick = 'return validarGeral()' class='botao' type = 'submit' value = 'Salvar' name='BSfuncionario'/> </td>
						";
							else
								echo "<td colspan = '3'><input onClick = 'return validarGeral()' class='botao' type = 'submit' value = 'Enviar' name='BCfuncionario'/> </td>
						";							?>
						
						</form>
						<td> <a href='Tfuncionario.php' target='frame'><input class="botao" type = 'submit' value= 'Cancelar' name = 'cancelar'/></a>	</td>
					</tr>
				</table>
			</fieldset>
		
	</body>
</html>
