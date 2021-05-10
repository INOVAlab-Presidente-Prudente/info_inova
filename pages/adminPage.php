<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini" onload="document.title='HomePage'">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
      <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <div class="display-4">Seja Bem-Vindo</div>
              </div>
            </div>
          </div>
        </section>
        <section class="content">
          <?php 
            if (isset($_GET['senha_alterada']))
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-check'></i>&nbspSenha Alterada!</h5>
                            <p>Senha com sucesso!.</p>
                      </div>";
          ?>
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

        </section>
      </div>
    </div>
<?php include('../includes/footer.php'); ?>
 
