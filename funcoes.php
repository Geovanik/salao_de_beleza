<?php
error_reporting(E_WARNING);
function getClientesOptions()
{
	$resp="";
	$sql="select * from cliente order by nome";
	$resultado 	= pg_query($sql);
	while($linha = pg_fetch_assoc($resultado))
	{
		$cpf	=	$linha['cpf'];
		$nome	=	$linha['nome'];
		$resp	= 	$resp."<option value='$cpf'>$nome</option>";
	}
	return $resp;
}


function getServicosOptions()
{
	$resp="";
	$sql="select * from servico order by descr";
	$resultado 	= pg_query($sql);
	while($linha = pg_fetch_assoc($resultado))
	{
		$cod	=	$linha['cod'];
		$descr	=	$linha['descr'];
		$resp	= 	$resp."<option value='$cod'>$descr</option>";
	}
	return $resp;
}

function dataToDate($data)
{
	$vet = explode("/", $data);
	$dia = $vet[0];
	$ano = $vet[2];
	$mes = $vet[1];

	return "$mes/$dia/$ano";
}
function dateToData($date)
{
	$vet = explode("-", $date);
	$dia = $vet[2];
	$ano = $vet[0];
	$mes = $vet[1];

	return "$dia/$mes/$ano";

}

?>