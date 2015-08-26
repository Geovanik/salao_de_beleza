<html>
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script language= "JavaScript" type = "text/JavaScript" >

		function validarCli()
		{ 
			var nome = form.nameCliente.value;
			if(nome == "")
			{
				document.getElementById("idCliente").style.border = "2px solid red";
				document.getElementById("valCliente").innerHTML = "*";
				return false;
			}
			return true;
		}
		function validarSer()
		{ 
			var nome = form.nameServico.value;
			if(nome == "")
			{
				document.getElementById("idServico").style.border = "2px solid red";
				document.getElementById("valSer").innerHTML = "*";
				return false;
			}
			return true;
		}
		function validarSit()
		{ 
			var nome = form.nameSit.value;
			if(nome == "")
			{
				document.getElementById("idSit").style.border = "2px solid red";
				document.getElementById("valSit").innerHTML = "*";
				return false;
			}
			return true;
		}
		function validarGeral(){
				var erro = '';
				if (validarCli() == false) 
					erro = erro + 'O campo Cliente inválido.\n';
				if (validarSer() == false) 
					erro = erro + 'O campo Serviço inválido.\n';
				if (validarSit() == false) 
					erro = erro + 'O campo Situação inválido.\n';
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
	error_reporting(E_WARNING);

		include "conectar.php";
		include 'funcoes.php';
		$conn = conectar();

		if(!isset($_SESSION['permissao']))
			session_start();
		if($_SESSION['permissao'] <= 0 ){
			echo 	"<div class='negada'>Permissão negada!</div> 
					<div class='negada'>É necessário efetuar login para acessar essa página... </div>
					<div class='negada'><a href='index.php'>Logar</a></div>";
			exit();
		}
	?>
	<body >		
		<div id = 'titulo' class = 'titulo'>Novo Horário</div>		
		<form name="form" id="form2" class="form" action="agenda.php" method="POST">
			<fieldset id="idColNome">
				<table>
					<input type="hidden" value="<?php echo $_GET['hora']; ?>" name="nameHora">
					<input type="hidden" value="<?php echo $_GET['data']; ?>" name="nameData">
					<input type="hidden" value="<?php echo $_GET['func']; ?>" name="nameFunc">
					<input type="hidden" value="<?php echo $_SESSION['cod']; ?>" name="nameCaixa">
					<tr> 
						<td><label for = "idCliente">Cliente:</label></td>
						<td>
							<select onBlur = "return validarCli();"class="cliente" name = "nameCliente" id = "idCliente">
								<option value=''>----------</option>
								<?php echo getClientesOptions();?>
							</select>
						</td>
						<td><div id = "valCliente"></div></td>
					</tr>
					<tr> 
						<td><label for = "idServico">Serviço:</label></td>
						<td>
							
							<select onBlur = "return validarSer();"class="servico" name = "nameServico" id = "idServico">
								<option value=''>----------</option>
								<?php echo getServicosOptions();?>
							</select>

						</td>
						<td><div id = "valSer"></div></td>
					</tr>
					<tr> 
						<td><label for = "idSit">Situação:</label></td>
						<td>
							<input id= "idSit" type="radio" name="nameSit" value="0" CHECKED> Não Pago<br>
							<input id= "idSit" type="radio" name="nameSit" value="1"> Pago<br>
						</td>
						<td><div id = "valSit"></div></td>
					</tr>
					<tr> 
						<td colspan = '3'><input onClick = "return validarGeral();"class="ab" type = 'submit' value = 'Enviar' name='BCagenda'/></td>
		</form>
						<td> <a href='agenda.php' target='frame'><input class="ab" type = 'submit' value= 'Cancelar' name = 'cancelar'/></a>	</td>
					</tr>
				</table>
			</fieldset>
	</body>
</html>
<?php   
	desconectar($conn); 
?>
