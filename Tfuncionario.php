<?php
	include 'conectar.php';
  error_reporting(E_WARNING);
  if(!isset($_SESSION['permissao']))
      session_start();
    if($_SESSION['permissao'] <= 0 ){
      echo  "<div class='negada'>Permissão negada!</div> 
          <div class='negada'>É necessário efetuar login para acessar essa página... </div>
          <div class='negada'><a href='index.php'>Logar</a></div>";
      exit();
    }

 function Cfuncionario(){
    $conn     = conectar();
    $nome     = $_POST["nameNome"];
    $cpf      = $_POST["nameCPF"];
    $login    = $_POST["nameLogin"];
    $telefone = $_POST["nameFone"];
    $senha    = $_POST["nameSenha"];
    $cargo    = $_POST["nameCargo"];
    
    $sql = "SELECT f.cpf FROM funcionario f WHERE cpf='$cpf'";
    $resultado = pg_query($sql);

    if(pg_fetch_array($resultado)){
      echo "<script>alert('Esse CPF já está cadastrado!')</script>";
      desconectar($conn);
      return false;
    }

    $sql = "INSERT INTO funcionario VALUES";
    $sql .= "('$cpf','$cargo','$nome', '$login', '$senha', '$telefone')";           
    $resultado = pg_query($sql);
    desconectar($conn);

  }
  function Sfuncionario()
  {
      $conn = conectar();

      $cod      = $_POST["nameCod"];
      $nome     = $_POST["nameNome"];
      $cpf      = $_POST["nameCPF"];
      $login    = $_POST["nameLogin"];
      $senha    = $_POST["nameSenha"];
      $telefone = $_POST["nameFone"];
      //$senha    = md5($senha);
      $cargo    = $_POST["nameCargo"];
      
      if($cpf != $cod)
      {
        $sql = "SELECT f.cpf FROM funcionario f WHERE cpf='$cpf'";
        $resultado = pg_query($sql);

        if(pg_fetch_array($resultado)){
          echo "<script>alert('Esse CPF já está cadastrado!')</script>";
          desconectar($conn);
          return false;
        }
      }
      $sql  = "UPDATE funcionario SET ";
      $sql .= "cpf='$cpf',cargo='$cargo', nome='$nome',login='$login',  
        senha='$senha',  fone='$telefone' where cpf='$cod'";
        $resultado = pg_query($sql);  
      desconectar($conn);
  }
  function Dfuncionario()
  {
    $cod = $_GET['cod'];
    $conn = conectar();
    $sql = "SELECT func FROM horario  WHERE func='$cod' or caixa ='$cod'   limit 1";
    $resultado = pg_query($sql);
    $n = pg_fetch_array($resultado);
    if($n['func'] != ''){
     echo "<script>alert('Esse Funcionário tem algum serviço marcado na agenda. Impossível Excluir!')</script>";
      desconectar($conn);
      return false;
    }
    $sql = "DELETE from funcionario where cpf='$cod';";
    $resultado1 = pg_query($sql);
    desconectar($conn);
  }


  if(isset($_POST["BCfuncionario"])){
      Cfuncionario();
  }
  if(isset($_POST["BSfuncionario"])){
      Sfuncionario();

  }
  if(isset($_GET['op']))
    if($_GET["op"]== 3){
      Dfuncionario();
    }
 
    
	$conn = conectar();
	$query = "select * from funcionario";
	$resultado = pg_query($query); // Executa a query $query na conexão $db
?>
<html>
    <head>
      <meta charset="UTF-8"/>
      <link rel="stylesheet" type="text/css" href="style.css">
      <script src="jquery.js" type="text/javascript"></script>

    </head>

<body>
  <div id = 'titulo' class = 'titulo'>Funcionários</div>
  <?php if($_SESSION['permissao'] >= 2 ){  ?>
    <a href="Cfuncionario.php?op=1" target="frame"><input class='ab' type = 'submit' value= 'Novo Funcionário' name = 'NewFuncionario'/></a>
    <?php } ?>
    <div class='tabela'>
      <table class='table'>
        <tr class='alt'>
          <td>Nome</td>
          <td>CPF</td>
          <td>Cargo</td>
          <td>Telefone</td>
          <td>Login</td>
          <td>Editar</td>
          <td>Excluir</td>
        </tr>

<?php
	while($linha = pg_fetch_array($resultado)) { 
		echo '<tr>
          <td>'.$linha['nome'].'</td>
          <td>'.$linha['cpf'].'</td>
          <td>'.$linha['cargo'].'</td>
          <td>'.$linha['fone'].'</td>
          <td>'.$linha['login'].'</td>
          <td><a target=\'frame\' href="Cfuncionario.php?op=2&cod='.$linha['cpf'].'">Editar</a></td>
          <td><a target=\'frame\' href="Tfuncionario.php?op=3&cod='.$linha['cpf'].'" onclick="return confirm(\'Deseja realmente excluir esse cadastro?\')">Excluir</a></td>
      
       </tr>';

	}
	echo '</table></div>';
	desconectar($conn);
?>
</body>
</html>