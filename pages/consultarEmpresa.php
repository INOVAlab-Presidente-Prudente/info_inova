<?php
  $titulo = "Consultar Empresa";
  include ('../includes/header.php');
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
            <h1>Empresas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item active">Empresas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- /.flash message -->

    <!-- Main content -->
    <section class="content">     
      <div class="col-md-12">
        <?php 
          if (isset($_GET['empresa_excluida'])) {
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEmpresa excluída!</h5>
                        <p>A empresa foi excluída com sucesso!.</p>
                  </div>";  
          }
          if (isset($_GET['empresa_nao_existe'])) {
            echo "<div class='alert alert-warning alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='icon fas fa-exclamation-triangle'></i> Empresa não encontrada!</h5>
                        <p>Empresa não encontrada no nosso sistema!</p>
                  </div>";
          }
        ?>
        <div class="card">
          <div class="card-header">
              <div class="float-right">
                  <a href="cadastrarEmpresa.php" class="btn btn-sm btn-success">
                    <i class="nav-icon fas fa-briefcase"></i>&nbsp;
                    Cadastrar
                  </a>
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#companiesModal">
                    <i class="fas fa-search"></i>&nbsp;
                    Pesquisar
                  </button>
              </div>             
            <p class="card-title">Lista de empresas</p>
          </div>
          <!-- /.card-header -->
          <?php 
            require_once("../admin/DB.php");
            $sql = 'SELECT * FROM empresa ORDER BY emp_razao_social';
            $query = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($query);
          ?>
          <div class="card-body table-responsive">
            <table id="tabela-empresas" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>CNPJ</th>
                  <th>Nome Fantasia</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php while($row != null):?>
                <tr>
                  <?php 
                    if(empty($row['emp_nome_fantasia']))
                      $nome = strlen($row['emp_razao_social']) >= 35 ? substr($row['emp_razao_social'], 0, 35)."..." : $row['emp_razao_social'];
                    else
                      $nome = $row['emp_nome_fantasia'];
                  ?>
                  <td class=" text-nowrap"><?=$row['emp_cnpj']?></td>
                  <td class=" text-nowrap"><?=$nome?></td>
                  <td class=" text-nowrap">
                    <a href="visualizarEmpresa.php?cnpj=<?=$row['emp_cnpj']?>" class="btn btn-primary btn-sm center">
                      <i class="far fa-eye"></i>&nbsp;
                      Visualizar
                    </a>
                    <a href="consultarEmpresaEdit.php?cnpj=<?=$row['emp_cnpj']?>&alterar=true" class="btn btn-warning btn-sm center">
                      <i class="far fa-edit"></i>&nbsp;
                      Alterar
                    </a>
                    <a href="../admin/ExcluiEmpresa.php?cnpj=<?=$row['emp_cnpj']?>" class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir essa empresa?');">
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
        </div>
      </div>
    </section>
  </div>
  <script>
    $('#tabela-empresas').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false 
      });
  </script>
<?php
  include ('../includes/modal_empresas.php');
  include ('../includes/footer.php');
?>