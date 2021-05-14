<?php
$titulo = "Dashboard Checkin";
include ('../includes/header.php');
include ('../includes/permissoes.php');
include ('../includes/primeirologin.php');
include ('../includes/navbar.php');
include ('../includes/sidebar.php');

  if(isset($_GET['status']) && isset($_GET['usu_id'])){ 
    require_once('../admin/DB.php');
    $sql = "SELECT u.*, e.emp_nome_fantasia FROM usuario u, empresa e 
            WHERE u.usu_id = ".$_GET['usu_id']." AND u.emp_id = e.emp_id";
    $query = mysqli_query($connect,$sql);
    if($query)
      $usuario = mysqli_fetch_assoc($query); 
  }?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 mb-4">
            <div class="callout callout-info">
              <p>
                <span class="lead">Olá, <?=$_SESSION['nome']?>!</span>
                <br/>
                Esse é o ambiente de trabalho para <?=$_SESSION['perfil_usuario']?> no InfoInova.
              </p>
            </div><!-- /.card -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>

      <?php //Alerts (checkin, checkout, erro)
        if(isset($_GET['status'])){
          if($_GET['status'] == 'checkin'){
            $mensagem = "Check-in de <strong>".$usuario['usu_nome']."</strong> realizado com sucesso";
            $alertType = "alert-success";
            $iconType = "fa-check-square";
          }else if($_GET['status'] == 'checkout'){
            $mensagem = "Check-out de <strong>".$usuario['usu_nome']."</strong> realizado com sucesso.";
            $alertType = "alert-secondary";
            $iconType = "fa-square";
          }else if($_GET['status'] == 'erro'){
            $mensagem = "Não foi possível realizar o Check-in/Check-out no sistema. Tente novamente.";
            $alertType = "alert-danger";
            $iconType = "fa-times";
          }
          
          if($_GET['status'] != 'cpf_nao_encontrado'){?>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-10 offset-md-1">
                  <div class="alert <?=$alertType?> alert-dismissible">
                    <div class="lead">
                      <i class="far <?=$iconType?>"></i>&nbsp;
                        <?= $mensagem ?>
                    </div>
                  </div>               
                </div>
              </div>
            </div>
            <?php
          }
        }
      ?>
      
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Entrada ou Saída de um usuário</h3>
              </div>
              <!-- /.card-header --> 
              <form action="../admin/CheckInUsuario.php" method="get">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputEstimatedBudget">Digite o CPF do usuário</label>
                    <input type="text" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" name="cpf" class="form-control" id="cpf" placeholder="xxx.xxx.xxx-xx">
                    <?php //<input type="text" id="inputEstimatedBudget" class="form-control" disabled> ?>
                  </div>
                </div>
                <!-- /.card-body -->            
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Fazer Check-in / Check-out</button>
                    <?php // <button type="submit" class="btn btn-warning"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Refazer Check-in / Check-out</button>?>
                </div>
                <!-- /.card-footer --> 
              </form>
            </div><!-- /.card -->
          </div>
          <div class="col-md-8">
            <?php 
            if(isset($_GET['status']) && $_GET['status'] == 'cpf_nao_encontrado'){?>
            <div class="invoice p-3 mb-3" style= "border-radius: .25rem">
                <!-- error cpf row -->
                <div class="row invoice-info mb-2">
                  <div class="col-12 mb-2">
                    <h3>
                      CPF do Usuário não encontrado!
                    </h3>
                    <p>
                      Verifique se o usuário possui cadastro no sistema.
                      <br/>
                      <a href="consultarUsuario.php">Ir para lista de usuários cadastrados.</a> 
                    </p>
                  </div>
                </div>

                <?php 
              }
              else if(isset($_GET['status']) && isset($_GET['usu_id'])){ 

                if($usuario != null ) { 
                  $border = ($_GET['status']=='checkin') ? "border-success":"border-defeault";
                  if(in_array(hash("md5", $usuario['usu_cpf']).".png", scandir("../images/usuarios")))
                    $src = "../images/usuarios/".hash("md5", $usuario['usu_cpf']).'.png';
                  else
                    $src = "../images/avatar-df.png";
                ?>
                  <!-- title row -->
                  <div class="row">
                    <div class="col-12 mb-2">
                      <img src="<?=$src?>" style="width: 100px; height: 100px;" class="profile-user-img img-fluid img-circle border-2 <?=$border?>" alt="User profile picture"/>
                      <h2><?=$usuario['u.usu_nome']?></h2>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info mb-4">
                    <div class="col-md-6 invoice-col">
                      <b>Email:</b><?=$usuario['usu_email']?><br>
                      <b>Data de nascimento:</b><?=date_format(date_create($usuario['usu_data_nascimento']),"d/m/Y")?><br>
                      <b>RG:</b><?=$usuario['usu_rg']?><br>
                      <b>CPF:</b><?=$usuario['usu_cpf']?><br>
                      <b>Telefone:</b><?=$usuario['usu_telefone']?><br>                  
                      <b>Nome do Responsável:</b><?=$usuario['usu_responsavel']?><br>
                      <b>Telefonedo Responsável:</b><?=$usuario['usu_tel_responsavel']?><br>
                    </div><!-- /.col -->
                    <div class="col-md-6 invoice-col">
                      <b>Área de Atuação:</b><?=$usuario['usu_area_atuacao']?><br>
                      <b>Área de Interesse:</b><?=$usuario['usu_area_interesse']?><br>
                      <b>Empresa:</b><?=$usuario['emp_nome_fantasia']?><br>
                      <b>Socio:</b><?=$usuario['usu_socio']? "sim":"não" ?><br>                  
                      <b>Perfil de Usuário:</b><?=$usuario['pu_id']?><br>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                  <?php 
                }
              }?>
            </div><!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->        
      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
<?php
include ('../includes/footer.php');
?>