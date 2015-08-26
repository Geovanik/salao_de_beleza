<?php
	include 'conectar.php';
   if(!isset($_SESSION['permissao']))
      session_start();
    if($_SESSION['permissao'] <= 0 ){
      echo  "<div class='negada'>Permissão negada!</div> 
          <div class='negada'>É necessário efetuar login para acessar essa página... </div>
          <div class='negada'><a href='index.php'>Logar</a></div>";
      exit();
    }

  function Cservico(){
      $conn = conectar();
      $descr    = $_POST["nameNome"];
      $valor    = $_POST["nameValor"];
      

      $sql = "INSERT INTO servico VALUES";
      $sql .= "(DEFAULT,'$descr', '$valor')";           
      $resultado = pg_query($sql);
      desconectar($conn);

  }

  function Sservico()
  {
      $conn = conectar();

      $cod      = $_POST["nameCod"];
      $nome     = $_POST["nameNome"];
      $valor    = $_POST["nameValor"];
      
      $sql  = "UPDATE servico SET ";
      $sql .= "cod='$cod', descr='$nome',valor='$valor' where cod='$cod'";
      $resultado = pg_query($sql);  
      desconectar($conn);
  }
  function Dservico()
  {
    $cod = $_GET['cod'];
    $conn = conectar();
    
    $sql = "SELECT func FROM horario  WHERE servico='$cod' limit 1";
    $resultado = pg_query($sql);
    $n = pg_fetch_array($resultado);
    if($n['func'] != ''){
     echo "<script>alert('Esse Serviço está marcado na agenda. Impossível Excluir!')</script>";
      desconectar($conn);
      return false;
    }
    $sql = "DELETE from servico where cod='$cod';";
    $resultado = pg_query($sql);
    desconectar($conn);
  }

  if(isset($_POST["BSservico"])){
      Sservico();
  }
  if(isset($_GET["op"]))
    if($_GET["op"]== 3){
      Dservico();
    }
  if(isset($_POST["BCservico"])){
      Cservico();
  }


	$conn = conectar();
	$query = "select * from servico";
	$resultado = pg_query($query); // Executa a query $query na conexão $db
?>
<html>
  <head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="colorbox.css">
    <script src="jquery.js" type="text/javascript"></script>
    <script src="jquery.colorbox.js" type="text/javascript"></script>
  </head>
<div id = 'titulo' class = 'titulo'>Serviços</div>
<a href="Cservico.php" target="frame"><input class='ab' type = 'submit' value= 'Novo Serviço' name = 'NewServico'/></a>
	<div class='tabela'>
    <table class='table'>
        <tr class='alt'>
          <td>Descrição</td>
          <td>Valor (R$)</td>
           <td>Editar</td>
          <td>Excluir</td>
        </tr>
<?php
	while($linha = pg_fetch_array($resultado)) { 
		echo '<tr>
          <td>'.$linha['descr'].'</td>
          <td>'.number_format($linha['valor'],2,',', '.').'</td>
          <td><a target=\'frame\' href="Cservico.php?op=2&cod='.$linha['cod'].'">Editar</a></td>
          <td><a target=\'frame\' href="Tservico.php?op=3&cod='.$linha['cod'].'" onclick="return confirm(\'Deseja realmente excluir esse cadastro?\')">Excluir</a></td>
      
       </tr>';

	}
	echo '</table></div>';
	desconectar($conn);
?>
</html>