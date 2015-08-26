<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta charset="UTF-8"/>
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.maskedinput.js" type="text/javascript"></script>
		<script src="jquery.colorbox.js" type="text/javascript"></script>
		<script language= "JavaScript" type = "text/JavaScript" >

		function validarNome()
		{ 
			var nome = form.nameNome.value;
			if(nome == "")
			{
				document.getElementById("idNome").style.border = "2px solid red";
				document.getElementById("valNome").innerHTML = "*";
				return false;
			}
			return true;
		}
		function validarValor()
		{ 
			var valor = form.nameValor.value;
			if(valor == "")
			{
				document.getElementById("idValor").style.border = "2px solid red";
				document.getElementById("valValor").innerHTML = "*";
				return false;
			}
			return true;
		}
		function validarGeral(){
				var erro = '';
				if (validarNome() == false) 
					erro = erro + 'O campo Descrição inválido.\n';
				if (validarValor() == false) 
					erro = erro + 'O campo Valor inválido.\n';
				if(erro =='')
					return true;
				else{
					alert(erro);
					return false;
				}
				return false;
			}
	</script>
	</head>
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

		$descr = '';
		$valor = '';
		$flag = '0';

		if(isset($_GET['op']))
			if($_GET['op']== 2){
					editar();
					$descr = $_POST['descr'];
					$valor = $_POST['valor'];
					$flag = '1';
			}

	function editar()
	{
		$conn = conectar();
		$cod = $_GET['cod'];
		$sql = "SELECT * FROM servico WHERE cod = '$cod'";
		$sql2 = pg_query($sql) or die("Erro na consulta!");

		$n = pg_fetch_array($sql2);

		$_POST['descr'] 	= $n['descr'];
		$_POST['valor'] 	= $n['valor'];
		desconectar($conn);

	}
	?>
	<body >		
		<div id = 'titulo' class = 'titulo'>Novo Serviço</div>		
		<form name="form2" id="form" class="form" action="Tservico.php" method="POST">
			<input type="hidden" value="<?php echo $_GET['cod']; ?>" name="nameCod">
	
			<fieldset id="idColNome">
				<table>
					<tr> 
						<td><label for = "idNome">Descrição:</label></td>
						<td>
							<input onBlur = "return validarNome()" type = "text" value='<?php echo $descr; ?>' name = "nameNome" id = "idNome" size = "25">
						</td>
						<td><div id = "valNome"></div></td>
					</tr>
					<tr> 
						<td><label for = "idValor">Valor:</label></td>
						<td>
							<input onBlur = "return validarValor()" type = "text" value='<?php echo $valor; ?>' name = "nameValor" id = "idValor" size = "15">
						</td>
						<td><div id = "valValor"></div></td>
					</tr>
					<tr> 
						<?php if($flag== '1')
								echo"<td colspan = '3'><input onClick = 'return validarGeral();' type = 'submit' value = 'Salvar' name='BSservico'/> </td>
						";
							else
								echo "<td colspan = '3'><input onClick = 'return validarGeral();' type = 'submit' value = 'Enviar' name='BCservico'/> </td>
						";	
						?>
						</form>
						<td> <a href='Tservico.php' target='frame'><input type = 'submit' value= 'Cancelar' name = 'cancelar'/></a>	</td>
					</tr>
				</table>
			</fieldset>
		
	</body>
</html>
