<?php
	include 'conectar.php';
	include 'funcoes.php';
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
<html>
	<head>
	
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.maskedinput.js" type="text/javascript"></script>
	<script language= "JavaScript" type = "text/JavaScript" >
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
			function validarEnd()
			{
				var end = form1.nameEnd.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+(\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+)*$/;
				var OK = re.exec(end);
				if(end == "")
				{
					document.getElementById("idEnd").style.border = "2px solid red";
					document.getElementById("valEnd").innerHTML = "*";
					return false;
				}
				if(!OK)
				{
					document.getElementById("idEnd").style.border = "2px solid red";
					document.getElementById("valEnd").innerHTML = "Endereço Inválido";
					return false;
				}
					else
					{
						document.getElementById("idEnd").style.border = "1px solid green";
						document.getElementById("valEnd").innerHTML = "";
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
			function validarEmail()
			{
				var email = form1.nameEmail.value;
				var re = /^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/;
				var OK = re.exec(email);
				if(email == "")
				{
					document.getElementById("idEmail").style.border = "2px solid red";
					document.getElementById("valEmail").innerHTML = "*";
					return false;
				}
				if(!OK)
				{
					document.getElementById("idEmail").style.border = "2px solid red";
					document.getElementById("valEmail").innerHTML = "E-mail Inválido";
					return false;
				}
					else
					{
						document.getElementById("idEmail").style.border = "1px solid green";
						document.getElementById("valEmail").innerHTML = "";
						return true;
					}
				return true;
			}
			function validarData()
			{
				var data = form1.nameData.value;
				var re = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[12][0-9]{3}$/;
				var OK = re.exec(data);
				if(data == "")
				{
					document.getElementById("idData").style.border = "2px solid red";
					document.getElementById("valData").innerHTML = "*";
					return false;
				}
				if(!OK)
				{
					document.getElementById("idData").style.border = "2px solid red";
					document.getElementById("valData").innerHTML = "Data Inválida";
					return false;
				}
					else
					{
						document.getElementById("idData").style.border = "1px solid green";
						document.getElementById("valData").innerHTML = "";
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
				if (validarEnd() == false) 
					erro = erro + 'O campo Endereço inválido.\n';
				if (validarFone() == false) 
					erro = erro + 'O campo Telefone inválido.\n';
				if (validarData() == false) 
					erro = erro + 'O campo Data inválido.\n';
				if (validarEmail() == false) 
					erro = erro + 'O campo E-mail inválido.\n';
				if(erro =='')
					return true;
				else{
					alert(erro);
					return false;
				}
				return false;
			}
			
			</script>
		<script type="text/javascript">  
		jQuery(function($){
			jQuery.noConflict();
			$("#idCPF").mask("999.999.999-99",{placeholder:" "});
			$("#idFone").mask("(99) 9999-9999",{placeholder:" "});
			$("#idData").mask("99/99/9999",{placeholder:" "});
			
		});
		</script>
	</head>

	<?php
		
		$nome = '';
		$fone = '';
		$cpf = '';
		$end = '';
		$email = '';
		$data = '';
		$flag = '0';

		if(isset($_GET['op'])){
	    	if($_GET['op']== 2){
				editar();
				$nome = $_POST['nome'];
				$fone = $_POST['fone'];
				$cpf = $_POST['cpf'];
				$end = $_POST['end'];
				$email = $_POST['email'];
				$data = $_POST['data'];
				$flag = '1';
				$data = dateToData($data);
			}
		}

	function editar()
	{
		$conn = conectar();
		$cod = $_GET['cod'];
		$sql = "SELECT * FROM cliente WHERE cpf = '$cod'";
		$sql2 = pg_query($sql) or die("Erro na consulta!");

		$n = pg_fetch_array($sql2);

		$_POST['nome'] 		= $n['nome'];
		$_POST["cpf"] 		= $n['cpf'];
		$_POST["data"] 		= $n['dtnasc'];
		$_POST["email"] 	= $n['email'];
		$_POST["fone"]		= $n['telefone'];
		$_POST["end"]		= $n['endereco'];
		desconectar($conn);

	}
	?>
	<body >		
		<div id = 'titulo' class = 'titulo'>Novo Cliente</div>		
		<form name="form2" id="form1" class="form" action="Tcliente.php" method="POST">
			<fieldset id="idColNome">
				<table>
					<input type="hidden" value="<?php echo $_GET['cod']; ?>" name="nameCod">
					<input type="hidden" value="1" name="flag">
					<tr> 
						<td><label for = "idNome">Nome Completo:</label></td>
						<td>
							<input onBlur = "return validarNome()" type = "text" value='<?php echo $nome; ?>' name = "nameNome" id = "idNome" size = "25">
						</td>
						<td><div id = "valNome"></div></td>
					</tr>
					<tr> 
						<td><label for = "idFone">Telefone:</label></td>
						<td>
							<input onBlur = "return validarFone()" type = "text" value='<?php echo $fone; ?>' name = "nameFone" id = "idFone" size = "15">
						</td>
						<td><div id = "valFone"></div></td>
					</tr>
					<tr> 
						<td><label for = "idEnd">Endereço:</label></td>
						<td>
							<input onBlur = "return validarEnd()" type = "text" value='<?php echo $end; ?>' name = "nameEnd" id = "idEnd" size = "40">
						</td>
						<td><div id = "valEnd"></div></td>
					</tr>
					<tr> 
						<td><label for = "idCPF">CPF:</label></td>
						<td>
							<input onBlur = "return validarCPF()" type = "text" value='<?php echo $cpf; ?>' name = "nameCPF" id = "idCPF" size = "20">
						</td>
						<td><div id = "valCPF"></div></td>
					</tr>
					<tr> 
						<td><label for = "idEmail">E-mail:</label></td>
						<td>
							<input onBlur = "return validarEmail()" type = "text" value='<?php echo $email; ?>' name = "nameEmail" id = "idEmail" size = "20">
						</td>
						<td><div id = "valEmail"></div></td>
					</tr>
					<tr> 
						<td><label for = "idData">Data Nascimento:</label></td>
						<td>
							<input onBlur = "return validarData()" type = "text" value='<?php echo $data; ?>' name = "nameData" id = "idData" size = "20">
						</td>
						<td><div id = "valData"></div></td>
					</tr>
					<tr> 
						<?php 
						if($flag == '1')
								echo"<td colspan = '3'><input onClick = 'return validarGeral()' type = 'submit' value = 'Salvar' name='BScliente'/> </td>
						";
							else
								echo "<td colspan = '3'><input onClick = 'return validarGeral()' type = 'submit' value = 'Enviar' name='BCcliente'/> </td>
						";							
						?>
						
						</form>
						<td> <a href='Tcliente.php' target='frame'><input type = 'submit' value= 'Cancelar' name = 'cancelar'/></a>	</td>
					</tr>
				</table>
			</fieldset>
		
	</body>
</html>
