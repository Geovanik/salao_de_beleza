<html>
    <head>
      <meta charset="UTF-8"/>
      <link rel="stylesheet" type="text/css" href="style.css">
      <script src="jquery.js" type="text/javascript"></script>
      <script src="jquery.maskedinput.js" type="text/javascript"></script>
  <script language= "JavaScript" type = "text/JavaScript" >
      function validarData()
      {
        var data = form1.pesquisa.value;
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
      
      </script>
    <script type="text/javascript">  
    jQuery(function($){
      jQuery.noConflict();
      $("#idData").mask("99/99/9999",{placeholder:" "});
      
    });
    </script>
    </head>
<?php
error_reporting(E_WARNING);
	include "conectar.php";
  include "funcoes.php";
	if(!isset($_SESSION['permissao']))
		session_start();
	if($_SESSION['permissao'] <= 0 ){
		echo 	"<div class='negada'>Permissão negada!</div> 
				<div class='negada'>É necessário efetuar login para acessar essa página... </div>
				<div class='negada'><a href='index.php'>Logar</a></div>";
		exit();
	}
  function Cpagamento()
  {
      $conn      = conectar();
      $hora      = $_POST["hora"];
      $data      = $_POST["data"];
      $cliente   = $_POST["cliente"];
      $func      = $_POST["func"];
      $sql  = "UPDATE horario SET ";
      $sql .= "situacao= 1 where hora='$hora' and dt='".dataToDate($data)."' and cliente='$cliente' and func='$func' ";
      $resultado = pg_query($sql);  
      desconectar($conn);
  }

  function existeOP3()
  {
    global $_GET;
    if (isset($_GET['op']))
    {
      if($_GET['op'] == 3)
        return true;
      else
        return false;
    }else
      return false;
  }

	function select($data){
    global $_GET;
    global $_POST;
		$count = 0;    
    $conn = conectar();
		$sql = "SELECT nome, cpf FROM funcionario where cargo='Cabeleireiro'";
  		$resultado = pg_query($sql);

  		while($linha = pg_fetch_array($resultado)){
  		
  			echo "<tr><td>".$linha['nome']."</td>";
  			while ( $count <= 16) {
    			$sql = "SELECT cliente FROM horario where dt='".dataToDate($data)."' and func='".$linha['cpf']."' and hora=".$count." limit 1";
	    		$resultado1 = pg_query($sql);
	    		if($linha1 = pg_fetch_array($resultado1)){
    				echo "<td>
              <a 
                href='agenda.php?op=3&data=".$data."&hora=".$count."&func=".$linha['cpf']."&cliente=".$linha1['cliente']."' 
                target='frame' 
                onclick='return confirm(\"Deseja realmente excluir esse cadastro?\")'><img src = 'excluir.png'>
              </a>";
              $sql = "SELECT situacao FROM horario where cliente = '".$linha1['cliente']."' and dt='".dataToDate($data)."' and func='".$linha['cpf']."' and hora=".$count." limit 1";
              $resultado2 = pg_query($sql);
              $linha2 = pg_fetch_array($resultado2);
              if($linha2['situacao'] == 0){         
                echo "
                  <a href='caixa.php?&data=".$data."&hora=".$count."&func=".$linha['cpf']."&cliente=".$linha1['cliente']."' 
                    target='frame' ><img src = 'moeda.png' width=18 height= 18;>
                  </a>";
              }
              else
                echo "<img src = 'ok.png' width=18 height= 18>";
              echo "</td>";
    			}else
    				echo "<td><a href='Cagenda.php?data=".$data."&hora=".$count."&func=".$linha['cpf']."' target='frame'><img src='edtar.png' width=18 height= 30></a></td>";
	 			$count = $count + 1;
	    	}
        $count = 0;
	    	echo "</tr>";
  		}
	desconectar($conn); 
  }


 function Cagenda(){
    $conn     = conectar();
    $cliente  = $_POST["nameCliente"];
    $servico  = $_POST["nameServico"];
    $func     = $_POST["nameFunc"];
    $data 	  = $_POST["nameData"];
    $hora     = $_POST["nameHora"];
    $caixa    = $_POST["nameCaixa"];
    $situacao = $_POST["nameSit"];

    $sql = "INSERT INTO horario VALUES";
    $sql .= "('".dataToDate($data)."','$hora','$caixa', '$cliente', '$func', '$servico', '$situacao')";           
    $resultado = pg_query($sql);
    desconectar($conn);

  }
  
  function Dagenda()
  {
    $cliente = $_GET['cliente'];
    $hora = $_GET['hora'];
    $data = $_GET['data'];
    $func = $_GET['func'];
    $conn = conectar();

    $sql = "DELETE from horario where cliente='$cliente' and hora='$hora' and func='$func' and dt='".dataToDate($data)."'";
    $resultado = pg_query($sql);
    desconectar($conn);
  }
  if(isset($_POST["BCagenda"])){
      Cagenda();
  }
  if(isset($_GET["op"]))
    if($_GET["op"] == 3){
      Dagenda();
    }
	$data = '';
  if(isset($_POST['buscar']))
   $data = $_POST['pesquisa'];
  if(existeOP3())
    $data = $_GET['data'];
  if(isset($_POST['BCagenda']))
    $data = $_POST['nameData'];
  if(isset($_POST['cancelar']))
    $data = $_POST['data'];  
  if(isset($_POST['pagamento'])){
    $data = $_POST['data']; 
    Cpagamento();
  }
  if ($data == '')
    $data = date("d/m/Y")
?>
<body>
  <!--  -->
<?php include "calendario.php";?>
  <!--  -->
	  <div id = 'titulo' class = 'titulo'>Agenda <?php echo $data; ?></div>
	  <form method="POST" name="form1">
	  	<a href="agenda.php" target="frame">
	    	<input class='ab' type = 'submit' value= 'Buscar' onClick = "return validarData()" name = 'buscar'/>
	    </a>
	    <input id = "idData" onclick="ds_sh(this);" style="cursor: text" class="ab" type="text" size="30" value="" name="pesquisa">
	     <div id = "valData" class="ab"></div>
      </form>
    <div class='tabela'>
      <table class='table'>
        <tr class='alt'>
          <td>Nome</td>
          <td>07:30</td>
          <td>08:00</td>
          <td>08:30</td>
          <td>09:00</td>
          <td>09:30</td>
          <td>10:00</td>
          <td>10:30</td>
          <td>11:00</td>
          <td>11:30</td>
          <td>13:30</td>
          <td>14:00</td>
          <td>14:30</td>
          <td>15:00</td>
          <td>15:30</td>
          <td>16:00</td>
          <td>16:30</td>
          <td>17:00</td>
        
	   			</tr>
			    <?php
			    	select($data);
			    ?>
			</tabela>
		</div>
	</body>
</html>


