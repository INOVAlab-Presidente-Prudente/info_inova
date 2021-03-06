<?php
  $titulo = "Consultar de Usuário";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ("../includes/primeirologin.php");
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
            <h1>Usuários</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item active">Usuários</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">     
      <div class="col-md-12">
        <?php 
          if (isset($_GET['usuario_cadastrado'])){
            echo "<div class='col alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspUsuário Cadastrado!</h5>
                        <p>O usuário foi cadastrado com sucesso!</p>
                  </div>";
          }
          if (isset($_GET['usuario_excluido'])){
              echo "<div class='alert alert-success alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h5><i class='fas fa-check'></i>&nbspUsuario excluído!</h5>
                          <p>O usuário foi excluído com sucesso!</p>
                    </div>";
          }
          if (isset($_GET['erro'])){
              echo "<div class='alert alert-warning alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                      <p>Você nao tem permissão para excluir um usuário com esse perfil.</p>
                    </div>";
          }
          if (isset($_GET['usuario_nao_existe'])) {
            echo "<div class='alert alert-warning alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h5><i class='fas fa-exclamation-triangle'></i>&nbspUsuário não encontrado!</h5>
                  <p>O usuário não foi econtrado no sistema.</p>
                </div>"; 
          }
        ?>
        <div class="card">
        <div class="card-header">             
            <p class="card-title">Lista de usuários</p>
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <a href="cadastrarUsuario.php" class="btn btn-sm btn-success mr-2">
                  <i class="fas fa-user-plus"></i>&nbsp;
                  Cadastrar
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
            <table id="tabela-usuarios" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>  
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Empresa</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  require_once("../admin/DB.php");
                  $sql = 'SELECT u.*, e.emp_nome_fantasia, e.emp_razao_social, e.emp_cnpj FROM usuario u LEFT JOIN empresa e ON u.emp_id = e.emp_id ORDER BY usu_nome';
                  $query = mysqli_query($connect, $sql);
                  $row = mysqli_fetch_assoc($query);
                  while ($row != null):
                ?>
                <tr>
                  <td class=" text-nowrap">
                    <?php
                      if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                        echo '<img src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" id="user-img" class="user-img img-circle elevation-2 mr-1" style="width: 35px; height: 35px" alt="User Image">';
                      else
                          echo '<img src="../images/avatar-df.png" id="user-img" class="user-img img-circle elevation-2 mr-1" style="width: 35px; height: 35px;" alt="User Image">';
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
                  <td class=" text-nowrap">
                    <a href="visualizarEmpresa.php?cnpj=<?=$row['emp_cnpj']?>"><?=htmlspecialchars($nome)?></a>
                  </td>


                  <?php $dis = (($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf'])))? "":"disabled"?>
                  <td class=" text-nowrap">
                    <a <?=$dis?> class="btn btn-info btn-sm center" name="ocorrencias" href="ocorrencias.php?usu_id=<?=$row['usu_id']?>">
                      <i class="fas fa-portrait"></i>&nbsp;
                      Ocorrências
                    </a>
                    <a <?=$dis?> class='btn btn-warning btn-sm center' name="alterar" href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>&alterar=true">
                      <i class="far fa-edit"></i>&nbsp;
                      Alterar
                    </a>
                    <a href="../admin/ExcluiUsuario.php?cpf=<?=$row['usu_cpf']?>" class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir esse usuário?');">
                      <i class="far fa-trash-alt"></i>&nbsp;
                      Excluir
                    </a>
                  </td>
                </tr>
                  <?php 
                    $row = mysqli_fetch_assoc($query);
                    endwhile;
                  ?>
              </tbody>
            </table>

          </div>
          <!-- /.card-body -->
        <!-- /.card -->
      </div>
    </section>
    <!-- /.content -->
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

    $('#tabela-usuarios').DataTable({
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
      oTable = $('#tabela-usuarios').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
  </script>
  
<?php
  include ('../includes/modal_usuarios.php');
  include ('../includes/footer.php');
?>