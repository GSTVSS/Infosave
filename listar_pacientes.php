<?php
session_start();
include_once('assets/cabecalho.php');
include_once('assets/rodape.php');
include('config/conexao.php');
include_once("config/seguranca.php");
seguranca_adm();
$consulta = "SELECT * FROM pacientes ";
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
        <input class="form-control me-2 h-40 p-4 shadow bg-body-tertiary rounded" type="search" name="pesquisa_paciente" placeholder="Buscar" aria-label="Buscar" required="autofocus">
        <button type="button" class="btn btn-primary btn-lg h-100 shadow rounded" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cadPacientes">Cadastrar</button>
    </div>
</div>
<div class="container-flex p-3 d-flex justify-content-center bg-secondary">
    <div class="fw-semibold">
        <div class="row">
            <div class="form-label-group">
                <div class="table-responsive">
                    <table class="resultado_paciente table table-striped table-hover table-bordered table-sm aling-middle table-secondary rounded shadow">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th scope="col">#</th>
                                <th scope="col">NOME</th>
                                <th scope="col">TOMADOR</th>
                                <th scope="col">CONTATO</th>
                                <th scope="col">POST</th>
                                <th scope="col">ENDEREÇO</th>
                                <th scope="col" class="text text-center" colspan="3">AÇÕES</th>
                            </tr>
                        </thead>
                        <?php while ($linha = mysqli_fetch_assoc($resultado)) {
                            $id_paciente = $linha['id_paciente'];
                            $consulta2 = "SELECT * from pacientes_especialidades WHERE id_paciente = '$id_paciente'";
                            $resultado2 = mysqli_query($conn, $consulta2);
                            $especialidades = [
                                'Terapeuta Ocupacional' =>  0,
                                'Psicólogo' => 0,
                                'Nutricionista' => 0,
                                'Médico' => 0,
                                'Fonoaudiólogo' => 0,
                                'Fisioterapeuta' => 0,
                                'Auxiliar de Enfermagem' => 0,
                                'Técnico de Enfermagem' => 0,
                                'Enfermeiro' => 0,
                                'Cuidador de Idosos' => 0
                            ];
                            while ($linha2 = mysqli_fetch_assoc($resultado2)) {
                                $especialidades[$linha2['especialidade']] = 1;
                            }
                            $nome = ucwords(strtolower($linha['nome']));
                            $telefone = $linha['telefone_residencia'];
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
                            $uf = $linha['uf'];

                            $endereco = $rua . ", " . $numero . " - " . $bairro . "-" . $cidade . "/" . $uf;
                        ?>
                            <tbody class="table-group-divider">
                                <tr>
                                    <td><?php echo $id_paciente ?></td>
                                    <td><?php echo ucwords(strtolower($nome)); ?></td>
                                    <td><?php echo $linha['tomador']; ?></td>
                                    <td><?php echo $linha['telefone_residencia']; ?></td>
                                    <td><?php echo $linha['post']; ?></td>
                                    <td><?php echo $endereco; ?></td>
                                    <td class="text text-center">
                                        <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#visulaizarPaciente" data-whatever=" <?php echo $linha['id_paciente']; ?>" data-whatevernome="<?php echo ucwords(strtolower($linha['nome'])); ?>" data-whateversexo="<?php echo $linha['sexo']; ?>" data-whatevernascimento="<?php echo $linha['nascimento']; ?>" data-whatevertelefone_residencia="<?php echo $linha['telefone_residencia']; ?>" data-whatevertomador="<?php echo $linha['tomador']; ?>" data-whateverdiagnostico="<?php echo $linha['diagnostico']; ?>" data-whateverpad_autorizado="<?php echo $linha['pad_autorizado']; ?>" data-whateverpost="<?php echo $linha['post']; ?>" data-whatevercep="<?php echo $linha['cep']; ?>" data-whateveruf="<?php echo $linha['uf']; ?>" data-whatevercidade="<?php echo $linha['cidade']; ?>" data-whateverbairro="<?php echo $linha['bairro']; ?>" data-whateverrua="<?php echo $linha['rua']; ?>" data-whatevernumero="<?php echo $linha['numero']; ?>" data-whateverregiao="<?php echo $linha['regiao']; ?>" data-whatevercriado_por="<?php echo $criado_por; ?>" data-whateverdata_cadastro="<?php echo $linha['data_cadastro']; ?>" data-whateversituacao="<?php echo $situacao; ?>" data-whateveralterado_por="<?php echo $linha['alterado_por']; ?>" data-whateverultima_alteracao="<?php echo $linha['ultima_alteracao']; ?>" data-whateverterapeuta_ocupacional="<?php echo $especialidades['Terapeuta Ocupacional']; ?>" data-whateverpsicologo="<?php echo $especialidades['Psicólogo']; ?>" data-whatevernutricionista="<?php echo $especialidades['Nutricionista']; ?>" data-whatevermedico="<?php echo $especialidades['Médico']; ?>" data-whateverfonoaudiólogo="<?php echo $especialidades['Fonoaudiólogo']; ?>" data-whateverfisioterapeuta="<?php echo $especialidades['Fisioterapeuta']; ?>" data-whateverenfermeiro="<?php echo $especialidades['Enfermeiro']; ?>" data-whatevercuidador_idosos="<?php echo $especialidades['Cuidador de Idosos']; ?>" data-whateverauxilia_enfermagem="<?php echo $especialidades['Auxiliar de Enfermagem']; ?>" data-whatevertecnico_enfermagem="<?php echo $especialidades['Técnico de Enfermagem']; ?>">
                                            <i class="far fa-eye text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"></i>
                                        </a>
                                    </td>
                                    <td class="text text-center">
                                        <a href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#editarPaciente" data-whatever="<?php echo $linha['id_paciente']; ?>" data-whatevernome="<?php echo ucwords(strtolower($linha['nome'])); ?>" data-whateversexo="<?php echo $linha['sexo']; ?>" data-whatevernascimento="<?php echo $linha['nascimento']; ?>" data-whatevertelefone_residencia="<?php echo $linha['telefone_residencia']; ?>" data-whatevertomador="<?php echo $linha['tomador']; ?>" data-whateverdiagnostico="<?php echo $linha['diagnostico']; ?>" data-whateverpad_autorizado="<?php echo $linha['pad_autorizado']; ?>" data-whateverpost="<?php echo $linha['post']; ?>" data-whatevercep="<?php echo $linha['cep']; ?>" data-whateveruf="<?php echo $linha['uf']; ?>" data-whatevercidade="<?php echo $linha['cidade']; ?>" data-whateverbairro="<?php echo $linha['bairro']; ?>" data-whateverrua="<?php echo $linha['rua']; ?>" data-whatevernumero="<?php echo $linha['numero']; ?>" data-whateverregiao="<?php echo $linha['regiao']; ?>" data-whatevercriado_por="<?php echo $criado_por; ?>" data-whateverdata_cadastro="<?php echo $linha['data_cadastro']; ?>" data-whateversituacao="<?php echo $situacao; ?>" data-whateveralterado_por="<?php echo $linha['alterado_por']; ?>" data-whateverultima_alteracao="<?php echo $linha['ultima_alteracao']; ?>" data-whateverterapeuta_ocupacional="<?php echo $especialidades['Terapeuta Ocupacional']; ?>" data-whateverpsicologo="<?php echo $especialidades['Psicólogo']; ?>" data-whatevernutricionista="<?php echo $especialidades['Nutricionista']; ?>" data-whatevermedico="<?php echo $especialidades['Médico']; ?>" data-whateverfonoaudiólogo="<?php echo $especialidades['Fonoaudiólogo']; ?>" data-whateverfisioterapeuta="<?php echo $especialidades['Fisioterapeuta']; ?>" data-whateverenfermeiro="<?php echo $especialidades['Enfermeiro']; ?>" data-whatevercuidador_idosos="<?php echo $especialidades['Cuidador de Idosos']; ?>" data-whateverauxilia_enfermagem="<?php echo $especialidades['Auxiliar de Enfermagem']; ?>" data-whatevertecnico_enfermagem="<?php echo $especialidades['Técnico de Enfermagem']; ?>">
                                            <i class="far fa-edit text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i></a>
                                    </td>
                                    <td class="text text-center">
                                        <a href="processa_excluir_pacientes.php?id_paciente=<?php echo $linha['id_paciente']; ?>" onClick="return confirm('Deseja realmente deletar o paciente?')">
                                            <i class="far fa-trash-alt text text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"></i>
                                        </a>
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


<!-- ================================== MODAL CADASTRAR PACOEM----------------------------------------------------------------->
<style>
    .errorInput {
        border: 2px solid red !important;
    }
</style>
<script>
    // ================================ FUNÇÃO PARA MASCARA DE TELEFONE =============================================
    function mask(o) {
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

    // FUNÇÃO PARA ADICONAR ENDEREÇO VIA CEP (https://viacep.com.br/exemplo/javascript/)
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
        console.log("pesquisando")

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

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

            var nome = $('#name'); // PEGA O CAMPO PACOEM DO FORM
            var telefone = $('#telefone_residencia'); // PEGA O CAMPO TELEFONE DO FORM


            var erro = $('.alert-danger'); // PEGA O CAMPO COM A class alert e CRIA A VARIAVEL erro
            var campo = $('#campo-erro'); // CRIA A VARIAVEL PATA EXIBIR O NOME DO CAMPO COM ERROcampo-sucesso


            erro.addClass('d-none');
            $('.is-invalid').removeClass('is-invalid');
            $('.is-valid').removeClass('is-valid');


            if (!nome.val().match(/[A-Za-z\d]/)) {
                erro.removeClass('d-none'); //REMOVE A CLASSE (d-none) DO BOOTSTRAP E EXIBE O ALERTA
                campo.html('paciente'); // ADICIONA AO ALERTA O NOME DO CAMPO NAO PREENCHIDO
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
                $.post("cadastro_pacientes.php", dados, function(retorna) {
                    if (retorna) {
                        //Limpar os campo
                        $('#insert_form')[0].reset();

                        //Fechar a janela modal cadastrar
                        $('#cadPacientes').modal('hide');
                        $('#sucessModal').modal('show');

                        setInterval(function() {
                            var redirecionar = "listar_pacientes.php";
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
                PACIENTE CADASTRADO COM SUCESSO!
            </div>
            <div class="modal-footer"> </div>
        </div>
    </div>
</div>
<!-- Modal ALERTA DE CADASTRO NAO REALIZADO-->
<div class="modal fade" id="dangerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">aa
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body bg-danger text text-center text-white">
                PACIENTE NÃO CADASTRADO!
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<!-- ==================================================MODAL CADASTRO DE PACIENTE ==================================== -->
<div class="modal fade" id="cadPacientes" tabindex="-1" aria-labelledby="exempleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-light">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title fw-bolder" id="exempleModalLabel">Cadastrar Paciente</h5>

                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
            </div>

            <div class="alert alert-danger d-none fade show m-3" role="alert">
                <strong>ERRO!</strong> - <strong> Preencha todos os campos <span id="campo-erro"></span></strong>!
                <span id="msg"></span>
            </div>

            <div class="modal-body bg-secondary" onpaste="return false">
                <br>
                <h5 class="text-center p-2 fw-bolder">Dados Pessoais</h5>
                <form method="POST" id="insert_form">
                    <div class="row">
                        <div class="col-12">
                            <label for="recipient-name" class="col-form-label fw-semibold">Nome Completo</label>
                            <input type="text" class="form-control fw-semibold required opacity-75" name="nome" id="name">
                        </div>
                        <div class="col-4">
                            <label for="recipient-sexo" class="col-form-label fw-semibold">Sexo</label>
                            <select class="form-control form-select opacity-75" name="sexo" id="sexo" aria-label="form-select">
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMININO">FEMININO</option>
                                <option value="OUTRO">OUTRO</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="recipient-nascimento" class="col-form-label fw-semibold">Data de Nascimento</label>
                            <input type="text" class="form-control required opacity-75" name="nascimento" id="nascimento">
                        </div>
                        <div class="col-4">
                            <label for="recipient-telefone_residencia" class="col-form-label fw-semibold">Contato</label>
                            <input type="text" max="15" class="form-control required opacity-75" name="telefone_residencia" id="telefone_residencia" onkeyup="mask(this)">
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Quadro do Paciente</h5>
                    <div class="row">
                        <div class="col-4">
                            <label for="recipient-tomador" class="col-form-label fw-semibold">Tomador</label>
                            <select class="form-control form-select required opacity-75" name="tomador" id="tomador" aria-label="form-select">
                                <option value="DOMICILIE">DOMICILIE</option>
                                <option value="IDEAL CARE">IDEAL CARE</option>
                                <option value="MAX">MAX</option>
                                <option value="MODELOS">MODELOS</option>
                                <option value="PIONNIER">PIONNIER</option>
                                <option value="QUALIFIC">QUALIFIC</option>
                                <option value="QUALIFICSP">QUALIFIC-SP</option>
                                <option value="TRUE CARE">TRUE CARE</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="recipient-name" class="col-form-label fw-semibold">Pad</label>
                            <select class="form-control form-select required opacity-75" name="pad" id="pad_autorizado" aria-label="form-select">
                                <option value="6">06 Horas</option>
                                <option value="12">12 Horas</option>
                                <option value="24">24 Horas</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="recipient-especialidade" class="col-form-label fw-semibold">Especialidade</label>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="nutricionista" name="nutricionista">
                                        <label class="form-check-label" for="nutricionista">Nutricionista</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="medico" name="medico">
                                        <label class="form-check-label" for="medico">Médico</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="fonoaudilogo" name="fonoaudilogo">
                                        <label class="form-check-label" for="fonoaudilogo">Fonoaudiólogo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="fisioterapeuta" name="fisioterapeuta">
                                        <label class="form-check-label" for="fisioterapeuta">Fisioterapeuta</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="auxiliar_enfermagem" name="auxiliar_enfermagem">
                                        <label class="form-check-label" for="auxiliar_enfermagem">Auxiliar de Enfermagem</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="tecnico_enfermagem" name="tecnico_enfermagem">
                                        <label class="form-check-label" for="tecnico_enfermagem">Técnico de Enfermagem</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="enfermeiro" name="enfermeiro">
                                        <label class="form-check-label" for="enfermeiro">Enfermeiro</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="cuidador_idosos" name="cuidador_idosos">
                                        <label class="form-check-label" for="cuidador_idosos">Cuidador de Idosos</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="terapeuta_ocupacional" name="terapeuta_ocupacional">
                                        <label class="form-check-label" for="cuidador">Terapeuta Ocupacional</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="psicologo" name="psicologo">
                                        <label class="form-check-label" for="cuidador">Psicólogo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="mb-3">
                            <label for="recipient-diagnostico" class="form-label fw-semibold">Diagnostico</label>
                            <br>
                            <textarea id="diagnostico" class="form-control opacity-75" rows="10" name="diagnostico"></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label fw-semibold">Poster</label>
                            <br>
                            <textarea class="form-control opacity-75" id="post" rows="10" name="post">🩺Amor em Cuidar🩺
Profissão: TEC/AUX ENFERMAGEM
Coren: Ativo
Sexo: 
PAD: 12h/12h, DI - NI - DP - NP
------------- 
Paciente: Sexo, Idade
Endereço:
------------- 
HD:
DPS:</textarea>
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Endereço</h5>
                    <div class="row">
                        <div class="col-6">
                            <label for="recipient-cidade" class="col-form-label fw-semibold">Cidade</label>
                            <input type="text" name="cidade" id="cidade" maxlength="50" class="form-control opacity-75">
                        </div>
                        <div class="col-6">
                            <label for="recipient-rua" class="col-form-label fw-semibold">Rua</label>
                            <input type="text" name="rua" id="rua" maxlength="50" class="form-control opacity-75">
                        </div>
                        <div class="col-2">
                            <label for="recipient-cep" class="col-form-label fw-semibold">Cep</label>
                            <input type="text" name="cep" id="cep" maxlength="50" class="form-control opacity-75" onblur="pesquisacep(this.value)">
                        </div>
                        <div class="col-2">
                            <label for="recipient-uf" class="col-form-label fw-semibold">UF</label>
                            <input type="text" name="uf" id="uf" maxlength="50" class="form-control opacity-75">
                        </div>

                        <div class="col-2">
                            <label for="recipient-bairro" class="col-form-label fw-semibold">Bairro</label>
                            <input type="text" name="bairro" id="bairro" maxlength="50" class="form-control opacity-75">
                        </div>
                        <div class="col-2">
                            <label for="recipient-numero" class="col-form-label fw-semibold">Nº</label>
                            <input type="text" name="numero" id="numero" maxlength="50" class="form-control opacity-75">
                        </div>
                        <div class="col-2">
                            <label for="recipient-regiao" class="col-form-label fw-semibold">Região</label>
                            <input type="text" name="regiao" id="regiao" maxlength="50" class="form-control opacity-75">
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Informarções adicionais</h5>
                    <div class="row">
                        <div class="col-4">
                            <label for="recipient-criado_por" class="form-label fw-semibold ">Operador</label>
                            <input type="text" name="criado_por" id="criado_por" maxlength="50" class="form-control opacity-75" value="<?php echo $_SESSION['usuarioNome'] ?>" disabled>
                        </div>
                        <div class="col-4">
                            <label for="recipient-data_cadastro" class="form-label fw-semibold ">Data do cadastro</label>
                            <input type="text" class="form-control opacity-75" disabled value="<?php echo date('d/m/Y - H:i:s') ?>">
                        </div>
                        <div class="col-4">
                            <label for="recipient-situacao" class="form-label fw-semibold">Situação</label>
                            <select class="form-control form-select opacity-75" name="situacao" id="situacao" aria-label="form-select">
                                <option value="PENDENTE">Aguardando Liberação</option>
                                <option value="ATIVO">Ativo</option>
                                <option value="HOSPITALIZADO">Hospitalizado</option>
                                <option value="MIGRAÇÃO">Migrado</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-3 bg-secondary"></div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btn-cadastrar">Salvar</button>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- EDITAR A PARTIR DAQUI -->
<!-- -----------------------------------MODAL VISUALIZAR PACIENTE----------------------------------------------------------------->
<div class="modal fade" id="visualizarPaciente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl text-light">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title fw-bolder" id="exempleModalLabel">Visualizar Paciente</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-secondary">
                <br>
                <h5 class="text-center p-2 fw-bolder">Dados Pessoais</h5>
                <form method="POST" id="cadastro_pacientes.php">
                    <div class="row">
                        <div class="col-12">
                            <label for="recipient-name" class="col-form-label fw-semibold">Nome Completo</label>
                            <input type="text" class="form-control fw-semibold required opacity-75" name="nome" id="name" disabled>
                        </div>
                        <div class="col-4">
                            <label for="recipient-sexo" class="col-form-label fw-semibold">Sexo</label>
                            <select class="form-control form-select opacity-75" name="sexo" id="sexo" aria-label="form-select" disabled>
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMININO">FEMININO</option>
                                <option value="OUTRO">OUTRO</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="recipient-nascimento" class="col-form-label fw-semibold">Data de Nascimento</label>
                            <input type="text" class="form-control required opacity-75" name="nascimento" id="nascimento" disabled>
                        </div>
                        <div class="col-4">
                            <label for="recipient-telefone_residencia" class="col-form-label fw-semibold">Contato</label>
                            <input type="text" max="15" class="form-control required opacity-75" name="telefone_residencia" id="telefone_residencia" onkeyup="mask(this)" disabled>
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Quadro do Paciente</h5>
                    <div class="row">
                        <div class="col-4">
                            <label for="recipient-tomador" class="col-form-label fw-semibold">Tomador</label>
                            <select class="form-control form-select required opacity-75" name="tomador" id="tomador" aria-label="form-select"disabled>
                                <option value="DOMICILIE">DOMICILIE</option>
                                <option value="IDEAL CARE">IDEAL CARE</option>
                                <option value="MAX">MAX</option>
                                <option value="MODELOS">MODELOS</option>
                                <option value="PIONNIER">PIONNIER</option>
                                <option value="QUALIFIC">QUALIFIC</option>
                                <option value="QUALIFICSP">QUALIFIC-SP</option>
                                <option value="TRUE CARE">TRUE CARE</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="recipient-name" class="col-form-label fw-semibold">Pad</label>
                            <select class="form-control form-select required opacity-75" name="pad" id="pad_autorizado" aria-label="form-select" disabled>
                                <option value="6">06 Horas</option>
                                <option value="12">12 Horas</option>
                                <option value="24">24 Horas</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="recipient-especialidade" class="col-form-label fw-semibold">Especialidade</label>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="nutricionista" name="nutricionista" disabled>
                                        <label class="form-check-label" for="nutricionista">Nutricionista</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="medico" name="medico" disabled>
                                        <label class="form-check-label" for="medico">Médico</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="fonoaudilogo" name="fonoaudilogo" disabled>
                                        <label class="form-check-label" for="fonoaudilogo">Fonoaudiólogo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="fisioterapeuta" name="fisioterapeuta" disabled>
                                        <label class="form-check-label" for="fisioterapeuta">Fisioterapeuta</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="auxiliar_enfermagem" name="auxiliar_enfermagem" disabled>
                                        <label class="form-check-label" for="auxiliar_enfermagem">Auxiliar de Enfermagem</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="tecnico_enfermagem" name="tecnico_enfermagem" disabled>
                                        <label class="form-check-label" for="tecnico_enfermagem">Técnico de Enfermagem</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="enfermeiro" name="enfermeiro" disabled>
                                        <label class="form-check-label" for="enfermeiro">Enfermeiro</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="cuidador_idosos" name="cuidador_idosos" disabled>
                                        <label class="form-check-label" for="cuidador_idosos">Cuidador de Idosos</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="terapeuta_ocupacional" name="terapeuta_ocupacional" disabled>
                                        <label class="form-check-label" for="cuidador">Terapeuta Ocupacional</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input opacity-75" id="psicologo" name="psicologo" disabled>
                                        <label class="form-check-label" for="cuidador">Psicólogo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="mb-3">
                            <label for="recipient-diagnostico" class="form-label fw-semibold">Diagnostico</label>
                            <br>
                            <textarea id="diagnostico" class="form-control opacity-75" rows="10" name="diagnostico" disabled></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label fw-semibold">Poster</label>
                            <br>
                            <textarea class="form-control opacity-75" id="post" rows="10" name="post" disabled>🩺Amor em Cuidar🩺
Profissão: TEC/AUX ENFERMAGEM
Coren: Ativo
Sexo: 
PAD: 12h/12h, DI - NI - DP - NP
------------- 
Paciente: Sexo, Idade
Endereço:
------------- 
HD:
DPS:</textarea>
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Endereço</h5>
                    <div class="row">
                        <div class="col-6">
                            <label for="recipient-cidade" class="col-form-label fw-semibold">Cidade</label>
                            <input type="text" name="cidade" id="cidade" maxlength="50" class="form-control opacity-75" disabled>
                        </div>
                        <div class="col-6">
                            <label for="recipient-rua" class="col-form-label fw-semibold">Rua</label>
                            <input type="text" name="rua" id="rua" maxlength="50" class="form-control opacity-75" disabled>
                        </div>
                        <div class="col-2">
                            <label for="recipient-cep" class="col-form-label fw-semibold">Cep</label>
                            <input type="text" name="cep" id="cep" maxlength="50" class="form-control opacity-75" onblur="pesquisacep(this.value)" disabled>
                        </div>
                        <div class="col-2">
                            <label for="recipient-uf" class="col-form-label fw-semibold">UF</label>
                            <input type="text" name="uf" id="uf" maxlength="50" class="form-control opacity-75" disabled>
                        </div>

                        <div class="col-2">
                            <label for="recipient-bairro" class="col-form-label fw-semibold">Bairro</label>
                            <input type="text" name="bairro" id="bairro" maxlength="50" class="form-control opacity-75" disabled>
                        </div>
                        <div class="col-2">
                            <label for="recipient-numero" class="col-form-label fw-semibold">Nº</label>
                            <input type="text" name="numero" id="numero" maxlength="50" class="form-control opacity-75" disabled>
                        </div>
                        <div class="col-2">
                            <label for="recipient-regiao" class="col-form-label fw-semibold">Região</label>
                            <input type="text" name="regiao" id="regiao" maxlength="50" class="form-control opacity-75" disabled>
                        </div>
                    </div>
                    <br>
                    <h5 class="text-center p-2 fw-bolder">Informarções adicionais</h5>
                    <div class="row">
                        <div class="col-4">
                            <label for="recipient-criado_por" class="form-label fw-semibold ">Operador</label>
                            <input type="text" name="criado_por" id="criado_por" maxlength="50" class="form-control opacity-75" value="<?php echo $_SESSION['usuarioNome'] ?>" disabled>
                        </div>
                        <div class="col-4">
                            <label for="recipient-data_cadastro" class="form-label fw-semibold ">Data do cadastro</label>
                            <input type="text" class="form-control opacity-75" disabled value="<?php echo date('d/m/Y - H:i:s') ?>" disabled>
                        </div>
                        <div class="col-4">
                            <label for="recipient-situacao" class="form-label fw-semibold">Situação</label>
                            <select class="form-control form-select opacity-75" name="situacao" id="situacao" aria-label="form-select" disabled>
                                <option value="PENDENTE">Aguardando Liberação</option>
                                <option value="ATIVO">Ativo</option>
                                <option value="HOSPITALIZADO">Hospitalizado</option>
                                <option value="MIGRAÇÃO">Migrado</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-3 bg-secondary"></div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- -----------------------------------SCRIPT MODAL VISUALIZAR PACOEM----------------------------------------------------------------->
<script type="text/javascript">
    console.log("Visualizando");
    $('#visulaizarPaciente').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botão que acionou o modal
        var recipient = button.data('whatever')
        var recipientnome = button.data('whatevernome')
        var recipientsexo = button.data('whateversexo')
        var recipientnascimento = button.data('whatevernascimento')
        var recipientcontato = button.data('whatevertelefone_residencia')
        var recipienttomador = button.data('whatevertomador')
        var recipientdiagnostico = button.data('whateverdiagnostico')
        var recipientespecialidade = button.data('whateverespecialidade')
        var recipientPAD = button.data('whateverpad_autorizado')
        var recipientpost = button.data('whateverpost')
        var recipientcep = button.data('whatevercep')
        var recipientuf = button.data('whateveruf')
        var recipientcidade = button.data('whatevercidade')
        var recipientbairro = button.data('whateverrua')
        var recipientnumero = button.data('whatevernumero')
        var recipientregiao = button.data('whateverregiao')
        var recipientcriado_por = button.data('whatevercriado_por')
        var recipientdata_cadastro = button.data('whateverdata_cadastro')
        var recipientsituacao = button.data('whateversituacao')
        var recipientalterado_por = button.data('whateveralterado_por')
        var recipientultima_alteracao = button.data('whateverultima_alteracao')
        var recipienttelefone_residencia = button.data('whatevertelefone_residencia')
        var recipientpad_autorizado = button.data('whateverpad_autorizado')
        var recipientterapeuta_ocupacional = button.data('whateverterapeuta_ocupacional')
        var recipientpsicologo = button.data('whateverpsicologo')
        var recipientnutricionista = button.data('whatevernutricionista')
        var recipientmedico = button.data('whatevermedico')
        var recipientfonoaudiólogo = button.data('whateverfonoaudiólogo')
        var recipientfisioterapeuta = button.data('whateverfisioterapeuta')
        var recipientenfermeiro = button.data('whateverenfermeiro')
        var recipientcuidador_idosos = button.data('whatevercuidador_idosos')
        var recipientauxilia_enfermagem = button.data('whateverauxilia_enfermagem')
        var recipienttecnico_enfermagem = button.data('whatevertecnico_enfermagem')
        var modal = $(this)

        modal.find('.modal-title').text('VISUALIZAR PACIENTE CÓDIGO: ' + recipient)
        modal.find('#id').val(recipient)
        modal.find('#recipient-sexo').val(recipientsexo)
        modal.find('#recipient-nascimento').val(recipientnascimento)
        modal.find('#recipient-telefone_residencia').val(recipienttelefone_residencia)
        modal.find('#recipient-tomador').val(recipienttomador)
        modal.find('#recipient-name').val(recipientnome)
        modal.find('#recipient-diagnostico').val(recipientdiagnostico)
        modal.find('#recipient-especialidade').val(recipientespecialidade)
        modal.find('#recipient-pad_autorizado').val(recipientpad_autorizado)
        modal.find('#recipient-post').val(recipientpost)
        modal.find('#recipient-cep').val(recipientcep)
        modal.find('#recipient-uf').val(recipientuf)
        modal.find('#recipient-cidade').val(recipientcidade)
        modal.find('#recipient-bairro').val(recipientbairro)
        modal.find('#recipient-rua').val(recipientbairro)
        modal.find('#recipient-regiao').val(recipientregiao)
        modal.find('#recipient-criado_por').val(recipientcriado_por)
        modal.find('#recipient-data_cadastro').val(recipientdata_cadastro)
        modal.find('#recipient-situacao').val(recipientsituacao)
        modal.find('#recipient-alterado_por').val(recipientalterado_por)
        modal.find('#recipientultima_alteracao').val(recipientultima_alteracao)
        modal.find('#recipient-psicologo').prop("checked", (recipientpsicologo == 1) ? true : false);
        modal.find('#recipient-terapeuta_ocupacional').prop("checked", (recipientterapeuta_ocupacional == 1) ? true : false);
        modal.find('#recipient-nutricionista').prop("checked", (recipientnutricionista) ? true : false);
        modal.find('#recipient-medico').prop("checked", (recipientmedico) ? true : false);
        modal.find('#recipient-fonoaudiólogo').prop("checked", (recipientfonoaudiólogo) ? true : false);
        modal.find('#recipient-fisioterapeuta').prop("checked", (recipientfisioterapeuta) ? true : false);
        modal.find('#recipient-enfermeiro').prop("checked", (recipientenfermeiro) ? true : false);
        modal.find('#recipient-cuidador_idosos').prop("checked", (recipientcuidador_idosos) ? true : false);
        modal.find('#recipient-auxilia_enfermagem').prop("checked", (recipientauxilia_enfermagem) ? true : false);
        modal.find('#recipient-tecnico_enfermagem').prop("checked", (recipienttecnico_enfermagem) ? true : false);

    })
</script>

<!-- -----------------------------------MODAL EDITAR PACOEM----------------------------------------------------------------->
<div class="modal fade" id="editarPaciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="processa_edit_paciente.php" enctype="multipart/form-data">
                    <!--//dados pessoais//-->
                    <div class="row">
                        <div class="col-6">
                            <label for="recipient-name" class="col-form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="recipient-name">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-sexo" class="col-form-label">Sexo</label>
                            <input type="text" class="form-control" name="sexo" id="recipient-sexo">
                        </div>
                        <div class="col-6">
                            <label for="recipient-nascimento" class="col-form-label">Data de Nascimento</label>
                            <input type="text" class="form-control" name="nascimento" id="recipient-nascimento">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-telefone_residencia" class="col-form-label">Contato</label>
                            <input type="text" class="form-control" name="telefone_residencia" id="recipient-telefone_residencia">
                        </div>
                    </div>
                    <!--//informações do quadro do paciente//-->
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-tomador" class="col-form-label">Tomador</label>
                            <select class="form-control form-select-lg select2" name="tomador" id="recipient-tomador" aria-label=".form-select-lg example">
                                <option value="DOMICILIE">DOMICILIE</option>
                                <option value="IDEAL CARE">IDEAL CARE</option>
                                <option value="MAX">MAX</option>
                                <option value="MODELOS">MODELOS</option>
                                <option value="PIONNIER">PIONNIER</option>
                                <option value="QUALIFIC">QUALIFIC</option>
                                <option value="QUALIFICSP">QUALIFICSP</option>
                                <option value="TRUE CARE">TRUE CARE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-especialidade" class="col-form-label">Especialidade</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-nutricionista" name="nutricionista">
                                        <label class="form-check-label" for="nutricionista">Nutricionista</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-medico" name="medico">
                                        <label class="form-check-label" for="medico">Médico</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-fonoaudilogo" name="fonoaudilogo">
                                        <label class="form-check-label" for="fonoaudilogo">Fonoaudiólogo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-fisioterapeuta" name="fisioterapeuta">
                                        <label class="form-check-label" for="fisioterapeuta">Fisioterapeuta</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-auxiliar_enfermagem" name="auxiliar_enfermagem">
                                        <label class="form-check-label" for="auxiliar_enfermagem">Auxiliar de Enfermagem</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-tecnico_enfermagem" name="tecnico_enfermagem">
                                        <label class="form-check-label" for="tecnico_enfermagem">Técnico de Enfermagem</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipiente-enfermeiro" name="enfermeiro">
                                        <label class="form-check-label" for="enfermeiro">Enfermeiro</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-cuidador_idosos" name="cuidador_idosos">
                                        <label class="form-check-label" for="cuidador_idosos">Cuidador de Idosos</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-terapeuta_ocupacional" name="terapeuta_ocupacional">
                                        <label class="form-check-label" for="cuidador">Terapeuta Ocupacional</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="recipient-psicologo" name="psicologo">
                                        <label class="form-check-label" for="cuidador">Psicólogo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-diagnostico" class="col-form-label">Diagnostico</label>
                            <textarea class="form-control" name="diagnostico" id="recipient-diagnostico" rows="5"></textarea>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-especialidade" class="col-form-label">Especialidade</label>
                            <input type="text" class="form-control" id="recipient-especialidade">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-pad_autorizado" class="col-form-label">PAD</label>
                            <input type="text" name="pad" id="recipient-pad_autorizado" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <label for="recipient-post" class="col-form-label">Poster</label>
                            <textarea class="form-control" name="post" id="recipient-post" rows="5"></textarea>
                        </div>
                    </div>
                    <!--//informações sobre o endereço do paciente//-->
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cep" class="col-form-label">Cep</label>
                            <input type="text" name="cep" id="recipient-cep" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-uf" class="col-form-label">UF</label>
                            <input type="text" name="uf" id="recipient-uf" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <label for="recipient-cidade" class="col-form-label">Cidade</label>
                            <input type="text" name="cidade" id="recipient-cidade" maxlength="50" class="form-control -10">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-bairro" class="col-form-label">Bairro</label>
                            <input type="text" name="bairro" id="recipient-bairro" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-rua" class="col-form-label">Rua</label>
                            <input type="text" name="rua" id="recipient-rua" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-numero" class="col-form-label">Nº</label>
                            <input type="text" name="numero" id="recipient-numero" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <label for="recipient-regiao" class="col-form-label">Região</label>
                            <input type="text" name="regiao" id="recipient-regiao" maxlength="50" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-criado_por" class="col-form-label cli">Cadastrado por</label>
                            <input type="text" name="criado_por" id="recipient-criado_por" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-data_cadastro" class="col-form-label">Data do cadastro</label>
                            <input type="text" class="form-control" id="recipient-data_cadastro">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-situacao" class="col-form-label">Situação</label>
                            <select class="form-control form-select-lg mb-5 select2" name="situacao" id="recipient-situacao" aria-label=".form-select-lg example">
                                <option value="PENDENTE">Aguardando Liberação</option>
                                <option value="ATIVO">Ativo</option>
                                <option value="HOSPITALIZADO">Hospitalizado</option>
                                <option value="MIGRAÇÃO">Migrado</option>
                            </select>
                        </div>
                    </div>
                    <form class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-alterado_por" class="col-form-label cli">Alterado por</label>
                            <input type="text" name="alterado_por" id="recipient-alterado_por" maxlength="50" class="form-control" disabled>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="recipient-ultima_alteracao" class="col-form-label">Última Alteração</label>
                            <input type="text" class="form-control" name="ultima_alteracao" id="recipient-ultima_alteracao" disabled>
                        </div>
                    </form>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- -----------------------------------SCRIPT MODAL EDITAR PACOEM----------------------------------------------------------------->
<script type="text/javascript">
    $('#editarPaciente').on('show.bs.modal', function(event) {
        console.log("Editado");
        var button = $(event.relatedTarget) // Botão que acionou o modal
        var recipient = button.data('whatever')
        var recipientnome = button.data('whatevernome')
        var recipientsexo = button.data('whateversexo')
        var recipientnascimento = button.data('whatevernascimento')
        var recipientcontato = button.data('whatevertelefone_residencia')
        var recipienttomador = button.data('whatevertomador')
        var recipientdiagnostico = button.data('whateverdiagnostico')
        var recipientespecialidade = button.data('whateverespecialidade')
        var recipienttelefone_residencia = button.data('whatevertelefone_residencia')
        var recipientPAD = button.data('whateverpad_autorizado')
        var recipientpost = button.data('whateverpost')
        var recipientcep = button.data('whatevercep')
        var recipientuf = button.data('whateveruf')
        var recipientcidade = button.data('whatevercidade')
        var recipientbairro = button.data('whateverrua')
        var recipientnumero = button.data('whatevernumero')
        var recipientregiao = button.data('whateverregiao')
        var recipientcriado_por = button.data('whatevercriado_por')
        var recipientdata_cadastro = button.data('whateverdata_cadastro')
        var recipientsituacao = button.data('whateversituacao')
        var recipientalterado_por = button.data('whateveralterado_por')
        var recipientultima_alteracao = button.data('whateverultima_alteracao')
        var recipientterapeuta_ocupacional = button.data('whateverterapeuta_ocupacional')
        var recipientpsicologo = button.data('whateverpsicologo')
        var recipientnutricionista = button.data('whatevernutricionista')
        var recipientmedico = button.data('whatevermedico')
        var recipientfonoaudiólogo = button.data('whateverfonoaudiólogo')
        var recipientfisioterapeuta = button.data('whateverfisioterapeuta')
        var recipientenfermeiro = button.data('whateverenfermeiro')
        var recipientcuidador_idosos = button.data('whatevercuidador_idosos')
        var recipientauxilia_enfermagem = button.data('whateverauxilia_enfermagem')
        var recipienttecnico_enfermagem = button.data('whatevertecnico_enfermagem')
        var modal = $(this)

        modal.find('.modal-title').text('EDITAR PACIENTE CÓDIGO: ' + recipient)
        modal.find('#id').val(recipient)
        modal.find('#recipient-name').val(recipientnome)
        modal.find('#recipient-sexo').val(recipientsexo)
        modal.find('#recipient-nascimento').val(recipientnascimento)
        modal.find('#recipient-telefone_residencia').val(recipienttelefone_residencia)
        modal.find('#recipient-tomador').val(recipienttomador)
        modal.find('#recipient-diagnostico').val(recipientdiagnostico)
        modal.find('#recipient-especialidade').val(recipientespecialidade)
        modal.find('#recipient-pad_autorizado').val(recipientPAD)
        modal.find('#recipient-post').val(recipientpost)
        modal.find('#recipient-cep').val(recipientcep)
        modal.find('#recipient-uf').val(recipientuf)
        modal.find('#recipient-cidade').val(recipientcidade)
        modal.find('#recipient-bairro').val(recipientbairro)
        modal.find('#recipient-rua').val(recipientbairro)
        modal.find('#recipient-regiao').val(recipientregiao)
        modal.find('#recipient-criado_por').val(recipientcriado_por)
        modal.find('#recipient-data_cadastro').val(recipientdata_cadastro)
        modal.find('#recipient-situacao').val(recipientsituacao)
        modal.find('#recipient-alterado_por').val(recipientalterado_por)
        modal.find('#recipientultima_alteracao').val(recipientultima_alteracao)
        modal.find('#recipient-psicologo').prop("checked", (recipientpsicologo == 1) ? true : false);
        modal.find('#recipient-terapeuta_ocupacional').prop("checked", (recipientterapeuta_ocupacional == 1) ? true : false);
        modal.find('#recipient-nutricionista').prop("checked", (recipientnutricionista) ? true : false);
        modal.find('#recipient-medico').prop("checked", (recipientmedico) ? true : false);
        modal.find('#recipient-fonoaudiólogo').prop("checked", (recipientfonoaudiólogo) ? true : false);
        modal.find('#recipient-fisioterapeuta').prop("checked", (recipientfisioterapeuta) ? true : false);
        modal.find('#recipient-enfermeiro').prop("checked", (recipientenfermeiro) ? true : false);
        modal.find('#recipient-cuidador_idosos').prop("checked", (recipientcuidador_idosos) ? true : false);
        modal.find('#recipient-auxilia_enfermagem').prop("checked", (recipientauxilia_enfermagem) ? true : false);
        modal.find('#recipient-tecnico_enfermagem').prop("checked", (recipienttecnico_enfermagem) ? true : false);
    })
</script>
<script>
    $(document).ready(function() {
        $(function() {
            //Pesquisar os cursos sem refresh na página
            $("#pesquisa_paciente").keyup(function() {
                var pesquisa_paciente = $(this).val();
                //Verificar se há algo digitado
                if (pesquisa_paciente != '') {
                    var dados = {
                        palavra: pesquisa_paciente
                    }
                    $.post('busca_paciente.php', dados, function(retorna) {
                        //Mostra dentro da ul os resultado obtidos
                        $(".resultado_paciente").html(retorna);
                    });
                } else {
                    $(".resultado_paciente").html('');
                }
            });
        });
    });
</script>