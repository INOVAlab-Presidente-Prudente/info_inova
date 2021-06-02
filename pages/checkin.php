<?php
$titulo = "Dashboard Checkin";
include ('../includes/header.php');
include ('../includes/permissoes.php');
include ('../includes/primeirologin.php');
include ('../includes/navbar.php');
include ('../includes/sidebar.php');

  if(isset($_GET['status']) && isset($_GET['usu_id'])){ 
    require_once('../admin/DB.php');
    $sql = "SELECT u.* FROM usuario u
            WHERE u.usu_id = ".$_GET['usu_id']; // so aparece os dados se existe uma empresa cadastrada no sistema
    $query = mysqli_query($connect,$sql);
    if($query)
      $usuario = mysqli_fetch_assoc($query); 
      $sql2 = "SELECT e.emp_nome_fantasia FROM usuario u, empresa e 
            WHERE u.usu_id = ".$_GET['usu_id']." AND u.emp_id IS NOT NULL AND u.emp_id = e.emp_id";
      $query2 = mysqli_query($connect, $sql2);
      $row = mysqli_fetch_assoc($query2);
  }?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
        </div>
      </div>
    </section>
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
            </div>
          </div>
        </div>
      </div>

      <?php //Alerts (checkin, checkout, erro)
        if(isset($_GET['status'])){
          if($_GET['status'] == 'checkin'){
            $mensagem = "Check-in de <strong>".htmlspecialchars($usuario['usu_nome'])."</strong> realizado com sucesso";
            $alertType = "alert-success";
            $iconType = "fa-check-square";
          }else if($_GET['status'] == 'checkout'){
            $mensagem = "Check-out de <strong>".htmlspecialchars($usuario['usu_nome'])."</strong> realizado com sucesso.";
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
                  <div class='alert <?=$alertType?> alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <div class="lead">
                      <i class='fas <?=$iconType?>'></i>&nbsp;<?= $mensagem ?>
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
              <form action="../admin/CheckInUsuario.php" method="get">
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputEstimatedBudget">Digite o CPF do usuário</label>
                    <input type="text" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" name="cpf" class="form-control" id="cpf" placeholder="xxx.xxx.xxx-xx">
                    <?php //<input type="text" id="inputEstimatedBudget" class="form-control" disabled> ?>
                  </div>
                </div>         
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Fazer Check-in / Check-out</button>
                    <?php // <button type="submit" class="btn btn-warning"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Refazer Check-in / Check-out</button>?>
                </div>
              </form>
            </div>
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
                  <div class="invoice p-3 mb-3" style= "border-radius: .25rem">
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
                      <b>Email: </b><?=htmlspecialchars($usuario['usu_email'])?><br>
                      <b>Data de nascimento: </b><?=htmlspecialchars(date_format(date_create($usuario['usu_data_nascimento']),"d/m/Y"))?><br>
                      <b>RG: </b><?=htmlspecialchars($usuario['usu_rg'])?><br>
                      <b>CPF: </b><?=htmlspecialchars($usuario['usu_cpf'])?><br>
                      <b>Telefone: </b><?=htmlspecialchars($usuario['usu_telefone'])?><br>
                      <?php if ($usuario['usu_responsavel'] != null):?>
                        <b>Nome do Responsável: </b><?=htmlspecialchars($usuario['usu_responsavel'])?><br>
                        <b>Telefone do Responsável: </b><?=htmlspecialchars($usuario['usu_tel_responsavel'])?><br>
                      <?php endif;?>
                    </div><!-- /.col -->
                    <div class="col-md-6 invoice-col">
                      <b>Área de Atuação: </b><?=htmlspecialchars($usuario['usu_area_atuacao'])?><br>
                      <b>Área de Interesse: </b><?=htmlspecialchars($usuario['usu_area_interesse'])?><br>
                      <?php if ($usuario['emp_id'] != null):?>
                        <b>Empresa: </b><?=htmlspecialchars($row['emp_nome_fantasia'])?><br>
                      <?php endif;?>
                      <b>Socio: </b><?=htmlspecialchars($usuario['usu_socio']? "sim": "não")?><br>
                      <?php 
                        $sql = "SELECT pu_descricao FROM perfil_usuario p INNER JOIN usuario u ON u.pu_id = p.pu_id";
                        $query = mysqli_query($connect, $sql);
                        $perfil = mysqli_fetch_assoc($query)['pu_descricao'];
                      ?>                 
                      <b>Perfil de Usuário: </b><?=htmlspecialchars(ucwords($perfil))?><br>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                  <?php 
                }
              }?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total de Acessos</h3>
                  <a href="#">Ver relatório</a> <!-- relatorioAcessos.php -->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?= $_GET['totAcessos']?>  Acessos</span>
                    <span>Total de acessos (Últimos 10 dias)</span>
                  </p>
                </div>
                <div class="position-relative mb-4">
                  <canvas id="chart1" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Tempo Total de Acessos</h3>
                  <a href="#">Ver relatório</a> <!-- relatorioTempoAcesso.php -->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?= $_GET['totHoras']?> Horas</span>
                    <span>Total de horas (Últimos 10 dias)</span>
                  </p>
                </div>
                <div class="position-relative mb-4">
                  <canvas id="chart2" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </section>
  </div>


  <script>
      $(function () {
      'use strict'
    
      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
    
      var mode      = 'index'
      var intersect = true
    
      var $chart1 = $('#chart1')
      var chart1  = new Chart($chart1, {
        type   : 'bar',
        data   : {
          labels  : ['01/05', '02/05', '03/05', '04/05', '05/05', '06/05', '07/05', '08/05', '09/05', '10/05'],
          datasets: [
            {
              backgroundColor: '#007bff',
              borderColor    : '#007bff',
              data           : [100, 200, 300, 250, 270, 250, 300, 420, 180,210]
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips           : {
            mode     : mode,
            intersect: intersect
          },
          hover              : {
            mode     : mode,
            intersect: intersect
          },
          legend             : {
            display: false
          },
          scales             : {
            yAxes: [{
              // display: false,
              gridLines: {
                display      : true,
                lineWidth    : '4px',
                color        : 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks    : $.extend({
                beginAtZero: true,
    
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }
                  return value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display  : true,
              gridLines: {
                display: false
              },
              ticks    : ticksStyle
            }]
          }
        }
      })

      var $chart2 = $('#chart2')
      var chart2  = new Chart($chart2, {
        type   : 'bar',
        data   : {
          labels  : ['01/05', '02/05', '03/05', '04/05', '05/05', '06/05', '07/05', '08/05', '09/05', '10/05'],
          datasets: [
            {
              backgroundColor: '#17a2b8',
              borderColor    : '#17a2b8',
              data           : [200, 1700, 2700, 2000, 1800, 1500, 2000, 400, 1200, 1800]
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips           : {
            mode     : mode,
            intersect: intersect
          },
          hover              : {
            mode     : mode,
            intersect: intersect
          },
          legend             : {
            display: false
          },
          scales             : {
            yAxes: [{
              // display: false,
              gridLines: {
                display      : true,
                lineWidth    : '4px',
                color        : 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks    : $.extend({
                beginAtZero: true,
    
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }
                  return value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display  : true,
              gridLines: {
                display: false
              },
              ticks    : ticksStyle
            }]
          }
        }
      })
    })
    

  </script>
  <!-- OPTIONAL SCRIPTS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- <script src="../js/dashboardCharts.js"></script> -->
<?php
include ('../includes/footer.php');
?>