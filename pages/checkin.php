<?php include('../includes/header.php'); ?>
<?php include('../includes/permissoes.php'); ?>

<body onload="document.title=' Check In'" class="hold-transition sidebar-mini">

  <?php include('../includes/navbar.php'); ?>

  <?php include("../includes/sidebar.php");?>
  <div class="wrapper">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Check-in Usuário</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                <li class="breadcrumb-item active">Check-in</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <form action="../admin/CheckInUsuario.php" id="quickForm" method="get">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="cpf">CPF</label>
                      <input type="text" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" name="cpf" class="form-control" id="cpf" placeholder="xxx.xxx.xxx-xx">
                    </div> 
                  </div>
                  <div class="card-footer mid">
                    <button type="submit" class="btn btn-primary">Check-in / Check-out</button>
                  </div>
                </form>
                <?php 
                  date_default_timezone_set('America/Sao_Paulo');
                  if (isset($_GET['checkin']))
                  echo "<br><div class='alert alert-info' role='alert'>Horario de Entrada: ". date("H:i:sa")."</div>";
                  if (isset($_GET['checkout']))
                  echo "<br><div class='alert alert-info' role='alert'>Horario de Saída: ". date("H:i:sa")."</div>";
                  if (isset($_GET['erro']))
                  echo "<br><div class='alert alert-warning' role='alert'>CPF não encontrado</div>";
                ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Check-in Aberto</h3>
                </div>

                <div class="card-footer mid">
                  <?php 
                  require_once("../admin/DB.php");
                  $sql = 'SELECT * FROM check_in, usuario WHERE check_in.usu_id = usuario.usu_id AND che_horario_saida is NULL';
                  $query = mysqli_query($connect, $sql);
                  $row = mysqli_fetch_assoc($query);
                  ?>
                  <div class="card-body table-responsive p-0" style="height: 400px;">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Nome</th>
                          <th>CPF</th>
                          <th>Horário de Entrada</th>
                          <th>Checkout</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while($row != null) { ?>
                        <tr>
                          <td><?=$row['usu_nome']?></td>
                          <td><?=$row['usu_cpf']?></td>
                          <td><?=$row['che_horario_entrada']?></td>
                          <td><button class="btn btn-primary center" onclick="checkout('<?=$row['usu_cpf']?>')" name="fechar">Checkout</button></td>
                        </tr>
                        <?php 
                        $row = mysqli_fetch_assoc($query);  
                        }
                        ?> 
                      </tbody>
                    </table>
                  </div><!-- fim do card-body -->
                </div> <!-- fim do card-footer-->
              </div> <!-- fim do card-->
            </div> <!-- fim div col-md-12-->
          </div>
        </div>
      </section>
    </div>
  </div>
<script> 
  function checkout(cpf) {
    window.location.href="../admin/CheckInUsuario.php?cpf="+cpf;
  }
</script>
<?php include('../includes/footer.php'); ?>
