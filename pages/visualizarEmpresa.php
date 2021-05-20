<?php
  $titulo = "Visualizar Empresa";
  include ('../includes/header.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

    if(isset($_GET['cnpj'])){

        require_once("../admin/DB.php");
        $sql = "SELECT * FROM empresa WHERE emp_cnpj = '".$_GET['cnpj']."'";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
        
        if($row == NULL)
            header("location: consultarEmpresa.php");
    }
    else
        header("location: consultarEmpresa.php");
?> 
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <?php 
        if (isset($_GET['empresa_alterada'])){
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEmpresa Alterada!</h5>
                        <p>A empresa foi alterada com sucesso!</p>
                  </div>";

        }
        ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Empresa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="checkin.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarEmpresa.php">Empresas</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
            <!-- /.Breadcrumbs -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Flash message -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10 offset-md-1">

        </div>
      </div>
    </div>    
    <!-- /.flash message -->

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
                  <h2><?=ucwords($row['emp_nome_fantasia'] == null ? $row['emp_razao_social'] : $row['emp_nome_fantasia']) ?></h2>
                  <a href="consultarEmpresaEdit.php?cnpj=<?=$_GET['cnpj']?>&alterar=enabled" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Empresa
                  </a>
                </div>
                <!-- /.col -->
              </div>
            <!-- info row -->
              <div class="row invoice-info mb-2">
                <div class="col-md-10 offset-md-1 invoice-col">
                  <b>CNPJ:</b> <?=$row['emp_cnpj']?><br>
                  <b>Telefone:</b> <?=$row['emp_telefone']?><br>
                  <b>Razão Social:</b> <?=strtoupper($row['emp_razao_social'])?><br>
                  <b>Nome Fantasia:</b> <?=$row['emp_nome_fantasia']?><br>
                  <b>Atividade Principal:</b> <?=$row['emp_area_atuacao']?><br>  
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