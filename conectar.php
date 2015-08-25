<?php
	function conectar(){
		$server ="localhost";
		$banco  ="salao"; 
		$porta  ="5432";
		$user   ="postgres";     
		$senha  ="postgres";

		$string = "host=$server port=$porta dbname=$banco user=$user password=$senha";
		$connect = pg_connect($string);

		if(!$connect)
			die("Erro na Conexão com o banco de dados!");
		return $connect;
	}
	function desconectar($conn){
		 pg_close($conn);
	}
	function sair()
	{
		session_start();
		$_SESSION['usuario']=0;
		$_SESSION['permissao']=0;
		header("location:index.php");
		exit();
	}
?>