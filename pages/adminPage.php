<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <div class="display-4">Seja Bem-Vindo</div>
              </div>
              <!-- Mostrar o nome do user nessa HomePage -->
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <?php 
            if (isset($_GET['senha_alterada']))
                echo "<div class='alert alert-success' role='alert' >Senha alterada</div>";
          ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Painel</h3>
              
              
            </div>
            <div class="card-body">
              Bem vindo ao painel do InfoInova
              <p>Selecione uma das funcionalidades na barra lateral para conseguir usufruir do sistema</p>
              <div class="row">
                <img class="img-thumbnail" src="../images/Coworking_home.jpg" alt="imageHome">
              
              </div>
            </div>
            
          </div>
          <!-- /.card -->

        </section>
      </div>
    </div>
<?php include('../includes/footer.php'); ?>
 
