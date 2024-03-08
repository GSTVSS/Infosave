<?php
session_start();

include('config/conexao.php');
include_once("config/seguranca.php");
seguranca_adm();


$id_colaborador = mysqli_real_escape_string($conn, $_POST['id_colaborador']);
$nome = mysqli_real_escape_string($conn, ucwords(strtolower($_POST['nome'])));
$email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
$cep = mysqli_real_escape_string($conn, $_POST['cep']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']);
$numero = mysqli_real_escape_string($conn, $_POST['numero']);
$bairro = mysqli_real_escape_string($conn, $_POST['bairro']); 
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$estado = mysqli_real_escape_string($conn, $_POST['uf']);
$cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
$rg = mysqli_real_escape_string($conn, $_POST['rg']);
$nascimento = mysqli_real_escape_string($conn, $_POST['nascimento']);
$data_cadastro = date('Y-m-d H:i:s');
$criado_por = $_SESSION['usuarioNome'];
$situacao = mysqli_real_escape_string($conn, $_POST['situacao']);
$sexo = mysqli_real_escape_string($conn, $_POST['sexo']);
$nome_mae = mysqli_real_escape_string($conn, $_POST['nome_mae']);
$org_emissor = mysqli_real_escape_string($conn, $_POST['org_emissor']);
$data_expedicao = mysqli_real_escape_string($conn, $_POST['data_expedicao']);
$registro = mysqli_real_escape_string($conn, $_POST['registro']);
$especialidade = mysqli_real_escape_string($conn, $_POST['especialidade']);
$banco = mysqli_real_escape_string($conn, $_POST['banco']);
$tipo_conta = mysqli_real_escape_string($conn, $_POST['tipo_conta']);
$agencia = mysqli_real_escape_string($conn, $_POST['agencia']);
$conta = mysqli_real_escape_string($conn, $_POST['conta']);
$pix = mysqli_real_escape_string($conn, $_POST['pix']);

 



$nascimento = mysqli_real_escape_string($conn, $_POST['nascimento']);
$nascimento = str_replace("/", "-", $nascimento);
$nascimento = date('Y-m-d', strtotime($nascimento));

$altera_cliente = "UPDATE colaboradores SET nome='$nome', email='$email', telefone='$telefone', cep='$cep', rua='$rua', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado', cpf='$cpf', rg='$rg', nascimento='$nascimento', situacao='$situacao', sexo='$sexo', nome_mae='$nome_mae', org_emissor='$org_emissor', data_expedicao='$data_expedicao', registro='$registro', especialidade='$especialidade', banco='$banco', tipo_conta='$tipo_conta', agencia='$agencia', conta='$conta', pix='$pix' WHERE id_colaborador='$id_colaborador'";
$resposta = mysqli_query($conn, $altera_cliente);

if($resposta){
    $_SESSION['success'] = "<div class='danger' role='alert' id='sumirDiv'><center>Área Restrita - Realize Login</center></div>";
    $_SESSION['success'] = "<div class='alert alert-success alert-dismissible fade show text text-center mb-0' role='alert'>
                                
                                <strong> COLABORADR ATUALIZADO COM SUCESSO &nbsp; <i class='far fa-smile-wink fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                
                        </div>";
    header('Location: listar_colaborador.php');
}else{
    $_SESSION['error'] = "<div class='alert alert-danger alert-dismissible fade show text text-center mb-0' role='alert'>
                                
                                <strong> NÃO FOI POSSÍVEL EDITAR O COLABORADOR &nbsp; <i class='fas fa-grin-squint-tears fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                
                            </div>";
     header('Location: listar_colaborador.php');
    
}


?>
