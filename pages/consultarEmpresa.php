<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Consultar Empresa'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
  <div class="wrapper"> 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Consultar Empresa</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                <li class="breadcrumb-item active">Consulta Empresa</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <form action="../admin/PesquisaEmpresa.php" id="quickForm" method="post">
                  <?php if (isset($_GET['empresa_excluida'])) {?>
                      <div class='alert alert-success' role='alert'>Empresa foi excluida</div>
                  <?php } ?>
                  <?php if (isset($_GET['empresa_nao_existe'])) {?>
                      <div class='alert alert-warning' role='alert'>Empresa nao existe</div>
                  <?php } ?>
                  <div class="card-body">
                      <div class="form-group">
                          <label for="cnpj">CNPJ</label>
                          <input type="text" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}" minlength="18" maxlength="18" name="cnpj" class="form-control" id="cnpj" placeholder="xx.xxx.xxx/0001-xx">
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
                  <div class="card-header"><h3 class="card-title"> Lista de Empresas</h3></div>
                  
                  <div class="card-footer mid">
                    <?php 
                      require_once("../admin/DB.php");
                      $sql = 'SELECT * FROM empresa ORDER BY emp_razao_social';
                      $query = mysqli_query($connect, $sql);
                      $row = mysqli_fetch_assoc($query);
                    ?>
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                              <th>Razão Social</th>
                              <th>CNPJ</th>
                              <th>Alterar</th>
                              <th>Excluir</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while($row != null) { ?>
                            <tr>
                              <td><a href="consultarEmpresaEdit.php?cnpj=<?=$row['emp_cnpj']?>"><?= strlen($row['emp_razao_social']) >= 35 ? substr($row['emp_razao_social'], 0, 35)."..." : $row['emp_razao_social']?></a></td>
                              <td><?= $row['emp_cnpj']?></td>
                              <!-- botoes -->
                              <td><button class="btn btn-warning center" name="alterar" onclick="redireciona('<?=$row['emp_cnpj']?>')">
                                <i class="fas fa-user-edit"></i>
                              </button></td>
                              <td><button class="btn btn-danger center" name="excluir" onclick="excluirEmpresa(this,'<?=$row['emp_razao_social']?>','<?=$row['emp_cnpj']?>')">
                                <i class="fas fa-trash-alt"></i>
                              </button></td>
                            </tr>
                          <?php 
                            $row = mysqli_fetch_assoc($query);  
                          }?> 
                        </tbody>
                      </table>
                    </div><!-- fim do card-body -->
                  </div> <!-- fim do card-footer-->
            </div><!-- fim do card-->
          </div> <!-- fim div col-md-12-->
        </div>
      </section>
      </div>
      <section id="modal-excluir">
        <div class="modal-content">
            <h4>Excluir Empresa</h4>
            <p id="mensagem"></p>
            <div class="d-flex justify-content-center">
              <button id="btn-sim" class='btn btn-danger'>Sim</button>
              <button id="btn-nao" class='btn btn-light'>Não</button>
            </div>
        </div>     
      </section>
    </div>
  </div>
      <script>
          const modal = document.getElementById("modal-excluir");
          const btnSim = document.getElementById("btn-sim");
          const btnNao = document.getElementById("btn-nao");

        function redireciona(cnpj){
            window.location.href="consultarEmpresaEdit.php?cnpj="+cnpj+"&alterar=enabled";
        }

        function excluirEmpresa(e, razao, cnpj){
          if (e.target == document.getElementById("btn-excluir")) {
                modal.style.display = "block";
                document.getElementById("mensagem").innerText = `Deseja excluir a empresa ${razao} cnpj ${cnpj}?`;
              }
              btnSim.onclick = () => {
                window.location.href="../admin/ExcluiEmpresa.php?cnpj="+cnpj;
              }
        }

        window.onclick = (e) => {
            if (e.target === modal || e.target === btnNao)
              modal.style.display = 'none';
        }
      </script>
    
<?php include('../includes/footer.php'); ?>
 