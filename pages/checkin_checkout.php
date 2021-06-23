<?php
  $titulo = "Checkin Checkout";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>  
  <div class="modal-hover" width="175x" height="175px" style="display : none" >
    <img id="img-hover"  width="175px" height="175px" class="elevation-2 mr-1" src="" style="border-radius: 100%;"/> <!-- style="width=25px; heigth=25px;" class="user-img elevation-2 mr-1"  -->
  </div>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coworking</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
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
            <p class="card-title">Lista de usuários Ativos</p>
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <input type="text" id="pesquisar" class="form-control" placeholder="Pesquisar">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>              
            </div>
          </div>
          <div class="card-body table-responsive">
            
            <table id="tabela-checkins" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Empresa</th>
                  <th>Horário de Entrada</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  require_once('../admin/DB.php');
                  $sql = "SELECT r.usu_id, r.usu_nome, r.usu_cpf, r.emp_razao_social, r.emp_nome_fantasia, c.che_horario_entrada FROM (SELECT u.*, e.emp_razao_social, e.emp_nome_fantasia FROM usuario u LEFT JOIN empresa e ON e.emp_id = u.emp_id) r, check_in c WHERE c.usu_id = r.usu_id AND c.che_horario_saida IS NULL";
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
                            echo '<img src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="user-img img-circle elevation-2 mr-1" style="width: 35px; height: 35px" alt="User Image">';
                          else
                              echo '<img src="../images/avatar-df.png" class="user-img img-circle elevation-2 mr-1" style="width: 35px; height: 35px;" alt="User Image">';
                        ?>
                        <a href="visualizarUsuario.php?cpf=<?=$row['usu_cpf']?>"><?=htmlspecialchars($row['usu_nome'])?></a>
                      </td> 
                      <td class=" text-nowrap"><?=htmlspecialchars($row['usu_cpf'])?></td>
                      <?php 
                        if(empty($row['emp_nome_fantasia']))
                          $nome = strlen($row['emp_razao_social']) >= 35 ? substr($row['emp_razao_social'], 0, 35)."..." : $row['emp_razao_social'];
                        else
                          $nome = $row['emp_nome_fantasia'];
                      ?>
                      <td class=" text-nowrap"><?=htmlspecialchars($nome)?></td>
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

    $('.user-img').hover(function(e) {
      document.getElementById("img-hover").src=""+$(this).prop("src");
      $(".modal-hover").css({left: getOffset(this).left + 70});
      $(".modal-hover").css({top: getOffset(this).top - 60});
        $('.modal-hover').show();  
    },function(){
      if($('.modal-hover:hover').length <= 0)
        $('.modal-hover').hide();
    });

    // $(".text-nowrap").hover(function(){
    //   $(".modal-hover").css({display: 'none'});
    // })
    function checkout(cpf){
      window.location.href = "../admin/CheckInUsuario.php?cpf="+cpf;
    }
    $('#tabela-checkins').DataTable({
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
        }
      });
      oTable = $('#tabela-checkins').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
  </script>
<?php
  include ('../includes/footer.php');
?>