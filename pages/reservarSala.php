<?php
  $titulo = "Reservar Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/permissoes.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
  $sa_id = $_GET['sala_id'];
  require_once("../admin/DB.php");
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reservar Sala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item active">Reservar Sala</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

  <section class="content">
    <?php
        if(isset($_POST['confirmar'])){
            require_once("../admin/ReservaSala.php");
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($sa_id)){
                        $sql = "SELECT * FROM sala WHERE sa_id = ".$sa_id."";
                        $query = mysqli_query($connect, $sql);
                        $row = mysqli_fetch_assoc($query);
                        
                        if($row == NULL)
                            header("location: consultarSala.php");
                    }else
                        header("location: consultarSala.php");
                
                ?>
                <div class="card card-secondary">
                    <div class="card-header">
                        <div class="card-title">Dados da Sala</div>
                    </div>
                    <div class="card-body">
                        <div class="p-1">
                            <div class="row invoice-info mb-2">
                                <div class="col-md-4 invoice-col">
                                    <b>Nome do espaço:</b> &nbsp;<?=htmlspecialchars($row['sa_nome_espaco'])?><br/>
                                    <b>Capacidade:</b> &nbsp;<?=htmlspecialchars($row['sa_capacidade'])?><br/>
                                    <b>Valor por perído:</b> &nbsp;R$<?=htmlspecialchars($row['sa_valor_periodo'])?><br/>
                                    <b>Valor por hora:</b> &nbsp;R$<?=htmlspecialchars($row['sa_valor_hora'])?><br/>
                                    <b>Localização:</b> &nbsp;<?=htmlspecialchars($row['sa_localizacao'])?><br/>
                                </div>
                                <div class="col-md-4 invoice-col">
                                    <b>Ambiente climatizado:</b> &nbsp;<?=$row['sa_ambiente_climatizado'] == 1 ? "sim" : "não"?><br/>  
                                    <b>Projetor:</b> &nbsp;<?=$row['sa_projetor'] == 1 ? "sim" : "não"?><br/>  
                                    <b>Caixas de som:</b> &nbsp;<?=$row['sa_caixa_som']?><br/>  
                                    <b>Cadeiras com apoio:</b> &nbsp;<?=$row['sa_cadeiras_apoio'] == 1 ? "sim" : "não"?><br/>
                                    <b>Iluminação:</b> &nbsp;<?=htmlspecialchars(ucwords($row['sa_iluminacao']))?><br/>  
                                </div>
                                <div class="col-md-4 invoice-col">
                                    <b>Disponibilidade:</b> &nbsp;<?=$row['sa_disponibilidade'] == 1 ? "Disponível" : "não" ?><br/>  
                                    <b>Frigobar:</b> &nbsp;<?=$row['sa_frigobar'] == 1 ? "sim" : "não" ?><br/>  
                                    <b>Computadores:</b> &nbsp;<?=htmlspecialchars($row['sa_computadores'])?><br/>  
                                    <b>Mesas:</b> &nbsp;<?=htmlspecialchars($row['sa_mesas'])?><br/>  
                                    <b>Cadeiras:</b> &nbsp;<?=htmlspecialchars($row['sa_cadeiras'])?><br/>  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <p class="card-title">Dados do Interessado</p>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-start ml-1" >
                            <div class="form-group col-md-2">
                                <div class="custom-control custom-switch">
                                
                                    <input type="checkbox" class="checkbox custom-control-input" id="PF" name="PF">
                                    <label class="custom-control-label" for="PF">Pessoa Física</label> 
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="checkbox custom-control-input" id="PJ" name="PJ">
                                    <label class="custom-control-label" for="PJ">Pessoa Jurídica</label> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <form method="post" id="form-busca" >
                                <div class="col-md-12 form-group "id="view-cpf" style="display: none">
                                    <label>CPF:</label>
                                    <input type="text" name="cpf" id="cpf" required class="form-control" placeholder="CPF"/>
                                </div>
                                <div class="col-md-12 form-group" id="view-cnpj" style="display: none">
                                    <label>CNPJ:</label>
                                    <input type="text" name="cnpj" id="cnpj" required class="form-control" placeholder="CNPJ"/>
                                </div>
                                <!-- <button name="pesquisa" class="btn btn-primary"> Pesquisar </button> -->
                            </form>
                        </div>
                        <!-- Alertas -->
                        <div id="alert-pf" class='col alert alert-warning alert-dismissible' style="display: none">
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h5><i class='fas fa-exclamation-triangle'></i>&nbsp;Usuário não cadastrado!</h5>
                            <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarUsuario.php'>Clique aqui</a> para realizar o cadastro!.<p>
                        </div>
                        <div id="alert-pj" class='col alert alert-warning alert-dismissible' style="display: none">
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h5><i class='fas fa-exclamation-triangle'></i>&nbsp; Empresa não cadastrada!</h5>
                            <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarEmpresa.php'>Clique aqui</a> para realizar o cadastro!.<p>
                        </div>

                        <div class="invoice p-2 mb-2" id="data-user" style="display: none">
                            <!-- mostra dados do usuario -->
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        </div>
    <form method="post">
      <!-- id de usuario e empresa -->
      <input type="hidden" name="idUsuario" id="idUsuario" value=''/>
      <input type="hidden" name="idEmpresa" id="idEmpresa" value=''/>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
            <div class="card-header">
                    <p class="card-title">Dados Gerais</p>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col form-group">
                            <label>Tipo Horario</label>
                            <div class="row">
                            <div class="col form-group">
                            <div class="icheck-primary d-inline mr-2">
                                        <input type="radio"  name="tipoHorario" id="manha" value="manha" />
                                        <label for="manha">Manhã</label>
                                        </div>
                                    <div class="icheck-primary d-inline mr-2">
                                        <input type="radio"  name="tipoHorario" id="tarde" value="tarde" />
                                        <label for="tarde">Tarde</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio"  name="tipoHorario" id="noite" value="noite" />
                                        <label for="noite">Noite</label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-4 form-group">
                        <label>Data</label>
                            <input type="date" name="data" id="data" required class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Horário Início</label>
                            <input type="time" name="horaInicio" id="horaInicio" required class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Horário Fim</label>
                            <input type="time" name="horaFim" required id="horaFim" class="form-control" autocomplete="off"/>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label>Pagamento</label>
                            <select name="pagamento" id="pagamento" class="form-control" autocomplete="off">
                                <option selected value="1">Pago</option>
                                <option value="0">Pendente</option>
                            </select>
                        </div>
                        <div class="col-4 form-group">
                            <label>Valor Total (R$)</label>
                            <input type="text" name="valTotal"  id="valTotal" pattern="[0-9\.]+" required class="form-control"/>
                        </div>
                        <div class="col-12 form-group">
                            <label>Observações</label>
                            <textarea id="observacoes" name="observacoes" placeholder="Coloque informações adicionais aqui" class="form-control" maxlength="200"></textarea>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="checkbox custom-control-input" id="evento" name="evento">
                                    <label class="custom-control-label" for="evento">Novo evento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" name="eventoSelect" id="eventoSelect">
                                    <option disabled selected value="">Escolha um evento</option>
                                    <option value="">Nenhum evento associado</option>
                                    <?php 
                                        $sql = "SELECT *, DATE_FORMAT(eve_dataInicio, \" %d/%m/%y \") as data FROM evento WHERE eve_dataInicio BETWEEN DATE(NOW() -INTERVAL 15 DAY) AND DATE(NOW() + INTERVAL 30 DAY) ";
                                        $queryEvento = mysqli_query($connect, $sql);

                                        $evento = mysqli_fetch_assoc($queryEvento);
                                        while($evento != null){
                                            ?>
                                                <option value="<?=$evento['eve_id']?>">
                                                    <?=$evento['eve_nome']?> <?=$evento['data']?>
                                                </option>
                                            <?php
                                            $evento = mysqli_fetch_assoc($queryEvento);
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </div>

        <div class="container-fluid" id="view-evento" style="display:none">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <p class="card-title">Evento</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Nome do evento</label>
                                    <input type="text" name="nomeEvento" id="nomeEvento" class="form-control" max="30" autocomplete="off"/>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Valor de entrada (R$)</label>
                                    <input type="text" name="valEntrada" id="valEntrada" class="form-control" autocomplete="off"/>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Quantidade de inscritos</label>
                                    <input type="number" min="0" name="qtdInscritos" id="qtdInscritos" value="0" class="form-control"  autocomplete="off"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                <label>Ministrante</label>
                                    <input type="text" name="ministrante" id="ministrante" class="form-control" autocomplete="off"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tipo do evento</label>
                                    <select name="tipoEvento" id="tipoEvento" class="form-control" autocomplete="off">
                                    <option selected disabled value="">Escolha um tipo</option>
                                        <?php
                                            $sql = "SELECT * FROM tipo_evento";
                                            $queryTp = mysqli_query($connect, $sql);
                                            $tipoEvento = mysqli_fetch_array($queryTp);    

                                            while ($tipoEvento != null) {
                                                echo "<option value='".$tipoEvento['tip_id']."'>". ucwords($tipoEvento['tip_descricao']) ."</option>";
                                                $tipoEvento = mysqli_fetch_array($queryTp);
                                            }
                                        ?>
                                        </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <!-- Periodo do evento -->
                                    <div class="form-group">
                                        <label>Periodo do evento:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right" name="periodoEvento" id="periodoEvento">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'>
                <i class="fab fa-houzz"></i>&nbsp;&nbsp;Reservar sala
            </button>                
        </div>
      </form>
  </section>
</div>
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(function() { 
        $('#periodoEvento').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY HH:mm',
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "Até",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sáb"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ]
        }
        });
    });

    window.onload = function(){
      if(<?= isset($row['usu_id']) ? 1 : 0?>) {
            $("#PF").prop("checked",true);
            $('#view-cpf').css("display","block");
      }
      else if(<?= isset($row['emp_id']) ? 1 : 0?>){
            $("#PJ").prop("checked",true);
            $('#view-cnpj').css("display","block");
      }

    };
    
    $('#PF').on('change',()=>{
        console.log("PF changed")
        if(!$('#PF').is(':checked')){
            $('#view-cpf').css("display","none");
            //$('#data-user').css("display","none");
        }
        else{
            $('#view-cpf').css("display","block");
            $("#PF").prop("checked",true);
            $('#view-cnpj').css("display","none");
            $("#PJ").prop("checked",false);
        }
        
    });

    $('#PJ').on('change',()=>{
        console.log("PJ changed")
        if(!$('#PJ').is(':checked')){
            $('#view-cnpj').css("display","none");
            //$('#data-user').css("display","none");
        }
        else{
            $('#view-cnpj').css("display","block");
            $("#PJ").prop("checked",true);
            $('#view-cpf').css("display","none");
            $("#PF").prop("checked",false);
        }
    });

    $("input[type=radio][name='tipoHorario']").change(function(){
        console.log('alo');
        if($("#manha").is(":checked")){
            $('#horaInicio').val('08:00');
            $('#horaFim').val('12:00');
            $('#valTotal').val('<?=$row['sa_valor_periodo']?>')
        }
        else if($("#tarde").is(":checked")){
            $('#horaInicio').val('13:00');
            $('#horaFim').val('17:00');
            $('#valTotal').val('<?=$row['sa_valor_periodo']?>')
        }else if($("#noite").is(":checked")){
            $('#horaInicio').val('18:00');
            $('#horaFim').val('22:00');
            $('#valTotal').val('<?=$row['sa_valor_periodo']?>')
        }
    });
    
    $('#evento').on('change',()=>{
        if($('#evento').is(':checked')){
            $('#view-evento').css("display","block");
            $('#eventoSelect').css('display','none');
        }else{
            $('#view-evento').css("display","none");
            $('#eventoSelect').css('display','block');
        }
    });

    const cpf = document.getElementById("cpf");
        cpf.oninput = () => {
            if (cpf.value.length == 14) {
                $("#data-user").load("../admin/DadosUsuario.php", {
                    cpf: cpf.value
                })
            }
        }
    const cnpj = document.getElementById("cnpj");
        cnpj.oninput = () => {
            if (cnpj.value.length == 18) {
                $("#data-user").load("../admin/DadosUsuario.php", {
                    cnpj: cnpj.value
                })
            }
        }
</script>
<?php
    include ('../includes/footer.php');
?>