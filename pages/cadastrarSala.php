
<?php
  $titulo = "Cadastrar Sala";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cadastrar Sala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

  <section class="content">
    <?php
        if(isset($_POST['confirmar'])){
            require_once("../admin/CadastroSala.php");
        }
    ?>
    <form method="post">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <p class="card-title">Dados Gerais</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Nome do Espaço</label>
                            <input type="text" name="nome" id="nome" class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-12 form-group">
                            <label>Localização</label>
                            <input type="text" name="localizacao" id="localizacao" class="form-control" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label>Capacidade</label>
                            <input type="number" min="0" name="capacidade" id="capacidade" class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Valor por periodo (R$)</label>
                            <input type="text" name="valPeriodo" id="valPeriodo" class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-4 form-group">
                            <label>Valor por hora (R$)</label>
                            <input type="text" name="valHora" id="valHora" class="form-control" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" value="true" checked class="checkbox custom-control-input" id="disponivel" name="disponivel">
                                <label class="custom-control-label" for="disponivel">Disponivel</label>
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
                        <p class="card-title">Detalhes</p>
                    </div>
                        
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Caixas de som</label>
                                <input type="number" min="0" name="caixaSom" id="caixaSom" value="0" class="form-control" max="30" autocomplete="off"/>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Computadores</label>
                                <input type="number" min="0" name="computadores" id="computadores" value="0" class="form-control" autocomplete="off"/>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Iluminação</label>
                                <select name="iluminacao" id="iluminacao" value="" class="form-control" autocomplete="off">
                                    <option selected value="fria">Fria</option>
                                    <option value="quente">Quente</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Mesas</label>
                                <input type="number" min="0" name="mesas" id="mesas" value="0" class="form-control"  autocomplete="off"/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Cadeiras</label>
                                <input type="number" min="0" name="cadeiras" id="cadeiras" value="0" class="form-control"  autocomplete="off"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" value="false" class="checkbox custom-control-input" id="climatizado" name="climatizado">
                                        <label class="custom-control-label" for="climatizado">Ambiente Climatizado</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" value="false" class="checkbox custom-control-input" id="frigobar" name="frigobar">
                                        <label class="custom-control-label" for="frigobar">Frigobar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" value="false" class="checkbox custom-control-input" id="projetor" name="projetor">
                                        <label class="custom-control-label" for="projetor">Projetor</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" value="false" class="checkbox custom-control-input" id="cadeiraApoio" name="cadeiraApoio">
                                        <label class="custom-control-label" for="cadeiraApoio"> Cadeira com apoio </label> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Observações</label>
                                <textarea id="observacoes" name="observacoes" placeholder="Coloque informações adicionais aqui" class="form-control" maxlength="200"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"> 
                        <div class="row">
                            <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class="fas fa-building"></i>&nbsp;&nbsp;Cadastrar nova sala</button>                
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
$(".checkbox").change(function() {
    if(this.checked) {
        this.value = "true";
    }
    else{
        this.value = "false";
    }
});
</script>
<?php
    include ('../includes/footer.php');
?>