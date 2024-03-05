<?php
	$servidor = "localhost";
	$usuario = "u691240250_infosave";
	$senha = "infosaveSystembd#11";
	$dbname = "u691240250_infosavebd";
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	if(!$conn){
		echo "ERROR: 1";
	}else{
			//echo "Conexao realizada com sucesso";
	}
	
	?>