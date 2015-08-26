<?php
  include 'conectar.php';
  error_reporting(E_WARNING);
  conectar();
  if(!isset($_SESSION['permissao']))
      session_start();
    if($_SESSION['permissao'] <= 0 ){
      echo  "<div class='negada'>PermissÃ£o negada!</div> 
          <div class='negada'>Ã‰ necessÃ¡rio efetuar login para acessar essa pÃ¡gina... </div>
          <div class='negada'><a href='index.php'>Logar</a></div>";
      exit();
    }

?>

<html>
<head>
  <meta charset="UTF-8"/>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div id = 'titulo' class = 'titulo'>Caixa do Dia</div>

<?php
$data = date("m/d/Y");
$dt = $data;
$caixa = $_SESSION['cod'];

$sql = "select
		  c.nome, 
		  s.descr, 
		  h.dt,
		  h.hora,
		  s.valor,
		  h.caixa
		from 
		  horario h, 
		  servico s,
		  cliente c
		where 
		  c.cpf=h.cliente and
		  s.cod=h.servico and
		  h.situacao='1' and
		  h.dt='$dt' and
		  h.caixa = '$caixa'";


$result = pg_query($sql);
$total=0;$k=0;
echo "<br><br><br>";
echo "<div class='tabela'>";
echo "<table border=1 class='table'>";
echo "<caption>Caixa:<b>$caixa</b>&nbsp;&nbsp;Data:<b>$dt</b></caption>";
echo "<tr><th width=50 align=center>No</td><th width=200 align=center>Cliente</td><th width=200 align=center>Serviço</td><th width=100 align=center>Valor</td></tr>";
$classe='background: #EEE';
while ($row = pg_fetch_assoc($result)) 
{
  $nome = $row['nome'];
  $descr = $row['descr'];
  $valor = $row['valor'];
  $total = $total + $valor;
  $k++;
  $valor=number_format($valor,2,',', '.');
  if($classe=='background: #EEE') $classe = 'background: #FFF'; else $classe='background: #EEE';
  echo "<tr style='$classe'><td  width=50 align=center>$k</td><td width=200 >$nome</td><td width=200 >$descr</td><td  width=100  align=right>$valor</td></tr>";
}
$total=number_format($total,2,',', '.');
echo "<tr> <td colspan=3></td><th align=right>$total</td></tr>";
echo "</table>";
echo '</div>';


?>
</body>
</html>