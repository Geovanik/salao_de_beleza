<html>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css">
	<?php
			session_start();
			include 'conectar.php';
			$per = $_SESSION['permissao'];
			$user = $_SESSION['usuario'];
			$cod = $_SESSION['cod'];
		
			$_POST['nome'] 		= "";
			$_POST["cpf"] 		= "";
			$_POST["email"] 	= "";
			$_POST["login"] 	= "";
			$_POST["senha"] 	= "";
			$_POST["cargo"] 	= "";
			$_POST["sexo"] 		= "";
			$_POST["fone"]		= "";
			$_POST["end"] 		= "";
			$_POST["estado"]	= "";
			$_POST["cidade"] 	= "";

			if($per <= 0 ){
				echo 	"<div class='negada'>Permissão negada!</div> 
						<div class='negada'>É necessário efetuar login para acessar essa página... </div>
						<div class='negada'><a href='index.php'>Logar</a></div>";
				exit();
			}
			else 
				if($per < 3)
				{
					$conn = conectar();
					preencheForm($cod);
				}

		if(isset($_POST["botao"])) //Quando clicar em enserir
			inserir();
		if(isset($_POST["sair"])) //Quando clicar em sair
			sair();
		if(isset($_POST["editar"])) //Quando clicar em atualizar
			editar();
		if(isset($_POST["cancelar"])) //Quando clicar em cancelar atualização
			limpaForm();

		if(isset($_GET["op"])){ 

			if(isset($_GET["cod"]) && $_GET["op"] == 2){ //Opção de editar, 
				preencheForm($_GET["cod"]);	//Joga cadastro no form
				$op=0;
			}
			else if(isset($_GET["cod"]) && $_GET["op"] == 3){ //Opção de excluir, 
				excluir($_GET["cod"]);	
				$op=0;
			}
			else
				$cod = 0;	
		}else{ //se não existir a opção, ela é criada pra quando ser usada existir
		
			$op = 0;
		}
		function preencheForm($cod){
			$conn = conectar();
			$sql = "SELECT * FROM funcionario WHERE idfuncionario = '$cod'";
			$sql2 = pg_query($sql) or die("Erro na consulta!");

			$n = pg_fetch_array($sql2);

			$_POST['nome'] 		= $n['nomef'];
			$_POST["cpf"] 		= $n['cfp'];
			$_POST["email"] 	= $n['email'];
			$_POST["login"] 	= $n['login'];
			$_POST["senha"] 	= "";
			$_POST["cargo"] 	= $n['cargo'];
			$_POST["sexo"] 		= $n['sexo'];
			$_POST["fone"]		= $n['telefone'];
			$_POST["end"] 		= $n['endereco'];
			$_POST["estado"]	= $n['estado'];
			$_POST["cidade"] 	= $n['cidade'];
			$_POST['cod'] 		= $n['idfuncionario'];
			desconectar($conn);
		}
		function editar(){
			$conn = conectar();

			$nome 		= $_POST["nameNome"];
			$cpf 		= $_POST["nameCPF"];
			$email		= $_POST["nameEmail"];
			$login 		= $_POST["nameLogin"];
			$senha 		= $_POST["nameSenha"];
			$sexo 		= $_POST["nameSexo"];
			$telefone 	= $_POST["nameFone"];
			$endereco 	= $_POST["nameEnd"];
			$estado 	= $_POST["nameEstado"];
			$cidade 	= $_POST["nameCid"];
			$cod		= $_POST["nameCod"];
			

			
			if($_SESSION['permissao'] < 3){
				$sql = "SELECT f.cfp FROM funcionario f WHERE cfp='$cpf' AND idfuncionario !='$cpf'";
				$resultado = pg_query($sql);

				if(pg_fetch_array($resultado)){
					echo "<script>alert('Esse CPF já está cadastrado!')</script>";
					desconectar($conn);
					$_POST["editar"] = -1;
					return false;
				}

				$sql = "UPDATE funcionario SET";
				$sql .= " idfuncionario='$cod',nomef='$nome',cfp='$cpf', email='$email', login='$login', 
					senha='$senha', sexo='$sexo', telefone='$telefone', endereco='$endereco', 
					estado='$estado', cidade='$cidade' where idfuncionario='$cod'";
				$resultado = pg_query($sql);
				header("location:cadastro.php");	
			}

			else{
			
				$sql = "SELECT f.cfp FROM funcionario f WHERE cfp='$cpf' AND idfuncionario !='$cpf'";
				$resultado = pg_query($sql);

				if(pg_fetch_array($resultado)){
					echo "<script>alert('Esse CPF já está cadastrado!')</script>";
					desconectar($conn);
					$_POST["ediatr"] = -1;
					return false;
				}
					
				$cargo 		= $_POST["nameCargo"];
				$sql = "UPDATE funcionario SET";
				$sql .= " idfuncionario='$cod',nomef='$nome',cfp='$cpf', email='$email', login='$login', 
					senha='$senha', cargo='$cargo', sexo='$sexo', telefone='$telefone', endereco='$endereco', 
					estado='$estado', cidade='$cidade' where idfuncionario='$cod'";
				$resultado = pg_query($sql);	
			}	
			desconectar($conn);
		}

		function inserir(){
			$conn = conectar();
			
			$nome 		= $_POST["nameNome"];
			$cpf 		= $_POST["nameCPF"];
			$email		= $_POST["nameEmail"];
			$login 		= $_POST["nameLogin"];
			$senha 		= $_POST["nameSenha"];
			$cargo 		= $_POST["nameCargo"];
			$sexo 		= $_POST["nameSexo"];
			$telefone 	= $_POST["nameFone"];
			$endereco 	= $_POST["nameEnd"];
			$estado 	= $_POST["nameEstado"];
			$cidade 	= $_POST["nameCid"];
			$senha 		= md5($senha);
			
			$sql = "SELECT f.cfp FROM funcionario f WHERE cfp='$cpf'";
			$resultado = pg_query($sql);

			if(pg_fetch_array($resultado)){
				echo "<script>alert('Esse CPF já está cadastrado!')</script>";
				desconectar($conn);
				$_POST["botao"]=-1;
				return false;
			}

			$sql = "INSERT INTO funcionario VALUES";
			$sql .= "('$cpf','$nome','$cpf', '$email', '$login', '$senha', '$cargo', '$sexo', '$telefone', '$endereco', '$estado', '$cidade')";							//editando
			$resultado = pg_query($sql);

		}
		function excluir($cod){

			$conn = conectar();

			$sql = "DELETE from funcionario where idfuncionario='$cod';";
			$resultado = pg_query($sql);
			desconectar($conn);
		}
		function limpaForm(){
			$_POST['nome'] 		= "";
			$_POST["cpf"] 		= "";
			$_POST["email"] 	= "";
			$_POST["login"] 	= "";
			$_POST["senha"] 	= "";
			$_POST["cargo"] 	= "";
			$_POST["sexo"] 		= "";
			$_POST["fone"]		= "";
			$_POST["end"] 		= "";
			$_POST["estado"]	= "";
			$_POST["cidade"] 	= "";
			$_POST["cod"] 		= "";


		}
		function mostraTabela(){
			$conn = conectar();
			$query = "select * from funcionario";
			$resultado = pg_query($query); // Executa a query $query na conexão $db
			echo "<div id = 'titulo' class = 'titulo'>Funcionários</div><div class='tabela'><table class='table'>
		        <tr class='alt'>
		          <td>Nome Completo</td>
		          <td>CPF</td>
		          <td>Email</td>
		          <td>Cargo</td>
		          <td>Sexo</td>
		          <td>Telefone</td>
		          <td>Endereço</td>
		          <td>Estado</td>
		          <td>Cidade</td>
		          <td>Editar</td>
		          <td>Excluir</td>
		        </tr>";
			while($linha = pg_fetch_array($resultado)) { 
				echo '<tr>
		          <td>'.$linha['nomef'].'</td>
		          <td>'.$linha['cfp'].'</td>
		          <td>'.$linha['email'].'</td>
		          <td>'.$linha['cargo'].'</td>
		          <td>'.$linha['sexo'].'</td>
		          <td>'.$linha['telefone'].'</td>
		          <td>'.$linha['endereco'].'</td>
		          <td>'.$linha['estado'].'</td>
		          <td>'.$linha['cidade'].'</td>
		          <td><a href="?op=2&cod='.$linha['idfuncionario'].'">Editar</a></td>
		          <td><a href="?op=3&cod='.$linha['idfuncionario'].'" onclick="return confirm(\'Deseja realmente excluir esse cadastro?\')">Excluir</a></td>
		      
		       </tr>';
 
			}
			echo '</table></div>';
			desconectar($conn);
		}
				
	?>

	<head>
		<link rel="stylesheet" type="text/css" href="style.css">

		
		<title>Aplicação</title>
		<script language= "JavaScript" type = "text/JavaScript" > 
		var count = 1;
					
			function validarNome()
			{
				var nome = form1.nameNome.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+(\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ]+)*$/;
				var OK = re.exec(nome);  
        		if(nome == "")
				{
					document.getElementById("idNome").style.border = "2px solid red";
					document.getElementById("valNome").innerHTML = "*";
					cadPartic.nameNome.focus();
					count = count + 1;
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idNome").style.border = "2px solid red";
						document.getElementById("valNome").innerHTML = "Nome Inválido";
						cadPartic.nameNome.focus();
						count = count + 1;
						return false;
					}
					else
					{
						document.getElementById("idNome").style.border = "1px solid green";
						document.getElementById("valNome").innerHTML = "";
						count = count - 1;
						return true;
						
					}
					count = count - 1;
				return true;

			}
			function validarSenha()
			{
				var senha = form1.nameSenha.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]{6,12}$/;
				var OK = re.exec(senha);
				if(senha == "")
				{
					document.getElementById("idSenha").style.border = "2px solid red";
					document.getElementById("valSenha").innerHTML = "*";
					cadPartic.nameSenha.focus();
					count = count + 1;
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idSenha").style.border = "2px solid red";
						document.getElementById("valSenha").innerHTML = "Senha Inválida (A senha deve ter de 6 à 12 caracteres)";
						cadPartic.nameSenha.focus();
						count = count + 1;
						return false;
					}
					else
					{
						document.getElementById("idSenha").style.border = "1px solid green";
						document.getElementById("valSenha").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarLogin()
			{
				var login = form1.nameLogin.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]{6,10}$/;
				var OK = re.exec(login);
				if(login == "")
				{
					document.getElementById("idLogin").style.border = "2px solid red";
					document.getElementById("valLogin").innerHTML = "*";
					cadPartic.nameLogin.focus();
					count = count + 1;
					return false;
				}
				else
					if(!OK)
					{
						document.getElementById("idLogin").style.border = "2px solid red";
						document.getElementById("valLogin").innerHTML = "Login Inválido (O login deve ter de 6 à 10 caracteres)";
						cadPartic.nameLogin.focus();
						count = count + 1;
						return false;
					}
					else
					{
						document.getElementById("idLogin").style.border = "1px solid green";
						document.getElementById("valLogin").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarCargo()
			{
				var cargo = form1.nameCargo.value;
				if(cargo == "")
				{
					document.getElementById("idCargo").style.border = "2px solid red";
					document.getElementById("valCargo").innerHTML = "*";
					cadPartic.nameLogin.focus();
					count = count + 1;
					return false;
				}
				else
				{
					document.getElementById("idCargo").style.border = "1px solid green";
					document.getElementById("valCargo").innerHTML = "";
					count = count - 1;
					return true;
				}
				count = count - 1;
				return true;
			}
			function validarFone()
			{
				var fone = form1.nameFone.value;
				var re = /^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/;
				var OK = re.exec(fone);
				if(fone == "")
				{
					document.getElementById("idFone").style.border = "2px solid red";
					document.getElementById("valFone").innerHTML = "*";
					cadPartic.nameFone.focus();
					count = count + 1;
					return false;
				}
				if(!OK)
				{
					document.getElementById("idFone").style.border = "2px solid red";
					document.getElementById("valFone").innerHTML = "Telefone Inválido";
					cadPartic.nameFone.focus();
					count = count + 1;
					return false;
				}
					else
					{
						document.getElementById("idFone").style.border = "1px solid green";
						document.getElementById("valFone").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarEnd()
			{
				var end = form1.nameEnd.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+(\s[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+)*$/;
				var OK = re.exec(end);
				if(end == "")
				{
					document.getElementById("idEnd").style.border = "2px solid red";
					document.getElementById("valEnd").innerHTML = "*";
					cadPartic.nameEnd.focus();
					count = count + 1;
					return false;
				}
				if(!OK)
				{
					document.getElementById("idEnd").style.border = "2px solid red";
					document.getElementById("valEnd").innerHTML = "Endereço Inválido";
					cadPartic.nameEnd.focus();
					count = count + 1;
					return false;
				}
					else
					{
						document.getElementById("idEnd").style.border = "1px solid green";
						document.getElementById("valEnd").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarCPF()
			{
				var cpf = form1.nameCPF.value;
				var re = /^\d{2,3}\.?\d{3}\.?\d{3}\-?\d{2}$/;
				var OK = re.exec(cpf);
				if(cpf == "")
				{
					document.getElementById("idCPF").style.border = "2px solid red";
					document.getElementById("valCPF").innerHTML = "*";
					cadPartic.nameCPF.focus();
					count = count + 1;
					return false;
				}
				if(!OK)
				{
					document.getElementById("idCPF").style.border = "2px solid red";
					document.getElementById("valCPF").innerHTML = "CPF Inválido";
					cadPartic.nameCPF.focus();
					count = count + 1;
					return false;
				}
					else
					{
						document.getElementById("idCPF").style.border = "1px solid green";
						document.getElementById("valCPF").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarEmail()
			{
				var email = form1.nameEmail.value;
				var re = /^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/;
				var OK = re.exec(email);
				if(email == "")
				{
					document.getElementById("idEmail").style.border = "2px solid red";
					document.getElementById("valEmail").innerHTML = "*";
					cadPartic.nameEmail.focus();
					count = count + 1;
					return false;
				}
				if(!OK)
				{
					document.getElementById("idEmail").style.border = "2px solid red";
					document.getElementById("valEmail").innerHTML = "E-mail Inválido";
					cadPartic.nameEmail.focus();
					count = count + 1;
					return false;
				}
					else
					{
						document.getElementById("idEmail").style.border = "1px solid green";
						document.getElementById("valEmail").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarCid()
			{
				var cid = form1.nameCid.value;
				var re = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ0-9]+$/;
				var OK = re.exec(cid);
				if(cid == "")
				{
					document.getElementById("idCid").style.border = "2px solid red";
					document.getElementById("valCid").innerHTML = "*";
					cadPartic.nameCid.focus();
					count = count + 1;
					return false;
				}
				if(!OK)
				{
					document.getElementById("idCid").style.border = "2px solid red";
					document.getElementById("valCid").innerHTML = "Nome da cidade Inválido";
					cadPartic.nameCid.focus();
					count = count + 1;
					return false;
				}
					else
					{
						document.getElementById("idCid").style.border = "1px solid green";
						document.getElementById("valCid").innerHTML = "";
						count = count - 1;
						return true;
					}
					count = count - 1;
				return true;
			}
			function validarEstado()
			{
				var est = form1.nameEstado.value;
				if(est == "")
				{
					document.getElementById("idEstado").style.border = "2px solid red";
					document.getElementById("valEstado").innerHTML = "*";
					cadPartic.nameEstado.focus();
					count = count + 1;
					return false;
				}
				else
				{
					document.getElementById("idEstado").style.border = "1px solid green";
					document.getElementById("valEstado").innerHTML = "";
					count = count - 1;
					return true;
				}
				count = count - 1;
				return true;
			}
			function validageral() {
			
				if(count > 0){
					alert("Todos os campos são obrigatórios!");
					return false;
				}
				else 
					return true;
			}
		</script> 
		<noscript>Browser sem suporte JavaScript!</noscript>
		
	</head>
	<body>
		<div id = "master">
			<?php

				if(isset($_POST["mTabela"]) || isset($_POST["cadastrar"]))
					$menu = 0;
				else if(isset($_POST["home"]))
					$menu = 0;
				else if(isset($_POST["appR"]))
					$menu = 0;
				else
					$menu = 1;

				
				if($_SESSION['permissao'] > 2 && $menu==1 && !isset($_GET['op']) && !(isset($_POST["botao"]) ||isset($_POST["editar"]) || isset($_POST["cancelar"]))){
					include 'menu.php';
					include 'home.php';
				}
				else if($_SESSION['permissao'] > 2)
					include 'menu.php';
				else {
					echo "<div id = 'master'>
							<div id = 'conteudo'>
								<form name = 'form1' action='cadastro.php' method='POST'>
									<ul class='ul'>
										<li><a href='#'><input class='botao' type = 'submit' value= 'Sair' name = 'sair'></a></li>
									</ul>";
					include 'form.php';
				}
				if(isset($_POST["botao"])){
					if($_POST["botao"] == -1){
						include 'form.php';
					}
				}
				else if(isset($_POST["editar"])){
					if($_POST["editar"] == -1){
						include 'form.php';
					}
				}
				
				if(isset($_POST["botao"]) || isset($_POST["editar"]) || isset($_POST["cancelar"])) {
					if(isset($_POST["botao"]) && $_POST["botao"] != -1){
						mostraTabela();
						return ;
					}
					if(isset($_POST["editar"]) && $_POST["editar"] != -1){
						mostraTabela();
						return ;
					}
					if(isset($_POST["cancelar"]))
						mostraTabela();
				}

			

				if(isset($_GET['op']) && $_GET['op']==2){
					include "form.php";
				}
				if(isset($_GET['op']) && $_GET['op']==3)
					mostraTabela();
	
				if(isset($_POST["appR"])){
					$menu = 0;
					echo "<meta HTTP-EQUIV='refresh' CONTENT='URL=cadastro.php'>";
					include 'appR.php';
				}
				if(isset($_POST["mTabela"])){
					$menu = 0;
					echo "<meta HTTP-EQUIV='refresh' CONTENT='URL=cadastro.php'>";
					mostraTabela();
				}
				if(isset($_POST["home"])){
					$menu = 0;
					echo "<meta HTTP-EQUIV='refresh' CONTENT='URL=cadastro.php'>";
					include 'home.php';
				}
				if(isset($_POST["cadastrar"])){
					$menu = 0;
					echo "<meta HTTP-EQUIV='refresh' CONTENT='URL=cadastro.php'>";
					include 'form.php';
				}
			?>
		</div>
	</body>
</html>