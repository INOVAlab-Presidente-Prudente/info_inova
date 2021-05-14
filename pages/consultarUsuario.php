<?php include("../includes/header.php")?>
<?php include("../includes/primeirologin.php")?>
<?php include("../includes/permissoes.php")?>
<body class="hold-transition sidebar-mini" onload="document.title=' Consulta de Usuario'">
  <?php include("../includes/navbar.php")?>
  <?php include("../includes/sidebar.php")?>
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Consultar Usuário</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                <li class="breadcrumb-item active">Consulta de Usuário</li>
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
                <form action="../admin/PesquisaUsuario.php"id="quickForm" method="post">
                  <?php if (isset($_GET['usuario_nao_existe'])) {?>
                      <div class='alert alert-warning' role='alert'>Usuario nao existe</div>
                  <?php } ?>
                  <div class="card-body">
                      <div class="form-group">
                          <label for="cpf">CPF</label>
                          <input type="text" name="cpf" class="form-control" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" id="cpf" placeholder="xxx.xxx.xxx-xx">
                      </div> 
                  </div>
                  <div class="card-footer mid">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                    <!-- Depois validar para redirecionar para determinadas -->
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> Lista de Usuários</h3>
                </div>
                <div class="card-footer mid">
                  <?php
                      if (isset($_GET['usuario_excluido'])){
                          echo "<div class='alert alert-success alert-dismissible'>
                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                  <h5><i class='fas fa-check'></i>&nbspUsuario excluído!</h5>
                                      <p>O(A) usuário(a) foi excluído(a) com sucesso!.</p>
                                </div>";
                      }
                      if (isset($_GET['erro'])){
                          echo "<div class='alert alert-warning alert-dismissible'>
                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                  <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                                  <p>Você nao tem permissão para excluir um(a) usuário(a) com esse perfil.</p>
                                </div>";
                      }
                      require_once("../admin/DB.php");
                      $sql = 'SELECT * FROM usuario ORDER BY usu_nome';
                      $query = mysqli_query($connect, $sql);
                      $row = mysqli_fetch_assoc($query);
                  ?>
                  <div class="card-body table-responsive p-0 " style="height: 400px;">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Alterar</th>
                            <th>Excluir</th>
                            <th>Ocorrências</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row != null) { ?>
                            <tr>
                                <td><a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>"><?=$row['usu_nome']?></a></td>
                                <td><?=$row['usu_cpf']?></td>

                                <?php $dis = (($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf'])))? "":"disabled"?>

                                <td><button <?=$dis?> class='btn btn-warning center' name="alterar" onclick="redireciona(1,'<?=$row['usu_cpf']?>')"><i class="fas fa-user-edit"></i></button>
                                <td><button <?=$dis?> class='btn btn-danger center' name="excluir" onclick="excluirUsuario(this, '<?=$row['usu_nome']?>', '<?=$row['usu_cpf']?>')"><i class="fas fa-trash-alt"></i></button>
                                <td><button <?=$dis?> class='btn btn-info center' name="ocorrencias" onclick="redireciona(3,'<?=$row['usu_id']?>')"><i class="fas fa-sign"></i></button>
                                
                            </tr>
                        <?php 
                            $row = mysqli_fetch_assoc($query);    
                        } 
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </section>
      </div>
      <div id="modal-excluir">
        <div class="modal-content"> 
            <div class="container-fluid"> 
                <div class="row align-itens-center justify-content-center">
                <div class="text-center"> 
                    <h4>Excluir Usuário</h4> 
                    <p id="mensagem"></p>
                </div>
                <div class="d-flex">
                    <button id="btn-sim" class='btn btn-danger'>Sim</button>
                    <div class="col-1"></div>
                    <button id="btn-nao" class='btn btn-light'>Não</button>
                </div>
                </div>
            </div>  
        </div> 
      </div>
    </div>      
    <script>
        function redireciona(i, cod){
            switch (i){
                case 1:
                    window.location.href="consultarUsuarioEdit.php?cpf="+cod+"&alterar=enabled"; break;
                case 3:
                    window.location.href="ocorrencias.php?usu_id="+cod; break;
            }
        }
        const modal = document.getElementById("modal-excluir");
        const btnSim = document.getElementById("btn-sim");
        const btnNao = document.getElementById("btn-nao");

        function excluirUsuario(e, nome, cpf) {
            if (e.target == document.getElementById("btn-excluir")) {
              modal.style.display = "block";
              document.getElementById("mensagem").innerText = `Deseja excluir o usuário ${nome} CPF ${cpf}?`;
            }
            btnSim.onclick = () => {
              window.location.href="../admin/ExcluiUsuario.php?cpf="+cpf;
            }
        }
        window.onclick = (e) => {
            if (e.target === modal || e.target === btnNao)
              modal.style.display = 'none';
        }
    </script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>

<?php include('../includes/footer.php'); ?>