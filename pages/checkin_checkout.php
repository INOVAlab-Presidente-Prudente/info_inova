<?php
  $titulo = "Checkin Checkout";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Check-in / Check-out</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_page.php">Início</a></li>
              <li class="breadcrumb-item active">Checkin-Checkout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de usuários no Coworking</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Horário de Entrada</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  require_once('../admin/DB.php');
                  $sql = "SELECT u.usu_id, u.usu_nome, u.usu_cpf, c.che_horario_entrada FROM usuario u, check_in c
                          WHERE c.usu_id = u.usu_id AND c.che_horario_saida IS NULL";
                  $query = mysqli_query($connect, $sql);
                  if($query)
                    $row = mysqli_fetch_assoc($query);
                  else{
                    $row = null;
                    echo mysqli_error($connect);
                  }
                  while($row != null){ 
                    $data = date_create($row['che_horario_entrada']);?>
                    <tr>
                      <td class=" text-nowrap">
                        <a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>"><?=$row['usu_nome']?></a>
                      </td> 
                      <td class=" text-nowrap"><?=$row['usu_cpf']?></td>
                      <td class=" text-nowrap"><?= date_format($data, 'H\h:i')?> - <?=date_format($data,"d/m/Y")?></td>
                      <td class=" text-nowrap">
                        <button onclick='checkout("<?=$row["usu_cpf"]?>")' class="btn btn-danger btn-sm center">Fazer Checkout</button>
                      </td>
                    </tr><?php 
                    $row = mysqli_fetch_assoc($query);
                  } 
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <script>
      function checkout(cpf){
        window.location.href = "../admin/CheckInUsuario.php?cpf="+cpf;
      }
  </script>
  <!-- /.content-wrapper -->
<?php
  include ('../includes/footer.php');
?>