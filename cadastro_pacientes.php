<?php
session_start();
include('config/conexao.php');
include_once("config/seguranca.php");
seguranca_adm();

$nome = mysqli_real_escape_string($conn, ucwords(strtolower($_POST['nome'])));
$nascimento = mysqli_real_escape_string($conn, $_POST['nascimento']);
$tomador = mysqli_real_escape_string($conn, $_POST['tomador']);
$sexo = mysqli_real_escape_string($conn, $_POST['sexo']);
$telefone = mysqli_real_escape_string($conn, $_POST['telefone_residencia']);
$diagnostico = mysqli_real_escape_string($conn, $_POST['diagnostico']);
$bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
$uf = mysqli_real_escape_string($conn, $_POST['uf']);
$cep = mysqli_real_escape_string($conn, $_POST['cep']);
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']);
$numero = mysqli_real_escape_string($conn, $_POST['numero']);
$regiao = mysqli_real_escape_string($conn, $_POST['regiao']);
$post = mysqli_real_escape_string($conn, $_POST['post']);
$pad = mysqli_real_escape_string($conn, $_POST['pad']);

$criado_por = $_SESSION['usuarioNome'];
$situacao = mysqli_real_escape_string($conn, $_POST['situacao']);
$data_cadastro = date('Y-m-d H:i:s');

$nascimento = mysqli_real_escape_string($conn, $_POST['nascimento']);
$nascimento = str_replace("/", "-", $nascimento);
$nascimento = date('Y-m-d', strtotime($nascimento));

$especialidades = [
    'Terapeuta Ocupacional' => (isset($_POST['terapeuta_ocupacional']) ? 1 : 0),
    'Psicólogo' => (isset($_POST['psicologo']) ? 1 : 0),
    'Nutricionista' => (isset($_POST['nutricionista']) ? 1 : 0),
    'Médico' => (isset($_POST['medico']) ? 1 : 0),
    'Fonoaudiólogo' => (isset($_POST['fonoaudilogo']) ? 1 : 0),
    'Fisioterapeuta' => (isset($_POST['fisioterapeuta']) ? 1 : 0),
    'Auxiliar de Enfermagem' => (isset($_POST['auxiliar_enfermagem']) ? 1 : 0),
    'Técnico de Enfermagem' => (isset($_POST['tecnico_enfermagem']) ? 1 : 0),
    'Enfermeiro' => (isset($_POST['enfermeiro']) ? 1 : 0),
    'Cuidador de Idosos' => (isset($_POST['cuidador_idosos']) ? 1 : 0)
];

$cadastrar_paciente = "INSERT INTO pacientes (nome, nascimento, tomador, sexo, telefone_residencia, diagnostico, bairro, uf, cep, cidade, rua, numero, regiao, post, criado_por, situacao, pad_autorizado) 
VALUES ('$nome', '$nascimento','$tomador', '$sexo', '$telefone', '$diagnostico', '$bairro', '$uf', '$cep', '$cidade','$rua', '$numero','$regiao', '$post', '$criado_por', '$situacao', '$pad')";
$resposta = mysqli_query($conn, $cadastrar_paciente);
if($resposta){

    $ultimo_id_inserido = mysqli_insert_id($conn);
    foreach($especialidades as $especialidade => $status){
        if($status){
            $adicionar_especialidades = "INSERT INTO pacientes_especialidades (id_paciente, especialidade)
            VALUES ('$ultimo_id_inserido', '$especialidade')";
            mysqli_query($conn, $adicionar_especialidades);
        }
    }

    $_SESSION['success'] = "<div class='danger' role='alert' id='sumirDiv'><center>Área Restrita - Realize Login</center></div>";
    $_SESSION['success'] = "<div class='alert alert-success alert-dismissible fade show text text-center mb-0' role='alert'>
                                
                                <strong> PACIENTE CADASTRADO COM SUCESSO &nbsp; <i class='far fa-smile-wink fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                
                        </div>";
    header('Location: listar_pacientes.php');
}else{
    $_SESSION['error'] = "<div class='alert alert-danger alert-dismissible fade show text text-center mb-0' role='alert'>
                                
                                <strong> NÃO FOI POSSÍVEL CADASTRAR O CLIENTE &nbsp; <i class='fas fa-grin-squint-tears fa-2x'></i> </strong> 
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                                
                            </div>";
     header('Location: listar_pacientes.php');
    
}
?>
