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
</div>
<?php
  include ('../includes/footer.php');
?>