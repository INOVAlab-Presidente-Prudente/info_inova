<?php
  $titulo = "Consultar Modalidade";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
  
  if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");
?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modalidades</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item active">Modalidades</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">     
      <div class="col-md-12">
        <?php 
        if (isset($_GET['modalidade_excluida'])) {
            echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='fas fa-check'></i>&nbspModalidade Excluída!</h5>
                  <p>A Modalidade foi excluída com sucesso!</p>
            </div>";
          } 
          if (isset($_GET['exclusao_negada'])) {
            echo "<div class='alert alert-warning' role='alert'>Empresas estão cadastradas nessa modalidade</div>
            <div class='alert alert-warning alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='icon fas fa-exclamation-triangle'></i>Exclusão Negada!</h5>
                  <p>Empresas estão cadastradas nesta modalidade, exclusão não permitida.</p>
            </div>";
          } 
          if (isset($_GET['modalidade_nao_existe'])){
          echo "<div class='alert alert-warning alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h5><i class='fas fa-exclamation-triangle'></i>&nbspErro!</h5>
                  <p>Esta modalidade não existe.</p>
                </div>";
          }
        ?>
        <div class="card">
          <div class="card-header">
              <div class="float-right">
                  <a href="cadastrarModalidade.php" class="btn btn-sm btn-success">
                    <i class="nav-icon fas fa-handshake"></i>&nbsp;
                    Cadastrar
                  </a>
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalidadeModal">
                    <i class="fas fa-search"></i>&nbsp;
                    Pesquisar
                  </button>
              </div>             
            <p class="card-title">Lista de modalidades</p>
          </div>
          <div class="card-body table-responsive">
            <table id="tabela-modalidades" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Modalidade</th>
                  <th>Edital</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    require_once("../admin/DB.php");
                    $sql = 'SELECT * FROM modalidade ORDER BY mod_nome';
                    $query = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_assoc($query);
                    while($row != null):
                ?>
                <tr>
                  <td class=" text-nowrap"><a href="consultarModalidadeEdit.php?mod_id=<?=$row['mod_id']?>"><?= ucwords($row['mod_nome'])?></a></td>
                  <td class=" text-nowrap"><?= ucwords($row['mod_edital'])?></td>
                  <td class=" text-nowrap">
                    <a href="visualizarModalidade.php?mod_id=<?=$row['mod_id']?>" class="btn btn-primary btn-sm center">
                      <i class="far fa-eye"></i>&nbsp;
                      Visualizar
                    </a>
                    <a href="consultarModalidadeEdit.php?mod_id=<?=$row['mod_id']?>&alterar=true" name="alterar" class="btn btn-warning btn-sm center">
                      <i class="far fa-edit"></i>&nbsp;
                      Alterar
                    </a>
                    <a href="../admin/ExcluiModalidade.php?mod_id=<?=$row['mod_id']?>" class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir essa modalidade?');">
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
    </section>
  </div>
  <script>
    $('#tabela-modalidades').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false 
      });
  </script>
<?php
  include ('../includes/modal_modalidades.php');
  include ('../includes/footer.php');
?>