<?php
session_start();
include_once('assets/cabecalho.php');
include_once('assets/rodape.php');
include('config/conexao.php');
include_once("config/seguranca.php");
seguranca_adm();
$consulta = "SELECT * FROM colaboradores ";
$resultado = mysqli_query($conn, $consulta);
?>

<?php include_once('assets/menu.php'); ?>

<?php 
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<div class="p-5 bg-dark shadow row g-2 bg-secondary"></div>
<div class="p-1 bg-secondary"></div>

<div class="container-flex text-center p-3 d-flex justify-content-center bg-secondary">
    <div class="containder-flex text-center w-50 hstack bg-secondary gap-3">
        <input class="form-control me-2 h-40 p-4 shadow bg-body-tertiary rounded" type="search" name="pesquisa_colaborador" placeholder="Buscar" aria-label="Buscar" required="autofocus">
        <button type="button" class="btn btn-primary btn-lg h-100 shadow rounded" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cadColaborador">Cadastrar</button>
    </div>
</div>
<div class="container-flex p-3 d-flex justify-content-center bg-secondary">
    <div class="fw-semibold">
        <div class="row">
            <div class="form-label-group">
                <div class="table-responsive">
                    <table class="resultado_colaborador table table-striped table-hover table-bordered table-sm aling-middle table-secondary rounded shadow">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th scope="col">#</th>
                                <th scope="col">NOME</th>
                                <th scope="col">ESPECIALIDADES</th>
                                <th scope="col">CONTATO</th>
                                <th scope="col">ENDEREÇO</th>
                                <th scope="col">SITUAÇÃO</th>
                                <th scope="col" class="text text-center" colspan="3">AÇÕES</th>
                            </tr>
                        </thead>
                        <?php
                        while ($linha = mysqli_fetch_assoc($resultado)) {
                            $id_colaborador = $linha['id_colaborador'];
                            $name = ucwords(strtolower($linha['nome']));
                            $telefone = $linha['telefone'];
                            $responsavel = $linha['criado_por'];
                            $situacao = $linha['situacao'];
                            $alterado_por = $linha['alterado_por'];

                            // CONVERTENDO DATA/HORA PARA PADRAO PORTUGUES-BR
                            $ultima_alteracao = $linha['ultima_alteracao'];
                            $ultima_alteracao = date('d/m/Y H:i:s',  strtotime($ultima_alteracao));

                            // CONVERTENDO DATA/HORA PARA PADRAO PORTUGUES-BR
                            $data_cadastro = $linha['data_cadastro'];
                            $data_cadastro = date('d/m/Y H:i:s',  strtotime($data_cadastro));

                            // CONVERTENDO NASCIMENTO PARA PADRAO PORTUGUES-BR
                            $nascimento = $linha['nascimento'];
                            $nascimento = date('d/m/Y',  strtotime($nascimento));

                            $rua = $linha['rua'];
                            $bairro = $linha['bairro'];
                            $rua = $linha['rua'];
                            $numero = $linha['numero'];
                            $cidade = $linha['cidade'];
                            $uf = $linha['estado'];

                            $endereco = $rua . ", " . $numero . " - " . $bairro . "-" . $cidade . "/" . $uf;
                        ?>
                            <tbody class="table-group-divider">
                                <tr>
                                    <td><?php echo $id_colaborador ?></td>
                                    <td><?php echo $nome; ?></td>
                                    <td><?php echo $linha['especialidade']; ?></td>
                                    <td><?php echo $linha['telefone']; ?></td>
                                    <td><?php echo $endereco; ?></td>
                                    <td><?php echo $linha['situacao']; ?></td>
                                    <td class="text text-center">
                                        <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#visualizarColaborador" data-whatever="<?php echo $linha['id_colaborador']; ?>" data-whateveremail="<?php echo $linha['email']; ?>" data-whatevernome="<?php echo $nome; ?>" data-whateversexo="<?php echo $linha['sexo']; ?>" data-whatevertelefone="<?php echo $linha['telefone']; ?>" data-whatevercep="<?php echo $linha['cep']; ?>" data-whatevercidade="<?php echo $linha['cidade']; ?>" data-whateverestado="<?php echo $linha['estado']; ?>" data-whateverbairro="<?php echo $linha['bairro']; ?>" data-whateverrua="<?php echo $linha['rua']; ?>" data-whatevernumero="<?php echo $linha['numero']; ?>" data-whatevernascimento="<?php echo $nascimento; ?>" data-whateveroperador="<?php echo $linha['criado_por']; ?>" data-whateversituacao="<?php echo $situacao; ?>" data-whateverdata_cadastro="<?php echo $data_cadastro; ?>" data-whateveralterado_por="<?php echo $alterado_por; ?>" data-whateverultima_alteracao="<?php echo $ultima_alteracao; ?>" data-whatevercpf="<?php echo $linha['cpf']; ?>" data-whateverrg="<?php echo $linha['rg']; ?>" data-whatevernome_mae="<?php echo $linha['nome_mae']; ?>" data-whateverorg_emissor="<?php echo $linha['org_emissor']; ?>" data-whateverdata_expedicao="<?php echo date('d/m/Y',  strtotime($linha['data_expedicao'])); ?>" data-whateverregistro="<?php echo $linha['registro']; ?>" data-whateverespecialidade="<?php echo $linha['especialidade']; ?>" data-whateverbanco="<?php echo $linha['banco']; ?>" data-whatevertipo_conta="<?php echo $linha['tipo_conta']; ?>" data-whateveragencia="<?php echo $linha['agencia']; ?>" data-whateverconta="<?php echo $linha['conta']; ?>" data-whateverpix="<?php echo $linha['pix']; ?>">
                                            <i class="far fa-eye text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"></i>
                                        </a>
                                    </td>
                                    <td class="text text-center">
                                        <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#editarColaborador" data-whatever="<?php echo $linha['id_colaborador']; ?>" data-whateveremail="<?php echo $linha['email']; ?>" data-whatevernome="<?php echo ucwords(strtolower($linha['nome'])); ?>" data-whateversexo="<?php echo $linha['sexo']; ?>" data-whatevertelefone="<?php echo $linha['telefone']; ?>" data-whatevercep="<?php echo $linha['cep']; ?>" data-whatevercidade="<?php echo $linha['cidade']; ?>" data-whateverestado="<?php echo $linha['estado']; ?>" data-whateverbairro="<?php echo $linha['bairro']; ?>" data-whateverrua="<?php echo $linha['rua']; ?>" data-whatevernumero="<?php echo $linha['numero']; ?>" data-whatevernascimento="<?php echo $nascimento; ?>" data-whateveroperador="<?php echo $linha['criado_por']; ?>" data-whateversituacao="<?php echo $situacao; ?>" data-whateverdata_cadastro="<?php echo $data_cadastro; ?>" data-whateveralterado_por="<?php echo $alterado_por; ?>" data-whateverultima_alteracao="<?php echo $ultima_alteracao; ?>" data-whatevercpf="<?php echo $linha['cpf']; ?>" data-whateverrg="<?php echo $linha['rg']; ?>" data-whatevernome_mae="<?php echo $linha['nome_mae']; ?>" data-whateverorg_emissor="<?php echo $linha['org_emissor']; ?>" data-whateverdata_expedicao="<?php echo date('d/m/Y',  strtotime($linha['data_expedicao'])); ?>" data-whateverregistro="<?php echo $linha['registro']; ?>" data-whateverespecialidade="<?php echo $linha['especialidade']; ?>" data-whateverbanco="<?php echo $linha['banco']; ?>" data-whatevertipo_conta="<?php echo $linha['tipo_conta']; ?>" data-whateveragencia="<?php echo $linha['agencia']; ?>" data-whateverconta="<?php echo $linha['conta']; ?>" data-whateverpix="<?php echo $linha['pix']; ?>">
                                            <i class="far fa-edit text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i>
                                        </a>
                                    </td>
                                    <td class="text text-center">
                                        <a href="processa_excluir_colaborador.php?id_colaborador=<?php echo $linha['id_colaborador']; ?>" onClick="return confirm('Deseja realmente deletar o colaborador?')">
                                            <i class="far fa-trash-alt text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"></i>
                                            <a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================================== MODAL CADASTRAR CLIENTE----------------------------------------------------------------->
<style>
    .errorInput {
        border: 2px solid red !important;
    }
</style>
<script>
    // ================================ FUNÇÃO PARA MASCARA DE TELEFONE =============================================
    function mask(o, f) {
        setTimeout(function() {
            var v = telefone(o.value);
            if (v != o.value) {
                o.value = v;
            }
        }, 1);
    }

    function telefone(v) {
        var r = v.replace(/\D/g, "");
        r = r.replace(/^0/, ""); //limpa o campo se começar com ZERO (0)
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
        return r;
    }

    // ================================ FUNÇÃO PARA MASCARA DE CELULAR =============================================
    function mask(o, f) {
        setTimeout(function() {
            var v = celular(o.value);
            if (v != o.value) {
                o.value = v;
            }
        }, 1);
    }

    function celular(v) {
        var r = v.replace(/\D/g, "");
        r = r.replace(/^0/, ""); //limpa o campo se começar com ZERO (0)
        if (r.length > 10) {
            r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (r.length > 5) {
            r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (r.length > 2) {
            r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            r = r.replace(/^(\d*)/, "($1");
        }
        return r;
    }

    // ================================ FUNÇÃO PARA MASCARA DE NASCIMENTO =============================================
    $(document).ready(function() {
        $("#nascimento").mask("99/99/9999");
    });

    //FUNÇÃO PARA ADICIONAR ENDEREÇO VIA CEP (https://viacep.com.br/exemplo/javascript/)
    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('uf').value = ("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value = (conteudo.logradouro);
            document.getElementById('bairro').value = (conteudo.bairro);
            document.getElementById('cidade').value = (conteudo.localidade);
            document.getElementById('uf').value = (conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        console.log("procurando cep");
        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };


    $(document).ready(function() {

        $('#insert_form').on('submit', function(event) {
            event.preventDefault(); //EVITA O SUBMIT DO FORM

            var nome = $('#name'); // PEGA O CAMPO CLIENTE DO FORM
            var telefone = $('#telefone_residencia'); // PEGA O CAMPO TELEFONE DO FORM


            var erro = $('.alert-danger'); // PEGA O CAMPO COM A class alert e CRIA A VARIAVEL erro
            var campo = $('#campo-erro'); // CRIA A VARIAVEL PATA EXIBIR O NOME DO CAMPO COM ERROcampo-sucesso


            erro.addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');


            if (!nome.val().match(/[A-Za-z\d]/)) {
                erro.removeClass('d-none'); //REMOVE A CLASSE (d-none) DO BOOTSTRAP E EXIBE O ALERTA
                campo.html('colaborador'); // ADICIONA AO ALERTA O NOME DO CAMPO NAO PREENCHIDO
                nome.focus(); //COLOCA O CURSOR NO CAMPO COM ERRO
                nome.addClass('is-invalid');


                return false;

            } else if (!telefone.val().match(/^\([0-9]{2}\) [0-9]?[0-9]{5}-[0-9]{4}$/)) {
                erro.removeClass('d-none'); //REMOVE A CLASSE (d-none) DO BOOTSTRAP E EXIBE O ALERTA
                campo.html('telefone_residencia'); // ADICIONA AO ALERTA O NOME DO CAMPO NAO PREENCHIDO
                telefone.focus(); //COLOCA O CURSOR NO CAMPO COM ERRO
                telefone.addClass('is-invalid');



                return false;

            } else {

                var dados = $("#insert_form").serialize();
                $.post("cadastro_colaborador.php", dados, function(retorna) {
                    if (retorna) {
                        //Limpar os campo
                        $('#insert_form')[0].reset();

                        //Fechar a janela modal cadastrar
                        $('#cadColaborador').modal('hide');
                        $('#sucessModal').modal('show');

                        setInterval(function() {
                            var redirecionar = "listar_colaborador.php";
                            $(window.document.location).attr('href', redirecionar);

                        }, 3000);

                    } else {

                        return false;
                    }

                });

            }

        });

    });
</script>

<!-- Modal ALERTA DE CADASTRO COM SUCESSO-->
<div class="modal fade" id="sucessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body bg-success text text-center text-white">
                COLABORADOR CADASTRADO COM SUCESSO!
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal ALERTA DE CADASTRO NAO REALIZADO-->
<div class="modal fade" id="dangerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>

            </div>
            <div class="modal-body bg-danger text text-center text-white">
                COLABORADOR NÃO CADASTRADO!
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<div></div>
<!-- ==================================================MODAL CADASTRO DE COLABORADOR ==================================== -->
<div class="modal fade" id="cadColaborador" tabindex="-1" aria-labelledby="exempleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-light">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title fw-bolder" id="exempleModalLabel">Cadastrar Colaborador</h5>

                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
            </div>

            <div class="alert alert-danger d-none fade show m-3" role="alert">
                <strong>ERRO!</strong> - <strong> Preencha todos os campos <span id="campo-erro"></span></strong>!
                <span id="msg"></span>
            </div>
            <!-- ALERTA PARA ERRO DE PREENCHIMENTO DE FORMULARIO -->
            <div class="alert alert-danger d-none fade show m-3" role="alert">
                <strong>ERRO!</strong> - <strong>Preencha o campo <span id="campo-erro"></span></strong>!
                <span id="msg"></span>
            </div>

            <div class="modal-body">
                <form method="POST" id="insert_form">

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="name">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-sexo" class="col-form-label">Sexo</label>
                            <select class="form-control form-select-lg select2" name="sexo" id="sexo" aria-label=".form-select-lg example">
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMININO">FEMININO</option>
                                <option value="OUTRO">OUTRO</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-nascimento" class="col-form-label">Data de Nascimento</label>
                            <input type="text" class="form-control" name="nascimento" id="nascimento">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-telefone_residencia" class="col-form-label">Contato</label>
                            <input type="text" max="15" class="form-control" name="telefone" id="telefone_residencia" onkeyup="mask(this)">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-email" class="col-form-label">E-MAIL</label>
                            <input type="email" max="15" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-rg" class="col-form-label">RG</label>
                            <input type="text" class="form-control" name="rg" id="rg">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-org_emissor" class="col-form-label">Orgão Emissor</label>
                            <input type="text" class="form-control" name="org_emissor" id="org_emissor">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-expedicao" class="col-form-label">Data de Expedição</label>
                            <input type="date" class="form-control" name="expedicao" id="expedicao">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-cpf" class="col-form-label">CPF</label>
                            <input type="text" class="form-control" name="cpf" id="cpf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-4">
                            <label for="recipient-nome_mae" class="col-form-label">Nome da Mãe</label>
                            <input type="text" class="form-control" name="nome_mae" id="nome_mae">
                        </div>
                    </div>
                    <!-- //quadro do colaborador// -->
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-especialidade" class="col-form-label">Especialidade</label>
                            <select class="form-control form-select-lg select2" name="especialidade" id="especialidade" aria-label=".form-select-lg example">
                                <option value="Terapeuta Ocupacional">Terapeuta Ocupacional</option>
                                <option value="Psicólogo">Psicólogo</option>
                                <option value="Nutricionista">Nutricionista</option>
                                <option value="Fonoaudiólogo">Fonoaudiólogo</option>
                                <option value="Médico">Médico</option>
                                <option value="Fisioterapeuta">Fisioterapeuta</option>
                                <option value="Auxiliar de Enfermagem">Auxiliar de Enfermagem</option>
                                <option value="Técnico de Enfermagem">Técnico de Enfermagem</option>
                                <option value="Enfermeiro">Enfermeiro</option>
                                <option value="Cuidador de Idosos">Cuidador de Idosos</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <label for="recipient-registro" class="col-form-label">Registro Profisisonal</label>
                            <input type="text" class="form-control" name="registro" id="registro">
                        </div>
                    </div>

                    <!--//endereço colaborador// -->
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cep" class="col-form-label">Cep</label>
                            <input type="text" name="cep" id="cep" maxlength="50" class="form-control" onblur="pesquisacep(this.value)">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-uf" class="col-form-label">UF</label>
                            <input type="text" name="uf" id="uf" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cidade" class="col-form-label">Cidade</label>
                            <input type="text" name="cidade" id="cidade" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-bairro" class="col-form-label">Bairro</label>
                            <input type="text" name="bairro" id="bairro" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-rua" class="col-form-label">Rua</label>
                            <input type="text" name="rua" id="rua" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-numero" class="col-form-label">Nº</label>
                            <input type="text" name="numero" id="numero" maxlength="50" class="form-control">
                        </div>
                    </div>
                    <!-----              DADOS BANCARIOS                 -->
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-banco" class="col-form-label">Banco</label>
                            <input type="text" max="15" class="form-control" name="banco" id="banco">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-tipo_conta" class="col-form-label">Tipo de Conta</label>
                            <select class="form-control form-select-lg select2" name="tipo_conta" id="tipo_conta" aria-label=".form-select-lg example">
                                <option value="CORRENTE">Corrente</option>
                                <option value="POUPANÇA">Poupança</option>
                                <option value="OUTRO">Outro</option>
                            </select>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-conta" class="col-form-label">Conta</label>
                            <input type="text" max="15" class="form-control" name="conta" id="conta">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-agencia" class="col-form-label">Agencia</label>
                            <input type="text" max="15" class="form-control" name="agencia" id="agencia">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-12 mb-4">
                            <label for="recipient-pix" class="col-form-label">PIX</label>
                            <input type="text" max="15" class="form-control" name="pix" id="pix">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-criado_por" class="col-form-label cli">Operador</label>
                            <input type="text" name="criado_por" id="criado_por" maxlength="50" class="form-control" value="<?php echo $_SESSION['usuarioNome'] ?>" disabled>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-data_cadastro" class="col-form-label">Data do cadastro</label>
                            <input type="text" class="form-control" disabled value="<?php echo date('d/m/Y - H:i:s') ?>">
                        </div>
                        <div class="col-md-4 col-sm-12">

                            <label for="recipient-situacao" class="col-form-label">Situação</label>
                            <select class="form-control form-select-lg mb-5 select2" name="situacao" id="situacao" aria-label=".form-select-lg example">
                                <option value="PENDENTE">Aguardando Liberação</option>
                                <option value="ATIVO">Ativo</option>
                                <option value="INATIVO">Inativo</option>
                                <option value="BANIDO">Banido</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="btn-cadastrar">Salvar</button>
                    </div>
                </form>
            </div>
        <div class="m-2 col-md-8 col-sm-8 alert alert-primary ">
            Informe o CEP e tecle [ ENTER ] para autopreencher o endereço !
        </div>
    </div>
</div>


<!-- -----------------------------------MODAL VISUALIZAR CLIENTE----------------------------------------------------------------->
<div class="modal fade" id="visualizarColaborador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nome</label>
                            <input disabled type="text" class="form-control" name="nome" id="recipient-nome">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-sexo" class="col-form-label">Sexo</label>
                            <input disabled type="text" class="form-control" name="sexo" id="recipient-sexo">

                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-nascimento" class="col-form-label">Data de Nascimento</label>
                            <input disabled type="text" class="form-control" name="nascimento" id="recipient-nascimento">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-telefone_residencia" class="col-form-label">Contato</label>
                            <input disabled type="text" max="15" class="form-control" name="telefone" id="recipient-telefone" onkeyup="mask(this)">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-email" class="col-form-label">E-MAIL</label>
                            <input disabled type="email" max="15" class="form-control" name="email" id="recipient-email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-rg" class="col-form-label">RG</label>
                            <input disabled type="text" class="form-control" name="rg" id="recipient-rg">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-orgao_emissor" class="col-form-label">Orgão Emissor</label>
                            <input disabled type="text" class="form-control" name="orgao_emissor" id="recipient-org_emissor">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-expedicao" class="col-form-label">Data de Expedição</label>
                            <input disabled type="date" class="form-control" name="expedicao" id="recipient-expedicao">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-cpf" class="col-form-label">CPF</label>
                            <input disabled type="text" class="form-control" name="cpf" id="recipient-cpf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-4">
                            <label for="recipient-nome_mae" class="col-form-label">Nome da Mãe</label>
                            <input disabled type="text" class="form-control" name="nome_mae" id="recipient-nome_mae">
                        </div>
                    </div>
                    <!-- //quadro do colaborador// -->
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-especialidade" class="col-form-label">Especialidade</label>
                            <input disabled type="text" class="form-control" name="especialidade" id="recipient-especialidade">

                        </div>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <label for="recipient-registro" class="col-form-label">Registro Profisisonal</label>
                            <input disabled type="text" class="form-control" name="registro" id="recipient-registro">
                        </div>
                    </div>

                    <!--//endereço colaborador// -->
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cep" class="col-form-label">Cep</label>
                            <input disabled type="text" name="cep" id="recipient-cep" maxlength="50" class="form-control" onblur="pesquisacep(this.value)">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-uf" class="col-form-label">UF</label>
                            <input disabled type="text" name="uf" id="recipient-uf" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cidade" class="col-form-label">Cidade</label>
                            <input disabled type="text" name="cidade" id="recipient-cidade" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-bairro" class="col-form-label">Bairro</label>
                            <input disabled type="text" name="bairro" id="recipient-bairro" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-rua" class="col-form-label">Rua</label>
                            <input disabled type="text" name="rua" id="recipient-rua" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-numero" class="col-form-label">Nº</label>
                            <input disabled type="text" name="numero" id="recipient-numero" maxlength="50" class="form-control">
                        </div>
                    </div>
                    <!-----              DADOS BANCARIOS                 -->
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-banco" class="col-form-label">Banco</label>
                            <input disabled type="text" max="15" class="form-control" name="banco" id="recipient-banco">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-tipo_conta" class="col-form-label">Tipo de Conta</label>
                            <input disabled type="text" max="15" class="form-control" name="tipo_conta" id="recipient-tipo_conta">

                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-conta" class="col-form-label">Conta</label>
                            <input disabled type="text" max="15" class="form-control" name="conta" id="recipient-conta">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-agencia" class="col-form-label">Agencia</label>
                            <input disabled type="text" max="15" class="form-control" name="agencia" id="recipient-agencia">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-12 mb-4">
                            <label for="recipient-pix" class="col-form-label">PIX</label>
                            <input disabled type="text" max="15" class="form-control" name="pix" id="recipient-pix">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-criado_por" class="col-form-label cli">Operador</label>
                            <input disabled type="text" name="criado_por" id="recipient-criado_por" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-data_cadastro" class="col-form-label">Data do cadastro</label>
                            <input disabled type="text" class="form-control" id="recipient-data_cadastro">
                        </div>
                        <div class="col-md-4 col-sm-12">

                            <label for="recipient-situacao" class="col-form-label">Situação</label>
                            <input disabled type="text" class="form-control" id='recipient-situacao'>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>

            </form>


        </div>
    </div>
</div>
<!-- -----------------------------------SCRIPT MODAL VISUALIZAR CLIENTE----------------------------------------------------------------->
<script type="text/javascript">
    $('#visualizarColaborador').on('show.bs.modal', function(event) {
        console.log("digitou")
        var button = $(event.relatedTarget) // Botão que acionou o modal
        var recipient = button.data('whatever')
        var recipientnome = button.data('whatevernome')
        var recipientemail = button.data('whateveremail')
        var recipienttelefone = button.data('whatevertelefone')
        var recipientrua = button.data('whateverrua')
        var recipientnumero = button.data('whatevernumero')
        var recipientbairro = button.data('whateverbairro')
        var recipientcomplemento = button.data('whatevercomplemento')
        var recipientcep = button.data('whatevercep')
        var recipientcidade = button.data('whatevercidade')
        var recipientuf = button.data('whateverestado')
        var recipienttelefone = button.data('whatevertelefone')
        var recipientcelular = button.data('whatevercelular')
        var recipientcpf = button.data('whatevercpf')
        var recipientrg = button.data('whateverrg')
        var recipientnascimento = button.data('whatevernascimento')
        var recipientoperador = button.data('whateveroperador')
        var recipientsituacao = button.data('whateversituacao')
        var recipientdataCadastro = button.data('whateverdata_cadastro')
        var recipientalterado_por = button.data('whatevercriado_por')
        var recipientultima_alteracao = button.data('whateverultima_alteracao')
        var cpf = button.data('whatevercpf')
        var sexo = button.data('whateversexo')
        var nome_mae = button.data('whatevernome_mae')
        var org_emissor = button.data('whateverorg_emissor')
        var data_expedicao = button.data('whateverdata_expedicao')
        var registro = button.data('whateverregistro')
        var especialidade = button.data('whateverespecialidade')
        var banco = button.data('whateverbanco')
        var tipo_conta = button.data('whatevertipo_conta')
        var agencia = button.data('whateveragencia')
        var conta = button.data('whateverconta')
        var pix = button.data('whateverpix')

        var modal = $(this)
        modal.find('.modal-title').text('VISUALIZAR CLIENTE CÓDIGO: ' + recipient)
        modal.find('#id').val(recipient)
        modal.find('#recipient-nome').val(recipientnome)
        modal.find('#recipient-email').val(recipientemail)
        modal.find('#recipient-telefone').val(recipienttelefone)
        modal.find('#recipient-rua').val(recipientrua)
        modal.find('#recipient-numero').val(recipientnumero)
        modal.find('#recipient-bairro').val(recipientbairro)
        modal.find('#recipient-cidade').val(recipientcomplemento)
        modal.find('#recipient-cep').val(recipientcep)
        modal.find('#recipient-cidade').val(recipientcidade)
        modal.find('#recipient-uf').val(recipientuf)
        modal.find('#recipient-telefone').val(recipienttelefone)
        modal.find('#recipient-celular').val(recipientcelular)
        modal.find('#recipient-cpf').val(recipientcpf)
        modal.find('#recipient-rg').val(recipientrg)
        modal.find('#recipient-nascimento').val(recipientnascimento)
        modal.find('#recipient-operador').val(recipientoperador)
        modal.find('#recipient-situacao').val(recipientsituacao)
        modal.find('#recipient-dataCadastro').val(recipientdataCadastro)
        modal.find('#recipient-criado_por').val(recipientalterado_por)
        modal.find('#recipientultima_alteracao').val(recipientultima_alteracao)
        modal.find('#recipient-cpf').val(cpf)
        modal.find('#recipient-sexo').val(sexo)
        modal.find('#recipient-nome_mae').val(nome_mae)
        modal.find('#recipient-org_emissor').val(org_emissor)
        modal.find('#recipient-data_expedicao').val(data_expedicao)
        modal.find('#recipient-registro').val(registro)
        modal.find('#recipient-especialidade').val(especialidade)
        modal.find('#recipient-banco').val(banco)
        modal.find('#recipient-tipo_conta').val(tipo_conta)
        modal.find('#recipient-agencia').val(agencia)
        modal.find('#recipient-conta').val(conta)
        modal.find('#recipient-pix').val(pix)

    })
</script>

<!-- -----------------------------------MODAL EDITAR CLIENTE----------------------------------------------------------------->
<div class="modal fade" id="editarColaborador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="processa_edit_colaborador.php" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-name" class="col-form-label">Nome</label>
                            <input type="text" class="form-control" id="recipient-name" name="nome">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="recipient-email" class="col-form-label">E-mail</label>
                            <input type="email" class="form-control" id="recipient-email" name="email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-rua" class="col-form-label">Rua</label>
                            <input type="text" class="form-control" id="recipient-rua" name="rua">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-numero" class="col-form-label">Nº</label>
                            <input type="text" name="numero" id="recipient-numero" class="form-control -10">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-bairro" class="col-form-label">Bairro</label>
                            <input type="text" name="bairro" id="recipient-bairro" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cidade" class="col-form-label">cidade</label>
                            <input type="text" name="cidade" id="recipient-cidade" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-cep" class="col-form-label">Cep</label>
                            <input type="text" name="cep" id="recipient-cep" maxlength="50" class="form-control">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-cidade" class="col-form-label">Cidade</label>
                            <input type="text" name="cidade" id="recipient-cidade" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-uf" class="col-form-label">UF</label>
                            <input type="text" name="uf" id="recipient-uf" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="recipient-telefone" class="col-form-label">Telefone</label>
                            <input type="text" name="telefone" id="recipient-telefone" onkeypress="mask(this, telefone);" onblur="mask(this, telefone);" class="form-control -10">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="recipient-celular" class="col-form-label">Celular</label>
                            <input type="text" name="celular" id="recipient-celular" maxlength="50" onkeypress="mask(this, celular);" onblur="mask(this, celular);" class="form-control -10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-cpf" class="col-form-label">CPF</label>
                            <input type="text" name="cpf" id="recipient-cpf" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-rg" class="col-form-label">RG</label>
                            <input type="text" name="rg" id="recipient-rg" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-nascimento" class="col-form-label">Nascimento</label>
                            <input type="text" name="nascimento" id="recipient-nascimento" class="form-control -10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-operador" class="col-form-label cli">Cadastrado por</label>
                            <input type="text" name="operador" id="recipient-operador" maxlength="50" class="form-control" disabled>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-dataCadastro" class="col-form-label">Data do cadastro</label>
                            <input type="text" class="form-control" id="recipient-dataCadastro" disabled>
                        </div>
                        <div class="col-md-4 col-sm-12">

                            <label for="recipient-situacao" class="col-form-label">Situação</label>
                            <select class="form-control form-select-lg mb-5 select2" name="situacao" id="recipient-situacao" aria-label=".form-select-lg example">
                                <option value="Pendente">Pendente</option>
                                <option value="Ativo">Ativo</option>
                                <option value="Inativo">Inativo</option>
                                <option value="Cancelado">Cancelado</option>

                            </select>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-operador" class="col-form-label cli">Alterado por</label>
                            <input type="text" name="alterado_por" id="recipient-alterado_por" maxlength="50" class="form-control" disabled value="<?php echo $_SESSION['usuarioNome'] ?>">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-dataCadastro" class="col-form-label">Última Alteração</label>
                            <input type="text" class="form-control" name="ultima_alteracao" id="recipientultima_alteracao" value="<?php echo date('d/m/Y - H:i:s') ?>" disabled>
                        </div>

                    </div>


                    <input type="hidden" name="id" class="form-control" id="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>

            </form>


        </div>
    </div>
</div>
<!-- -----------------------------------SCRIPT MODAL EDITAR CLIENTE----------------------------------------------------------------->
<script type="text/javascript">
    $('#editarColaborador').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botão que acionou o modal
        var recipient = button.data('whatever')
        var recipientnome = button.data('whatevernome')
        var recipientemail = button.data('whateveremail')
        var recipienttelefone = button.data('whatevertelefone')
        var recipientrua = button.data('whateverrua')
        var recipientnumero = button.data('whatevernumero')
        var recipientbairro = button.data('whateverbairro')
        var recipientcomplemento = button.data('whatevercomplemento')
        var recipientcep = button.data('whatevercep')
        var recipientcidade = button.data('whatevercidade')
        var recipientuf = button.data('whateveruf')
        var recipienttelefone = button.data('whatevertelefone')
        var recipientcelular = button.data('whatevercelular')
        var recipientcpf = button.data('whatevercpf')
        var recipientrg = button.data('whateverrg')
        var recipientnascimento = button.data('whatevernascimento')
        var recipientoperador = button.data('whateveroperador')
        var recipientsituacao = button.data('whateversituacao')
        var recipientdataCadastro = button.data('whateverdata-cadastro')
        var recipientalterado_por = button.data('whateveralterado_por')
        var recipientultima_alteracao = button.data('whateverultima_alteracao')

        var modal = $(this)
        modal.find('.modal-title').text('EDITAR CLIENTE CÓDIGO: ' + recipient)
        modal.find('#id').val(recipient)
        modal.find('#recipient-name').val(recipientnome)
        modal.find('#recipient-email').val(recipientemail)
        modal.find('#recipient-telefone').val(recipienttelefone)
        modal.find('#recipient-rua').val(recipientrua)
        modal.find('#recipient-numero').val(recipientnumero)
        modal.find('#recipient-bairro').val(recipientbairro)
        modal.find('#recipient-cidade').val(recipientcomplemento)
        modal.find('#recipient-cep').val(recipientcep)
        modal.find('#recipient-cidade').val(recipientcidade)
        modal.find('#recipient-uf').val(recipientuf)
        modal.find('#recipient-telefone').val(recipienttelefone)
        modal.find('#recipient-celular').val(recipientcelular)
        modal.find('#recipient-cpf').val(recipientcpf)
        modal.find('#recipient-rg').val(recipientrg)
        modal.find('#recipient-nascimento').val(recipientnascimento)
        modal.find('#recipient-operador').val(recipientoperador)
        modal.find('#recipient-situacao').val(recipientsituacao)
        modal.find('#recipient-dataCadastro').val(recipientdataCadastro)
        modal.find('#recipient-alterado_por').val(recipientalterado_por)
        modal.find('#recipientultima_alteracao').val(recipientultima_alteracao)

    })
</script>


<script>
    $(document).ready(function() {
        $(function() {
            //Pesquisar os cursos sem refresh na página
            $("#pesquisa_colaborador").keyup(function() {

                var pesquisa_colaborador = $(this).val();

                //Verificar se há algo digitado
                if (pesquisa_colaborador != '') {
                    var dados = {
                        palavra: pesquisa_colaborador
                    }
                    $.post('busca_colaboradors.php', dados, function(retorna) {
                        //Mostra dentro da ul os resultado obtidos
                        $(".resultado_colaborador").html(retorna);
                    });
                } else {
                    $(".resultado_colaborador").html('');
                }
            });
        });

    });
</script>