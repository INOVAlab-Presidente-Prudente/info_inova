<?php
  $titulo = "Visualizar Modalidade";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");

  if(isset($_GET['mod_id'])){
      require_once("../admin/DB.php");
      $sql = "SELECT * FROM modalidade WHERE mod_id = ".$_GET['mod_id']."";
      $query = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($query);
      
      if($row == NULL)
          header("location: consultarModalidade.php");
  }else
      header("location: consultarModalidade.php");
?> 
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <!-- Flash message -->
        <?php 
            if(isset($_GET['modalidade-alterada'])){
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-check'></i>&nbspModalidade alterada!</h5>
                        <p>A Modalidade com alterada com sucesso!</p>
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
            <h1>Visualizar Modalidade</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="checkin.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarModalidade.php">Modalidades</a></li>
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
                  <h2><?=ucwords($row['mod_nome'])?></h2>
                  <a href="consultarModalidadeEdit.php?mod_id=<?=$_GET['mod_id']?>&alterar=enabled" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Modalidade
                  </a>
                </div>
                <!-- /.col -->
              </div>
            <!-- info row -->
              <div class="row invoice-info mb-2">
                <div class="col-md-10 offset-md-1 invoice-col">
                  <b>Código:</b> <?=$row['mod_codigo']?><br>
                  <b>Nome:</b> <?=ucwords($row['mod_nome'])?><br>
                  <b>Descrição:</b> <?=$row['mod_descricao']?><br>
                  <b>Valor Mensal:</b> R$<?=$row['mod_valMensal']?><br>
                  <b>Valor Anual:</b> R$<?=$row['mod_valAnual']?><br>
                  <b>Edital:</b> <?=ucwords($row['mod_edital'])?><br>  
                </div>
                <!-- /.col -->
              </div><!-- /.row -->
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