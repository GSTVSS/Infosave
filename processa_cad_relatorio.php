<?php
session_start();
include('config/conexao.php');
include_once("config/seguranca.php");
seguranca_adm();

$id_paciente = (int)$_POST['paciente']; // Converte para inteiro
$file = mysqli_real_escape_string($conn, strtolower($_POST['email']));
$targetDirectory = "uploads/";
$targetFile = $targetDirectory . basename($_FILES["fileInput"]["name"]);
if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetFile)) {
    echo "File has been uploaded successfully.";
} else {
    echo "Error uploading file.";
}

$criado_por = $_SESSION['usuarioNome'];
var_dump($_SESSION);

$altera_cliente = "INSERT INTO relatorios (descricao, id_cliente, id_responsavel, url_file) 
VALUES ('$descricao', '$id_responsavel', '$id_cliente', '$url')";
$resposta = mysqli_query($conn, $altera_cliente);

if($resposta){
    $_SESSION['success'] = "<div class='danger' role='alert' id='sumirDiv'><center>Área Restrita - Realize Login</center></div>";
    $_SESSION['success'] = "<div class='alert alert-success alert-dismissible fade show text text-center mb-0' role='alert'>
                                <strong> CLIENTE CADASTRADO COM SUCESSO &nbsp; <i class='far fa-smile-wink fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>     
                            </div>";
    header('Location: listar_relatorios.php');
} else {
    $_SESSION['error'] = "<div class='alert alert-danger alert-dismissible fade show text text-center mb-0' role='alert'>   
                                <strong> NÃO FOI POSSÍVEL CADASTRAR O CLIENTE &nbsp; <i class='fas fa-grin-squint-tears fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>                           
                            </div>";
    header('Location: listar_relatorios.php'); 
}
?>
