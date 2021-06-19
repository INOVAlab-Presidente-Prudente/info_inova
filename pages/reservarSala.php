<?php
  $titulo = "Reservar Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/permissoes.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
  $sa_id = $_GET['sa_id'];
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
                            <?php
                            $row = null;
                                if(isset($_POST['cpf']) && !empty($_POST['cpf']) ){
                                    $sql = "SELECT  usu_nome as nome,
                                                    usu_cpf as doc,
                                                    usu_rg as rg,
                                                    usu_cep as cep,
                                                    usu_endereco as endereco,
                                                    usu_bairro as bairro,
                                                    usu_municipio as municipio,
                                                    usu_email as email,
                                                    usu_telefone as telefone,
                                                    usu_id FROM usuario WHERE usu_cpf = '".$_POST['cpf']."'";
                                    $query = mysqli_query($connect, $sql);
                                    if(!$query)
                                        echo "problema ao acessar o banco efetuar a pesquisa";
                                    else{
                                        $row = mysqli_fetch_assoc($query);
                                        if($row != null){
                                            echo "usuario :".$row['nome'];
                                        }
                                        else{
                                            echo "<div class='col alert alert-warning alert-dismissible'>
                                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    <h5><i class='fas fa-exclamation-triangle'></i>&nbsp;Usuário não cadastro!</h5>
                                                    <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarUsuario.php'>Clique aqui</a> para realizar o cadastro!.<p>
                                                </div>";
                                        }
                                    }

                                }else if(isset($_POST['cnpj']) && !empty($_POST['cnpj'])){
                                    $sql = "SELECT  emp_id,
                                                    emp_razao_social as nome,
                                                    emp_cnpj as doc,
                                                    emp_cep as cep,
                                                    emp_endereco as endereco,
                                                    emp_bairro as bairro,
                                                    emp_municipio as municipio,
                                                    emp_email as email,
                                                    emp_telefone as telefone 
                                                    FROM empresa WHERE emp_cnpj = '".$_POST['cnpj']."'";
                                    $query = mysqli_query($connect, $sql);
                                    if(!$query)
                                        echo "problema ao acessar o banco efetuar a pesquisa".mysqli_error($connect);
                                    else{
                                        $row = mysqli_fetch_assoc($query);
                                        if($row != null){
                                            echo "empresa :".$row['nome'];
                                        }
                                        else{
                                            echo "<div class='col alert alert-warning alert-dismissible'>
                                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    <h5><i class='fas fa-exclamation-triangle'></i>&nbsp; Empresa não cadastrada!</h5>
                                                    <p><a class='text-secondary stretched-link' style='cursor:pointer' href='cadastrarEmpresa.php'>Clique aqui</a> para realizar o cadastro!.<p>
                                                </div>";
                                        }
                                    }
                                }
                                ?>
                        <div class="row" id="data-user" style="display: none">
                                
                                <div class="col-6 form-group">
                                    <label>Nome/Razão Social</label>
                                    <input readonly type="text" name="nome" id="nome" required class="form-control" placeholder="Nome/Razão Social"/>
                                </div>
                                <?php 
                                    if(isset($row["rg"])){?>
                                    <div class="col-3 form-group" id="view-rg">
                                        <label>RG</label>
                                        <input readonly type="text" name="rg" id="rg" required class="form-control" placeholder="RG"/>
                                    </div>
                                <?php }?>
                                <div class="col-3 form-group">
                                    <label>CEP</label>
                                    <input readonly type="text" name="cep" id="cep" required class="form-control" placeholder="00000-000"/>
                                </div>
                                <div class="col-6 form-group">
                                    <label>Endereço</label>
                                    <input readonly type="text" name="endereco" id="endereco" required class="form-control" placeholder="Endereço"/>
                                </div>
                                <div class="col-3 form-group">
                                    <label>Bairro</label>
                                    <input readonly type="text" name="bairro" id="bairro" required class="form-control" placeholder="Bairro"/>
                                </div>
                                <div class="col-3 form-group">
                                    <label>Munícipio</label>
                                    <input readonly type="text" name="municipio" id="municipio" required class="form-control" placeholder="Presidente Prudente"/>
                                </div>
                                <div class="col-2 form-group">
                                    <label>Email</label>
                                    <input readonly type="email" name="email" id="email" required class="form-control" placeholder="inova@inova.com"/>
                                </div>
                                <div class="col-2 form-group">
                                    <label>Telefone</label>
                                    <input readonly type="text" name="telefone" id="telefone" required class="form-control" placeholder="(00) 00000-0000"/>
                                </div>                            
                            
                            <?php 
                            /* }
                            else{ */?>
                                <!-- Mostrar um alert o user não ta cadastrado e 
                                falar para ele se cadastrar via um button ou link -->
                           <?php /* } */?>
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
                                        $queryEvento = mysqli_query($connect, $sql);
                                        $tipoEvento = mysqli_fetch_array($queryEvento);    

                                        while ($tipoEvento != null) {
                                            echo "<option value='".$tipoEvento['tip_id']."'>". ucwords($tipoEvento['tip_descricao']) ."</option>";
                                            $tipoEvento = mysqli_fetch_array($queryEvento);
                                        }
                                    ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"> 
                    <div class="row">
                            <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'>
                                <i class="fab fa-houzz"></i>&nbsp;&nbsp;Reservar sala
                            </button>                
                            </div> 
                        
                    </div>
                </div>
                </div>
        </div>
      </div>
      </form>
  </section>
</div>

<script>
    <?php
    if($row!=null){
    ?>
        document.getElementById("data-user").style.display = "block";
        document.getElementById("nome").value = '<?=$row['nome']?>';
        document.getElementById("rg").value = '<?=isset($row['rg']) ? $row['rg'] : ""?>';
        document.getElementById("cep").value = '<?=$row["cep"]?>';
        document.getElementById("endereco").value = '<?=$row["endereco"]?>';
        document.getElementById("bairro").value = '<?=$row["bairro"]?>';
        document.getElementById("municipio").value = '<?=$row["municipio"]?>';
        document.getElementById("email").value = '<?=$row["email"]?>';
        document.getElementById("telefone").value = '<?=$row["telefone"]?>';
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
</script>
<?php
    include ('../includes/footer.php');
?>