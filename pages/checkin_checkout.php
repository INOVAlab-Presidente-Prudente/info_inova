<?php
  $titulo = "Checkin Checkout";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>  
  <div class="content-wrapper">
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
      </div>
    </section>
    <section class="content">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de usuários no Coworking</h3>
          </div>
          <div class="card-body table-responsive">
            <table id="tabela-checkins" class="table table-bordered table-striped table-hover">
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
                        <?php 
                          if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                            echo '<img src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="img-circle elevation-2 mr-1" style="width: 35px; height: 35px" alt="User Image">';
                          else
                              echo '<img src="../images/avatar-df.png" class="img-circle elevation-2 mr-1" style="width: 35px; height: 35px;" alt="User Image">';
                        ?>
                        <a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>"><?=$row['usu_nome']?></a>
                      </td> 
                      <td class=" text-nowrap"><?=$row['usu_cpf']?></td>
                      <td class=" text-nowrap"><?= date_format($data, 'H\hi')?> - <?=date_format($data,"d/m/Y")?></td>
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
        </div>
      </div>
    </section>
  </div>
  <script>
    function checkout(cpf){
      window.location.href = "../admin/CheckInUsuario.php?cpf="+cpf;
    }
    $('#tabela-checkins').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false 
      });
  </script>
<?php
  include ('../includes/footer.php');
?>