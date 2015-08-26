<?php
	include 'conectar.php';
  include 'funcoes.php';
  error_reporting(E_WARNING);
  if(!isset($_SESSION['permissao']))
      session_start();
    if($_SESSION['permissao'] <= 0 ){
      echo  "<div class='negada'>Permissão negada!</div> 
          <div class='negada'>É necessário efetuar login para acessar essa página... </div>
          <div class='negada'><a href='index.php'>Logar</a></div>";
      exit();
    }
  function Ccliente(){
    $conn     = conectar();
    $nome     = $_POST["nameNome"];
    $cpf      = $_POST["nameCPF"];
    $email    = $_POST["nameEmail"];
    $telefone = $_POST["nameFone"];
    $endereco = $_POST["nameEnd"];
    $data     = $_POST["nameData"];
    
    $sql = "SELECT f.cpf FROM cliente f WHERE cpf='$cpf'";
    $resultado = pg_query($sql);

    if(pg_fetch_array($resultado)){
      echo "<script>alert('Esse CPF já está cadastrado!')</script>";
      desconectar($conn);
      return false;
    }

    $sql = "INSERT INTO cliente VALUES";
    $sql .= "('$cpf','$nome', '$email', '$endereco', '$telefone',  '".dataToDate($data)."')";           
    $resultado = pg_query($sql);
    desconectar($conn);

  }
  function Scliente()
  {
     $conn = conectar();

    $cod      = $_POST["nameCod"];
    $nome     = $_POST["nameNome"];
    $cpf      = $_POST["nameCPF"];
    $email    = $_POST["nameEmail"];
    $telefone = $_POST["nameFone"];
    $endereco = $_POST["nameEnd"];
    $data     = $_POST["nameData"];
      
    if($cpf != $cod)
    {
      $sql = "SELECT f.cpf FROM cliente f WHERE cpf='$cpf'";
      $resultado = pg_query($sql);

      if(pg_fetch_array($resultado)){
        echo "<script>alert('Esse CPF já está cadastrado!')</script>";
        desconectar($conn);
        return false;
      }
    }
    $sql  = "UPDATE cliente SET ";
    $sql .= "cpf='$cpf', nome='$nome',email='$email',  
      endereco='$endereco', telefone='$telefone', dtnasc = '".dataToDate($data)."' where cpf='$cod'";
    $resultado = pg_query($sql);  
    desconectar($conn);
  }
  function Dcliente()
  {
    $cod = $_GET['cod'];
    $conn = conectar();

    $sql = "SELECT func FROM horario  WHERE cliente='$cod' limit 1";
    $resultado = pg_query($sql);
    $n = pg_fetch_array($resultado);
    if($n['func'] != ''){
     echo "<script>alert('Esse Cliente tem algum serviço marcado na agenda. Impossível Excluir!')</script>";
      desconectar($conn);
      return false;
    }

    $sql = "DELETE from cliente where cpf='$cod'";
    $resultado = pg_query($sql);
    desconectar($conn);
  }

  if(isset($_POST["BCcliente"])){
      Ccliente();
  }
  if(isset($_POST["BScliente"])){
      Scliente();

  }
  if(isset($_GET['op']))
    if($_GET["op"]== 3){
    Dcliente();
  }


	$conn = conectar();
	$query = "select * from cliente";
	$resultado = pg_query($query); // Executa a query $query na conexão $db
?>
  <html>
    <head>
      <meta charset="UTF-8"/>
      <link rel="stylesheet" type="text/css" href="style.css">
      <script src="jquery.js" type="text/javascript"></script>
    </head>

	<div id = 'titulo' class = 'titulo'>Clientes</div>
  <a href="Ccliente.php" target="frame"><input class='ab' type = 'submit' value= 'Novo Cliente' name = 'NewCliente'/></a>
    <div class='tabela'>
      <table class='table'>
        <tr class='alt'>
          <td>Nome</td>
          <td>CPF</td>
          <td>Email</td>
          <td>Telefone</td>
          <td>Endereço</td>
          <td>Data Nasc.</td>
          <td>Editar</td>
          <td>Excluir</td>
        </tr>
<?php
	while($linha = pg_fetch_array($resultado)) { 
		echo '<tr>
          <td>'.$linha['nome'].'</td>
          <td>'.$linha['cpf'].'</td>
          <td>'.$linha['email'].'</td>
          <td>'.$linha['telefone'].'</td>
          <td>'.$linha['endereco'].'</td>
          <td>'.dateToData($linha['dtnasc']).'</td>
          <td><a target=\'frame\' href="Ccliente.php?op=2&cod='.$linha['cpf'].'">Editar</a></td>
          <td><a target=\'frame\' href="Tcliente.php?op=3&cod='.$linha['cpf'].'" onclick="return confirm(\'Deseja realmente excluir esse cadastro?\')">Excluir</a></td>
      
       </tr>';

	}
	echo '</table></div>';
	desconectar($conn);
?>
</html>