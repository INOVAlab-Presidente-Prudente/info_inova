<?php
  $titulo = "Alterar Reservar de Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/permissoes.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
  $sa_id = $_GET['sala_id'];
  require_once("../admin/DB.php");
  $sql = "SELECT * FROM sala WHERE sa_id = ".$sa_id;
  $query = mysqli_query($connect,$sql);
  $sala = mysqli_fetch_assoc($query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Alterar Reserva de Sala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item active">Alterar Reserva de Sala</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

  <section class="content">
    <?php
        if(isset($_POST['confirmar'])){
            require_once("../admin/AlteraReserva.php");
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(isset($sa_id)){
                        require_once("../admin/DB.php");
                        $sqlSala = "SELECT * FROM sala WHERE sa_id = ".$_GET['sala_id']."";
                        $querySala = mysqli_query($connect, $sqlSala);
                        $rowSala = mysqli_fetch_assoc($querySala);
                    }
                
                ?>
                <div class="card card-secondary">
                    <div class="card-header">
                        <div class="card-title">Dados da Sala</div>
                    </div>
                    <div class="card-body">
                        <div class="p-1">
                            <div class="row invoice-info mb-2">
                                <div class="col-md-4 invoice-col">
                                    <b>Nome do espaço:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_nome_espaco'])?><br/>
                                    <b>Capacidade:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_capacidade'])?><br/>
                                    <b>Valor por perído:</b> &nbsp;R$<?=htmlspecialchars($rowSala['sa_valor_periodo'])?><br/>
                                    <b>Valor por hora:</b> &nbsp;R$<?=htmlspecialchars($rowSala['sa_valor_hora'])?><br/>
                                    <b>Localização:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_localizacao'])?><br/>
                                </div>
                                <div class="col-md-4 invoice-col">
                                    <b>Ambiente climatizado:</b> &nbsp;<?=$rowSala['sa_ambiente_climatizado'] == 1 ? "sim" : "não"?><br/>  
                                    <b>Projetor:</b> &nbsp;<?=$rowSala['sa_projetor'] == 1 ? "sim" : "não"?><br/>  
                                    <b>Caixas de som:</b> &nbsp;<?=$rowSala['sa_caixa_som']?><br/>  
                                    <b>Cadeiras com apoio:</b> &nbsp;<?=$rowSala['sa_cadeiras_apoio'] == 1 ? "sim" : "não"?><br/>
                                    <b>Iluminação:</b> &nbsp;<?=htmlspecialchars(ucwords($rowSala['sa_iluminacao']))?><br/>  
                                </div>
                                <div class="col-md-4 invoice-col">
                                    <b>Disponibilidade:</b> &nbsp;<?=$rowSala['sa_disponibilidade'] == 1 ? "Disponível" : "não" ?><br/>  
                                    <b>Frigobar:</b> &nbsp;<?=$rowSala['sa_frigobar'] == 1 ? "sim" : "não" ?><br/>  
                                    <b>Computadores:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_computadores'])?><br/>  
                                    <b>Mesas:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_mesas'])?><br/>  
                                    <b>Cadeiras:</b> &nbsp;<?=htmlspecialchars($rowSala['sa_cadeiras'])?><br/>  
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
                                <?php 
                                    // dados da reserva e evento
                                    $sql = "SELECT * FROM reserva_sala r LEFT JOIN evento e ON e.res_id = r.res_id WHERE r.res_id = ".$_GET['res_id']." AND r.sa_id = ".$_GET['sala_id']."";
                                    $query = mysqli_query($connect, $sql);
                                    $dados = mysqli_fetch_assoc($query);

                                    $data = explode(" ", $dados['res_inicio'])[0];
                                    $horaInicio = substr(explode(" ", $dados['res_inicio'])[1], 0, 5);
                                    $horaFim = substr(explode(" ", $dados['res_fim'])[1], 0, 5);
                                ?>
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
                            </form>
                        </div>
                        <?php
                            $row = null;
                            if((isset($dados['usu_id']) && !isset($_POST['cnpj'])) || (isset($_POST['cpf']) && !empty($_POST['cpf'])) ){
                                $uID = $dados['usu_id'];
                                $cpf = "";
                                if(isset($_POST['cpf']) && !empty($_POST['cpf'])){
                                    $uID = "";
                                    $cpf = $_POST['cpf'];
                                }
                                
                                $sql = "SELECT  usu_nome as nome,
                                                usu_cpf as doc,
                                                usu_rg as rg,
                                                usu_cep as cep,
                                                usu_endereco as endereco,
                                                usu_bairro as bairro,
                                                usu_municipio as municipio,
                                                usu_email as email,
                                                usu_telefone as telefone,
                                                usu_id FROM usuario WHERE usu_id = '".$uID."' OR usu_cpf = '".$cpf."'";
                                $query = mysqli_query($connect, $sql);
                                if(!$query)
                                    echo "problema ao acessar o banco efetuar a pesquisa: ".mysqli_error($connect);
                                else{
                                    $row = mysqli_fetch_assoc($query);
                                    if($row == null){
                                        echo "<div class='col alert alert-warning alert-dismissible'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                <h5><i class='fas fa-exclamation-triangle'></i>&nbsp;Usuário não cadastro!</h5>
                                                <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarUsuario.php'>Clique aqui</a> para realizar o cadastro!.<p>
                                            </div>";
                                    }
                                }

                            }else if( (isset($dados['emp_id']) && !isset($_POST['cpf'])) || (isset($_POST['cnpj']) && !empty($_POST['cnpj']))){
                                $eID = $dados['emp_id'];
                                $cnpj = "";
                                if (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) {
                                    $eID = "";
                                    $cnpj = $_POST['cnpj'];
                                }
                                $sql = "SELECT  emp_id,
                                                emp_razao_social as nome,
                                                emp_cnpj as doc,
                                                emp_cep as cep,
                                                emp_endereco as endereco,
                                                emp_bairro as bairro,
                                                emp_municipio as municipio,
                                                emp_email as email,
                                                emp_telefone as telefone 
                                                FROM empresa WHERE emp_id = '".$eID."' OR emp_cnpj = '".$cnpj."'";
                                $query = mysqli_query($connect, $sql);
                                if(!$query)
                                    echo "problema ao acessar o banco efetuar a pesquisa".mysqli_error($connect);
                                else{
                                    $row = mysqli_fetch_assoc($query);
                                    if($row == null){
                                        echo "<div class='col alert alert-warning alert-dismissible'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                <h5><i class='fas fa-exclamation-triangle'></i>&nbsp; Empresa não cadastrada!</h5>
                                                <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarEmpresa.php'>Clique aqui</a> para realizar o cadastro!.<p>
                                            </div>";
                                    }
                                }
                            }
                        ?>
                        <div class="invoice p-2 mb-2" id="data-user" style="display: none">
                            <div class="row col-md-12 invoice-info mb-1" >
                                <?php if($row != null): ?>
                                    <div class="col-md-6 invoice-col">
                                        <b>Nome/Razão Social:</b>&nbsp;<?=htmlspecialchars($row["nome"])?><br/>
                                        <b>Email:</b>&nbsp;<?=htmlspecialchars($row["email"])?><br/>
                                        <?php 
                                            if(isset($row["rg"])){?>
                                                <b>RG:</b>&nbsp;<?=htmlspecialchars($row["rg"])?><br/>
                                                <b>CPF:</b>&nbsp;<?=htmlspecialchars($row['doc'])?><br/>
                                        <?php
                                            }
                                            else{?>
                                                <b>CNPJ:</b>&nbsp;<?=htmlspecialchars($row['doc'])?><br/>
                                        <?php }?>
                                        <b>Telefone:</b>&nbsp;<?=htmlspecialchars($row["telefone"])?><br/>
                                    </div>
                                    <div class="col-md-6 invoice-col">
                                        <b>CEP:</b>&nbsp;<?=htmlspecialchars($row["cep"])?><br/>
                                        <b>Endereço:</b>&nbsp;<?=htmlspecialchars($row["endereco"])?><br/>
                                        <b>Bairro:</b>&nbsp;<?=htmlspecialchars($row["bairro"])?><br/>
                                        <b>Munícipio:</b>&nbsp;<?=htmlspecialchars($row["municipio"])?><br/>
                                    </div>       
                                <?php endif?>          
                            </div>    
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
                            <input value="<?=$data?>" type="date" name="data" id="data" required class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Horário Início</label>
                            <input value="<?=$horaInicio?>" type="time" name="horaInicio" id="horaInicio" required class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Horário Fim</label>
                            <input value="<?=$horaFim?>" type="time" name="horaFim" required id="horaFim" class="form-control" autocomplete="off"/>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label>Pagamento</label>
                            <select name="pagamento" id="pagamento" class="form-control" autocomplete="off">
                                <?php 
                                    if ($dados['res_pagamento'] == 1) {
                                        echo "<option selected value='1'>Pago</option>";
                                        echo "<option value='0'>Pendente</option>";
                                    } else {
                                        echo "<option value='1'>Pago</option>";
                                        echo "<option selected value='0'>Pendente</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-4 form-group">
                            <label>Valor Total (R$)</label>
                            <input value="<?=$dados['res_valor_total']?>" type="text" name="valTotal"  id="valTotal" pattern="[0-9\.]+" required class="form-control"/>
                        </div>
                        <div class="col-12 form-group">
                            <label>Observações</label>
                            <textarea id="observacoes" name="observacoes" placeholder="Coloque informações adicionais aqui" class="form-control" maxlength="200"><?=$dados['res_observacoes']?></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="checkbox custom-control-input" id="evento" name="evento">
                                    <label class="custom-control-label" for="evento">Evento</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </div>
        <div class="container-fluid" id="view-evento" style = "display : <?= !empty($dados['eve_id']) ? 'block':'none'  ?>" >
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
                                    <input value="<?=$dados['eve_nome']?>" type="text" name="nomeEvento" id="nomeEvento" class="form-control" max="30" autocomplete="off"/>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Valor de entrada (R$)</label>
                                    <input value="<?=$dados['eve_valor_entrada']?>" type="text" name="valEntrada" id="valEntrada" class="form-control" autocomplete="off"/>
                                </div>
                                <div class="col-md-4 form-group">
                                <label>Quantidade de inscritos</label>
                                    <input value="<?=$dados['eve_qtd_inscritos']?>"type="number" min="0" name="qtdInscritos" id="qtdInscritos" value="0" class="form-control"  autocomplete="off"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                <label>Ministrante</label>
                                    <input value="<?=$dados['eve_ministrante']?>" type="text" name="ministrante" id="ministrante" class="form-control" autocomplete="off"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tipo do evento</label>
                                    <select name="tipoEvento" id="tipoEvento" class="form-control" autocomplete="off">
                                        <option selected disabled value="">Escolha um tipo</option>
                                        <?php
                                            $sql = "SELECT * FROM tipo_evento";
                                            $queryEvento = mysqli_query($connect, $sql);
                                            $tipoEvento = mysqli_fetch_array($queryEvento);    

                                            while ($tipoEvento != null) {
                                                if (isset($dados['tip_id']) && $dados['tip_id'] == $tipoEvento['tip_id']) {
                                                    echo "<option selected value='".$dados['tip_id']."'>". ucwords($tipoEvento['tip_descricao']) ."</option>";
                                                } else {
                                                    echo "<option value='".$tipoEvento['tip_id']."'>". ucwords($tipoEvento['tip_descricao']) ."</option>";
                                                }
                                                $tipoEvento = mysqli_fetch_array($queryEvento);
                                            }
                                        ?>
                                    </select>
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
            <?php 
                echo "<button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class='fas fa-edit'></i>&nbsp;&nbsp;Salvar Alterações</button>";
                if (isset($_POST['confirmar'])) {
                    require_once("../admin/AlteraReserva.php");
                }
            ?>              
        </div> 
      </form>
  </section>
</div>

<script>
    window.onload = function(){
      if(<?= isset($dados['usu_id']) ? 1 : 0?>) {
            $("#PF").prop("checked",true);
            $('#view-cpf').css("display","block");
      }
      else if(<?= isset($dados['emp_id']) ? 1 : 0?>){
            $("#PJ").prop("checked",true);
            $('#view-cnpj').css("display","block");
      }

      if(<?= !empty($dados['eve_id']) ? 1 : 0  ?>){
            $("#evento").prop("checked",true);
      }
    };


    <?php
    if($row!=null){
    ?>
        document.getElementById("data-user").style.display = "flex";
        document.getElementById("idUsuario").value = '<?=isset($row['usu_id']) ? $row['usu_id'] : ""?>';
        document.getElementById("idEmpresa").value = '<?=isset($row['emp_id']) ? $row['emp_id'] : ""?>';
    <?php }
    ?>
    
    $('#cpf').on('input',()=>{
        if($('#cpf').val().length == 14){
            var form = document.getElementById("form-busca");
            form.submit();
        }
    })
    $('#cnpj').on('input',()=>{
        if($('#cnpj').val().length == 18){
            var form = document.getElementById("form-busca");
            form.submit();
        }
    })
    
    $('#PF').on('change',()=>{
        console.log("PF changed")
        if(!$('#PF').is(':checked')){
            $('#view-cpf').css("display","none");
            $('#data-user').css("display","none");
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
            $('#data-user').css("display","none");
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
            $('#valTotal').val('<?=$sala['sa_valor_periodo']?>')
        }
        else if($("#tarde").is(":checked")){
            $('#horaInicio').val('13:00');
            $('#horaFim').val('17:00');
            $('#valTotal').val('<?=$sala['sa_valor_periodo']?>')
        }else if($("#noite").is(":checked")){
            $('#horaInicio').val('18:00');
            $('#horaFim').val('22:00');
            $('#valTotal').val('<?=$sala['sa_valor_periodo']?>')
        }
    });
    
    $('#evento').on('change',()=>{
        if($('#evento').is(':checked')){
            $('#view-evento').css("display","block");
        }else{
            $('#view-evento').css("display","none");
            
        }
    });
</script>
<?php
    include ('../includes/footer.php');
?>