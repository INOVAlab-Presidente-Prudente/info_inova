<?php
  $titulo = "Alterar Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  require_once('../admin/DB.php');
  $sql = "SELECT * FROM sala WHERE sa_id = '".$_GET['sala_id']."'";
  $query = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($query);

  if (!isset($_GET['alterar']))
      $alterar = 'disabled';
  else
      $alterar = "enabled";
  if($row == null)
      header("location: /pages/consultarSala.php");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class='col-sm-6'>
            <h1>Consultar Sala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item active" >Alterar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Fazer o preenchimento automático dos campos via PHP2 -->
    <section class="content">
      <!-- form start -->
      <form method="post">
        <div class="container-fluid">
        <?php 
            if (isset($_GET['sala_nao_alterada'])){
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='icon fas fa-ban'></i> Sala não alterada!</h5>
                            <p>Sala não foi alterada.</p>
                      </div>";
            }
            if (isset($_GET['falta_dados'])){
              echo "<div class='alert alert-warning alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h5><i class='icon fas fa-ban'></i> Sala não alterada!</h5>
                          <p>Preencha todos os campos.</p>
                    </div>";
          }
          ?>
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
                                <input <?="value='".$row['sa_nome_espaco']."'"?> required type="text" name="nome" id="nome" class="form-control" autocomplete="off"/>
                            </div>
                            <div class="col-12 form-group">
                                <label>Localização</label>
                                <input <?="value='".$row['sa_localizacao']."'"?> required type="text" name="localizacao" id="localizacao" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                <label>Capacidade</label>
                                <input <?="value='".$row['sa_capacidade']."'"?> required type="number" min="0" name="capacidade" id="capacidade" class="form-control" autocomplete="off"/>
                            </div>
                            <div class="col-4 form-group">
                                <label>Valor por periodo (R$)</label>
                                <input <?="value='".$row['sa_valor_periodo']."'"?> required pattern="[0-9\.]+" type="text" name="valPeriodo" id="valPeriodo" class="form-control" autocomplete="off"/>
                            </div>
                            <div class="col-4 form-group">
                                <label>Valor por hora (R$)</label>
                                <input <?="value='".$row['sa_valor_hora']."'"?> required pattern="[0-9\.]+" type="text" name="valHora" id="valHora" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                <div class="custom-control custom-switch">
                                    <input <?=$row['sa_disponibilidade'] == 1 ? "checked" : ""?> type="checkbox" class="checkbox custom-control-input" id="disponivel" name="disponivel">
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
                            <input <?="value='".$row['sa_caixa_som']."'"?> type="number" min="0" name="caixaSom" id="caixaSom" value="0" class="form-control" max="30" autocomplete="off"/>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Computadores</label>
                            <input <?="value='".$row['sa_computadores']."'"?> type="number" min="0" name="computadores" id="computadores" value="0" class="form-control" autocomplete="off"/>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Iluminação</label>
                            <select name="iluminacao" id="iluminacao" value="" class="form-control" autocomplete="off">
                                <?php 
                                    if ($row['sa_iluminacao'] == 'fria'){
                                        echo "<option selected value='fria'>Fria</option>";
                                        echo "<option value='quente'>Quente</option>";
                                    } else {
                                        echo "<option value='fria'>Fria</option>";
                                        echo "<option selected value='quente'>Quente</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Mesas</label>
                            <input <?="value='".$row['sa_mesas']."'"?> type="number" min="0" name="mesas" id="mesas" value="0" class="form-control"  autocomplete="off"/>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Cadeiras</label>
                            <input <?="value='".$row['sa_cadeiras']."'"?> type="number" min="0" name="cadeiras" id="cadeiras" value="0" class="form-control"  autocomplete="off"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input <?=$row['sa_ambiente_climatizado'] == 1 ? "checked" : ""?> type="checkbox" class="checkbox custom-control-input" id="climatizado" name="climatizado">
                                    <label class="custom-control-label" for="climatizado">Ambiente Climatizado</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input <?=$row['sa_frigobar'] == 1 ? "checked" : ""?> type="checkbox" class="checkbox custom-control-input" id="frigobar" name="frigobar">
                                    <label class="custom-control-label" for="frigobar">Frigobar</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input <?=$row['sa_projetor'] == 1 ? "checked" : ""?> type="checkbox" class="checkbox custom-control-input" id="projetor" name="projetor">
                                    <label class="custom-control-label" for="projetor">Projetor</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input <?=$row['sa_cadeiras_apoio'] == 1 ? "checked" : ""?> type="checkbox" class="checkbox custom-control-input" id="cadeiraApoio" name="cadeiraApoio">
                                    <label class="custom-control-label" for="cadeiraApoio"> Cadeira com apoio </label> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Observações</label>
                            <textarea id="observacoes" name="observacoes" placeholder="Coloque informações adicionais aqui" class="form-control" maxlength="200"><?=$row['sa_observacoes']?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer"> 
                  <div class="row">
                    <?php 
                        echo "<button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class='fas fa-edit'></i>&nbsp;&nbsp;Salvar Alterações</button>";
                        if (isset($_POST['confirmar'])) {
                            require_once("../admin/AlteraSala.php");
                        }
                    ?>   
                  </div> 
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>
<?php
  include ('../includes/footer.php');
?>