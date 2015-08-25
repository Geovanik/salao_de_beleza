<html>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8"/>
	
	<?php
		if(!isset($_SESSION['permissao']))
			session_start();
		if($_SESSION['permissao'] <= 0 ){
			echo 	"<div class='negada'>Permissão negada!</div> 
					<div class='negada'>É necessário efetuar login para acessar essa página... </div>
					<div class='negada'><a href='index.php'>Logar</a></div>";
			exit();
		}
	?>
	<head>
		<script src="jquery.js" type="text/javascript"></script>
		<script src="jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript">
          jQuery(function($){
        	$("#idCPF").mask("999.999.999-99",{placeholder:" "});
        	$("#idFone").mask("(99) 9999-9999",{placeholder:" "});
        });
    </script>
	<body>				
		<div id = "titulo" class = "titulo">Cadastro de Funcionários</div>
			<fieldset id = "idColNome">
				<legend>Cadastro Funcionário:</legend>
				<table>
					<input type="hidden" value="<?php echo $_POST['cod']; ?>" name="nameCod">
					<tr> 
						<td><label for = "idNome">Nome Completo:</label></td>
						<td>
							<input onBlur = "return validarNome()" type = "text" value='<?php echo $_POST['nome']; ?>' name = "nameNome" id = "idNome" size = "25">
						</td>
						<td><div id = "valNome"></div></td>
					</tr>
					<tr> 
						<td><label for = "idLogin">Login:</label></td>
						<td>
							<input onBlur = "return validarLogin()" type = "text" value='<?php echo $_POST['login']; ?>' name = "nameLogin" id = "idLogin" size = "10">
						</td>
						<td><div id = "valLogin"></div></td>
					</tr>
					<tr> 
						<td><label for = "idSenha">Senha:</label></td>
						<td>
							<input onBlur = "return validarSenha()" type = "password" value='<?php echo $_POST['senha']; ?>' name = "nameSenha" id = "idSenha" size = "10">
						</td>
						<td><div id = "valSenha"></div></td>
					</tr>
					<tr> 
						<td>Cargo:</td>
						<td>
						<?php
						if($per > 2){
								if($_POST['cargo'] == "")
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = '1'> Caixa </option>
												<option  value = '2'> Cabeleireiro </option>
												<option  value = '3'> Administrador </option>
											</select>";
								else if ($_POST['cargo'] == 1)
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option selected value = '1'> Caixa </option>
												<option  value = '2'> Cabeleireiro </option>
												<option  value = '3'> Administrador </option>
											</select>";
								else if ($_POST['cargo'] == 2)
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = '1'> Caixa </option>
												<option selected value = '2'> Cabeleireiro </option>
												<option  value = '3'> Administrador </option>
											</select>";
								else if ($_POST['cargo'] == 3)
									echo "	<select onBlur = 'return validarCargo()'' name = 'nameCargo' id = 'idCargo'>
												<option value = ''>-- Cargos --</option>
												<option value = '1'> Caixa </option>
												<option value = '2'> Cabeleireiro </option>
												<option selected value = '3'> Administrador </option>
											</select>";
						}
						else 
							if($_POST['cargo'] == 1)
								echo "Caixa";
							else
								echo "Cabeleireiro";
						?>
						</td>
						<td><div id = "valCargo"></div></td>
					</tr>
					<tr>
						<td>Sexo:</td>
						<td colspan = "2">
						<?php
							if($_POST['sexo'] == '')
								echo "	<input type = 'radio' name = 'nameSexo' value='F' checked> Feminino
										<input type = 'radio' name = 'nameSexo' value='M' selected> Masculino";
							else if ($_POST['sexo'] == 'F')
								echo "	<input type = 'radio' name = 'nameSexo' value='F' checked> Feminino
										<input type = 'radio' name = 'nameSexo' value='M' > Masculino";
							else if ($_POST['sexo'] == 'M')
								echo "	<input type = 'radio' name = 'nameSexo' value='F'> Feminino
										<input type = 'radio' name = 'nameSexo' value='M' checked> Masculino";
						?>
						</td>
						<td><div id = "valSexo"></div></td>
					</tr>
					<tr> 
						<td><label for = "idFone">Telefone:</label></td>
						<td>
							<input onBlur = "return validarFone()" type = "text" value='<?php echo $_POST['fone']; ?>' name = "nameFone" id = "idFone" size = "15">
						</td>
						<td><div id = "valFone"></div></td>
					</tr>
					<tr> 
						<td><label for = "idEnd">Endereço:</label></td>
						<td>
							<input onBlur = "return validarEnd()" type = "text" value='<?php echo $_POST['end']; ?>' name = "nameEnd" id = "idEnd" size = "40">
						</td>
						<td><div id = "valEnd"></div></td>
					</tr>
					<tr> 
						<td><label for = "idEnd">Estado:</label></td>
						<td>
							<input onBlur = "return validarEstado()" type = "text" value='<?php echo $_POST['estado']; ?>' name = "nameEstado" id = "idEstado" size = "2">
						</td>
						<td><div id = "valEstado"></div></td>
					</tr>
					<tr> 
						<td><label for = "idCid">Cidade:</label></td>
						<td>
							<input onBlur = "return validarCid()" type = "text" value='<?php echo $_POST['cidade']; ?>' name = "nameCid" id = "idCid" size = "25">
						</td>
						<td><div id = "valCid"></div></td>
					</tr>
					<tr> 
						<td><label for = "idCPF">CPF:</label></td>
						<td>
							<input onBlur = "return validarCPF()" type = "text" value='<?php echo $_POST['cpf']; ?>' name = "nameCPF" id = "idCPF" size = "20">
						</td>
						<td><div id = "valCPF"></div></td>
					</tr>
					<tr> 
						<td><label for = "idEmail">E-mail:</label></td>
						<td>
							<input onBlur = "return validarEmail()" type = "text" value='<?php echo $_POST['email']; ?>' name = "nameEmail" id = "idEmail" size = "20">
						</td>
						<td><div id = "valEmail"></div></td>
					</tr>
					<tr> 
						<?php
							if(isset($_GET['op']) && $_GET['op'] == 2 || $per < 3){
								echo "<td><input onClick = 'return validageral()'  type = 'submit' value = 'Salvar' name='editar'>   ";
								if($per > 2)
									echo "   <input type = 'submit' value = 'Cancelar' name='cancelar'></td></tr>";
							}
							else
							echo"<td colspan = '3'><input onClick = 'return validageral()' type = 'submit' value = 'Enviar' name='botao'> </td>";
						?>
					</tr>
				</table>
			</fieldset>
		</form>
		</div>
		</div>
	</body>
</html>
