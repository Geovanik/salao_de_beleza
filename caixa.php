<html>
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<?php
	error_reporting(E_WARNING);

		include "conectar.php";
		include 'funcoes.php';
		$conn = conectar();

		if(!isset($_SESSION['permissao']))
			session_start();
		if($_SESSION['permissao'] <= 1 ){
			echo 	"<div class='negada'>Permissão negada!</div> 
					<div class='negada'>É necessário efetuar login para acessar essa página... </div>
					<div class='negada'><a href='index.php'>Logar</a></div>";
			exit();
		}

		$data 		= $_GET['data'];
		$hora		= $_GET['hora'];
		$codCli		= $_GET['cliente'];
		$codFunc	= $_GET['func'];

		function getDados($data,$hora,$codCli,$codFunc)
		{

			$sql = "SELECT servico FROM horario where  cliente ='".$codCli."' and dt='".dataToDate($data)."' and func='".$codFunc."' and hora=".$hora." limit 1";
	    	$resultado = pg_query($sql);
	    	$linha = pg_fetch_array($resultado);
	    	$sql = "SELECT descr,valor FROM servico where  cod = '".$linha['servico']."' limit 1";
	    	$resultado1 = pg_query($sql);
	    	$linha1 = pg_fetch_array($resultado1);


	    	$resp = "Serviço a ser pago: ".$linha1['descr']."<br>Valor a ser pago: R$ ".$linha1['valor'];
			
			$sql = "SELECT nome FROM cliente where  cpf = '".$codCli."' limit 1";
	    	$resultado1 = pg_query($sql);
	    	$linha1 = pg_fetch_array($resultado1);

	    	$resp.= "<br>Cliente: ".$linha1['nome'];
	    	return $resp;

		}
	?>
	<body >		
		<div id = 'titulo' class = 'titulo'>Pagamento</div>	
		<div class = "tabela">
			<fieldset id = "idColNome1">	
				<?php echo getDados($data,$hora,$codCli,$codFunc); ?>
				<br>
				<form method = "POST" action = "agenda.php">
					<input type="hidden" value="<?php echo $hora; ?>" name="hora">
					<input type="hidden" value="<?php echo $data; ?>" name="data">
					<input type="hidden" value="<?php echo $codFunc; ?>" name="func">
					<input type="hidden" value="<?php echo $codCli; ?>" name="cliente">
				
				<?php 	
					echo '<a target = "frame" href="agenda.php" ><input type = "submit" value= "Confirmar" name = "pagamento"/></a>';
					echo '<a href="agenda.php" target= "frame" ><input type = "submit" value= "Cancelar" name = "cancelar"/></a>';
				?>	
				</form>
			</fieldset>
		</div>
	</body>
</html>
<?php   
	desconectar($conn); 
?>
