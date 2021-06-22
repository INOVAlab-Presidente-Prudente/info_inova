<?php
  $titulo = "Visualizar Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  if(isset($_GET['sala_id'])){
      require_once("../admin/DB.php");
      $sql = "SELECT * FROM sala WHERE sa_id = ".$_GET['sala_id']."";
      $query = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($query);
      
      if($row == NULL)
          header("location: consultarSala.php");
  }else
      header("location: consultarSala.php");
?> 
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <!-- Flash message -->
        <?php 
            if (isset($_GET['sala_alterada'])){
              echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='fas fa-check'></i>&nbspSala Alterada!</h5>
                  <p>Sala foi alterado com sucesso!</p>
              </div>";
            }
            if(isset($_GET['erro-alterar'])){
                echo "<div class='alert alert-info alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-info'></i>&nbspModalidade não alterada!</h5>
                        <p>Não foi possível alterar a modalidade, tente novamente!</p>
                      </div>";
            }
            if (isset($_GET['reserva_excluida'])) {
              echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-check'></i>&nbspReserva Excluída!</h5>
                    <p>A Reserva foi excluída com sucesso!</p>
              </div>";
            } 
            if (isset($_GET['erro_excluir'])) {
              echo "<div class='alert alert-warning alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='icon fas fa-exclamation-triangle'></i>Exclusão Negada!</h5>
                    <p>Ocorreu um erro ao excluir essa reserva.</p>
              </div>";
            } 
        ?>
        <!-- /.flash message -->
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Sala</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="checkin.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
            <!-- /.Breadcrumbs -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
            <!-- title row -->
              <div class="row">
                <div class="col-12 mb-4">
                  <h2><?=htmlspecialchars(ucwords($row['sa_nome_espaco']))?></h2>
                  <a href="consultarSalaEdit.php?sala_id=<?=$_GET['sala_id']?>&alterar=enabled" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Sala
                  </a>
                </div>
                <!-- /.col -->
              </div>
            <!-- info row -->
              <div class="row invoice-info mb-4">
                <div class="col-md-4 invoice-col">
                  <b>Nome do espaço:</b> <?=htmlspecialchars($row['sa_nome_espaco'])?><br>
                  <b>Capacidade:</b> <?=htmlspecialchars($row['sa_capacidade'])?><br>
                  <b>Valor por perído:</b> R$<?=htmlspecialchars($row['sa_valor_periodo'])?><br>
                  <b>Valor por hora:</b> R$<?=htmlspecialchars($row['sa_valor_hora'])?><br>
                  <b>Localização:</b> <?=htmlspecialchars($row['sa_localizacao'])?><br>
                </div>
                <div class="col-md-4 invoice-col">
                  <b>Ambiente climatizado:</b> <?=$row['sa_ambiente_climatizado'] == 1 ? "sim" : "não"?><br>  
                  <b>Projetor:</b> <?=$row['sa_projetor'] == 1 ? "sim" : "não"?><br>  
                  <b>Caixas de som:</b> <?=$row['sa_caixa_som']?><br>  
                  <b>Cadeiras com apoio:</b> <?=$row['sa_cadeiras_apoio'] == 1 ? "sim" : "não"?><br>
                  <b>Iluminação:</b> <?=htmlspecialchars(ucwords($row['sa_iluminacao']))?><br>  
                </div>
                <div class="col-md-4 invoice-col">
                  <b>Disponibilidade:</b> <?=$row['sa_disponibilidade'] == 1 ? "Disponível" : "não" ?><br>  
                  <b>Frigobar:</b> <?=$row['sa_frigobar'] == 1 ? "sim" : "não" ?><br>  
                  <b>Computadores:</b> <?=htmlspecialchars($row['sa_computadores'])?><br>  
                  <b>Mesas:</b> <?=htmlspecialchars($row['sa_mesas'])?><br>  
                  <b>Cadeiras:</b> <?=htmlspecialchars($row['sa_cadeiras'])?><br>  
                </div>
                <!-- /.col -->
              </div><!-- /.row -->
              <?php if(strlen($row['sa_observacoes'])>0){ ?>
                <div class="row invoice-info mb-4">
                  <div class="col-12 invoice-col">
                      <b>Observações:</b> <?=htmlspecialchars($row['sa_observacoes']);?>
                      <br>  
                  </div>
                </div>
              <?php 
                }
              ?>
            </div><!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <section class="content">     
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">            
            <p class="card-title">Reservas da sala</p>
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <a href="reservarSala.php?sala_id=<?=$_GET['sala_id']?>" class="btn btn-sm btn-success mr-2">
                  <i class="far fa-calendar-check"></i>&nbsp;
                  Reservar Sala
                </a>
                <input type="text" id="pesquisar" class="form-control" placeholder="Pesquisar">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="tabela-salas" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Locador</th>
                  <th>Data</th>
                  <th>Horário Início</th>                  
                  <th>Horário Fim</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $sql = "SELECT * FROM reserva_sala r
                          left join usuario u on r.usu_id = u.usu_id
                          left join empresa e on r.emp_id = e.emp_id
                          WHERE sa_id = ".$_GET['sala_id'];
                  $query = mysqli_query($connect, $sql);
                  $dados = mysqli_fetch_assoc($query);

                  while($dados != null){
                    $data = date_format(date_create(explode(" ", $dados['res_inicio'])[0]), "d/m/Y");
                    $horaInicio = substr(explode(" ", $dados['res_inicio'])[1], 0, 5)."h";
                    $horaFim = substr(explode(" ", $dados['res_fim'])[1], 0, 5)."h";
                  ?>
                  <tr>
                    <td class=" text-nowrap"><a href="visualizarReserva.php?sala_id=<?=$_GET['sala_id']?>&res_id=<?=$dados['res_id']?>">
                      <?=$dados['emp_nome_fantasia'] != "" ? $dados['emp_nome_fantasia'] : $dados['usu_nome'] ?>
                    </td>
                    <td class=" text-nowrap"><?=$data?></td>
                    <td class=" text-nowrap"><?=$horaInicio?></td>
                    <td class=" text-nowrap"><?=$horaFim?></td>
                    <td class=" text-nowrap">
                      <a href="alterarReserva.php?sala_id=<?=$_GET['sala_id']?>&res_id=<?=$dados['res_id']?>" class="btn btn-warning btn-sm center">
                        <i class="far fa-edit"></i>&nbsp;
                        Alterar
                      </a>
                      <a href="../admin/ExcluiReserva.php?sala_id=<?=$_GET['sala_id']?>&res_id=<?=$dados['res_id']?>" class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir essa reserva?');">
                        <i class="far fa-trash-alt"></i>&nbsp;
                        Excluir
                      </a>
                    </td>
                  </tr>
                <?php 
                    $dados = mysqli_fetch_assoc($query);
                  }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </section>
</div>
<script>
    $('#tabela-salas').DataTable({
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
            "search": "Pesquisar",
            "paginate": {
              "first":      "First",
              "last":       "Last",
              "next":       "Próximo",
              "previous":   "Anterior"
            },
            "zeroRecords": "Nenhum dado encontrado."
        },
        
        "order": []
      });
      oTable = $('#tabela-salas').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
  </script>
<?php
  include ('../includes/footer.php');
?>