<?php
  $titulo = "Vizualizar Usuário";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  require_once("../admin/DB.php");
  $sql = "	SELECT u.*, ai_descricao, pu_descricao, emp_nome_fantasia, emp_razao_social
            FROM usuario u 
            LEFT JOIN empresa emp ON emp.emp_id = u.emp_id
            LEFT JOIN perfil_usuario pu ON pu.pu_id = u.pu_id
            LEFT JOIN area_interesse ai ON ai.ai_id = u.ai_id
            WHERE u.usu_cpf = '".$_GET['cpf']."' "; 
  $query = mysqli_query($connect, $sql);
  if($query)
    $row = mysqli_fetch_assoc($query);
  else
    header("location: /pages/adminPage.php");
?>
  <div class="modal-hover" width="250x" height="250px" style="display : none" >
    <img id="img-hover"  width="250px" height="250px" class="elevation-2 mr-1" src="" style="border-radius: 100%;"/> <!-- style="width=25px; heigth=25px;" class="user-img elevation-2 mr-1"  -->
  </div>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Usuário</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarUsuario.php">Usuários</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <?php 
              if (isset($_GET['usuario_alterado'])){
                echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-check'></i>&nbspUsuário Alterado!</h5>
                    <p>Usuário foi alterado com sucesso!</p>
                </div>";
              }
              if (isset($_GET['usuario_nao_alterado'])){
                  echo "<div class='alert alert-warning alert-dismissible'>
                          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                          <h5><i class='fas fa-exclamation-triangle'></i>&nbspErro ao alterar!</h5>
                          <p>Não foi possível alterar este usuário, contate um administrador.</p>
                        </div>";
              }
              if (isset($_GET['erro'])){
                echo "<div class='alert alert-warning alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                        <p>Você nao tem permissão para alterar um usuário com esse perfil.</p>
                      </div>";
              }
            ?>
            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-12 mb-4">
                  
                    <?php 
                        if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                            echo '<img id="imgUsuario" src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="profile-user-img img-fluid img-circle border-2 border-default" style="height:100px;" alt="User Image">';
                        else
                            echo '<img id="imgUsuario" src="../images/avatar-df.png" class="profile-user-img img-fluid img-circle border-2 border-default" alt="User Image">';
                    ?>
                  
                  <h2><?=htmlspecialchars($row['usu_nome'])?></h2>
                  <a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>&alterar=true" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Usuário
                  </a>
                </div>
              </div>
              <div class="row invoice-info mb-4">
                <div class="col-md-4 invoice-col">
                  <b>Email: </b><?=htmlspecialchars($row['usu_email'])?><br/>
                  <b>Data de nascimento: </b><?=date_format(date_create($row['usu_data_nascimento']),"d/m/Y")?><br/>
                  <b>RG: </b><?=htmlspecialchars($row['usu_rg'])?><br/>
                  <b>CPF: </b><?=htmlspecialchars($row['usu_cpf'])?><br/>
                  <b>Telefone: </b><?=htmlspecialchars($row['usu_telefone'])?><br/>
                  <!-- Fazer Verificação para ver se tem responsável -->
                  <?php           
                    if($row['usu_responsavel'] != null && $row['usu_tel_responsavel'] != null){
                        echo "<b>Nome do Responsável: </b>".htmlspecialchars($row['usu_responsavel'])."<br/>";
                        echo "<b>Telefone do Responsável: </b>".htmlspecialchars($row['usu_tel_responsavel'])."<br/>";
                    }
                  ?>
                </div>
                <div class="col-md-4 invoice-col">
                  <b>Área de Atuação: </b><?=htmlspecialchars($row['usu_area_atuacao'])?><br/>
                  <b>Área de Interesse: </b><?=htmlspecialchars($row['ai_descricao'])?><br/>
                  <?php 
                    if ($row['emp_id'] != null):
                      $empresa = $row['emp_nome_fantasia'] ? $row['emp_nome_fantasia'] : $row['emp_razao_social'];
                  ?>
                    <b>Empresa: </b><?=htmlspecialchars($empresa)?><br/>
                    <b>Socio: </b><?=$row['usu_socio'] ? "Sim" : "Não";?><br/>                  
                  <?php endif;?>
                  <b>Perfil de Usuário: </b><?=htmlspecialchars(ucwords($row['pu_descricao']))?><br/>
                </div>
                <div class="col-md-4 invoice-col">
                  <address>
                    <b>CEP: </b><?=htmlspecialchars($row['usu_cep'])?><br/>
                    <b>Endereço: </b><?=htmlspecialchars($row['usu_endereco'])?><br/>
                    <b>Número: </b><?=htmlspecialchars($row['usu_numero'])?><br/>
                    <b>Complemento: </b><?=htmlspecialchars($row['usu_complemento'])?><br/>
                    <b>Bairro: </b><?=htmlspecialchars($row['usu_bairro'])?><br/>                
                    <b>Cidade: </b><?=htmlspecialchars($row['usu_municipio'])?><br/>
                    <b>Estado: </b><?=htmlspecialchars($row['usu_estado'])?><br/>
                  </address>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <?php
          $arr = [];
          $datas = [];
          $horas = [];
          $dataAno = [];
          for($i = 0; $i <10; $i++){
            $sqlt = "SELECT count(che_id) as qtd, DATE(NOW() -INTERVAL ".$i." DAY) as data, SEC_TO_TIME(SUM(TIME_TO_SEC(che_horario_saida) - TIME_TO_SEC(che_horario_entrada))) as hora FROM check_in WHERE DATE(che_horario_entrada) = DATE(NOW() -INTERVAL ".$i." DAY) AND che_horario_saida IS NOT NULL AND usu_id = ".$row['usu_id'];
            $queryt = mysqli_query($connect, $sqlt);
            if($queryt != null){
                $rowt = mysqli_fetch_assoc($queryt);
                $arr[$i] = intval($rowt['qtd']);
                $datas[$i] = date_format(date_create($rowt['data']),"d/m");
                $dataAno[$i] = date_format(date_create($rowt['data']),"Y-m-d");
                $horas[$i] = intval(explode(":", $rowt['hora'])[0]);
            }
            else
              var_dump(mysqli_error($connect));
          }
          $acessos = array_sum($arr);
          $totHoras = array_sum($horas);
          $dtInicio = $dataAno[9];
          $dtFim = $dataAno[0];
        ?>       
        <div class="row">
          <div class="col-lg-7">
            <div class="card">
              <div class="card-header border-0" style="height: 50.4px">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Tempo Total de Acessos</h3>
                  <a href="relatorioCoworking.php">Ver relatório</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?=$totHoras?> Horas</span>
                    <span>Total de horas (Últimos 10 dias)</span>
                  </p>
                </div>
                <div class="position-relative mb-4">
                  <canvas id="chart2" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <p class="card-title">Entrada e Saída</p>
                  <a href="relatorioCoworking.php">Ver relatório</a>
                </div>
              </div>
              <?php
                $sql = "SELECT  DATE(che_horario_entrada) AS dia, TIME(che_horario_entrada) AS horaIni,
                                TIME(che_horario_saida) AS horaFim FROM check_in 
                                WHERE usu_id = ".$row['usu_id']." AND che_horario_entrada >= DATE(NOW() -INTERVAL 10 DAY)
                                ORDER BY che_horario_saida DESC";
                $queryCheckin = mysqli_query($connect, $sql);
                $checkins = mysqli_fetch_assoc($queryCheckin);
              ?>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 335px;">
                <table class="table table-bordered table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Data</th>
                      <th>Entrada</th>
                      <th>Saída</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($checkins != null){ ?>
                        <tr>
                          <td><?=date_format(date_create($checkins['dia']),"d/m/Y")?></td>
                          <td><?=substr($checkins['horaIni'],0,5)?></td>
                          <td><?=substr($checkins['horaFim'],0,5)?></td>
                        </tr>
                    <?php
                        $checkins = mysqli_fetch_assoc($queryCheckin);
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div> 
      </div>
    </section>

    

    <!-- colocar os cards de graficos aqui -->

  </div>
<script>
  const img = document.getElementById('imgUsuario');
  $('#imgUsuario').hover(function(e) {
      document.getElementById("img-hover").src=""+$(this).prop("src");
      $(".modal-hover").css({left: getOffset(img).left + 130});
      $(".modal-hover").css({top: getOffset(img).top - 70});
        $('.modal-hover').show();  
    },function(){
      if($('.modal-hover:hover').length <= 0)
        $('.modal-hover').hide();
    }
  );

  $(function () {
      'use strict'
    
      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
    
      var mode      = 'index'
      var intersect = true

      //grafico 2
      var $chart2 = $('#chart2')
      var chart2  = new Chart($chart2, {
        type   : 'bar',
        data   : {
          labels  : ['<?=$datas[9]?>', '<?=$datas[8]?>', '<?=$datas[7]?>', '<?=$datas[6]?>', '<?=$datas[5]?>', '<?=$datas[4]?>', '<?=$datas[3]?>', '<?=$datas[2]?>', '<?=$datas[1]?>', '<?=$datas[0]?>'],
          datasets: [
            {
              backgroundColor: '#17a2b8',
              borderColor    : '#17a2b8',
              data           : [<?=$horas[9]?>, <?=$horas[8]?>, <?=$horas[7]?>, <?=$horas[6]?>, <?=$horas[5]?>, <?=$horas[4]?>, <?=$horas[3]?>, <?=$horas[2]?>, <?=$horas[1]?>, <?=$horas[0]?>]
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
  });
      console.log("Chart 1: "+chart1+"\nChart 2:"+chart2)
</script>
<!-- OPTIONAL SCRIPTS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- <script src="../js/dashboardCharts.js"></script> -->
<?php
  include ('../includes/footer.php');
?>