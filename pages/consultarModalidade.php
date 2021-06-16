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
        if (isset($_GET['modalidade_cadastrada'])) {
          echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='fas fa-check'></i>&nbspModalidade Cadastrada!</h5>
                  <p>A modalidade foi cadastrada com sucesso!</p>
            </div>";
        }
        if (isset($_GET['modalidade_excluida'])) {
            echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='fas fa-check'></i>&nbspModalidade Excluída!</h5>
                  <p>A Modalidade foi excluída com sucesso!</p>
            </div>";
          } 
          if (isset($_GET['exclusao_negada'])) {
            echo "<div class='alert alert-warning alert-dismissible'>
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
            <p class="card-title">Lista de Modalidades</p>
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <a href="cadastrarModalidade.php" class="btn btn-sm btn-success mr-2">
                  <i class="fas fa-handshake"></i>&nbsp;
                  Cadastrar
                </a>
                <input type="text" id="pesquisar" class="form-control" placeholder="Pesquisar">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
              </div>              
            </div>
          </div>
          <div class="card-body table-responsive">
            <table id="tabela-modalidades" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Código</th>
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
                  <td><?=htmlspecialchars($row['mod_codigo'])?></td>
                  <td class=" text-nowrap"><a href="visualizarModalidade.php?mod_id=<?=$row['mod_id']?>"><?= htmlspecialchars(ucwords($row['mod_nome']))?></a></td>
                  <td class=" text-nowrap"><?=htmlspecialchars(ucwords($row['mod_edital']))?></td>
                  <td class=" text-nowrap">
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
      oTable = $('#tabela-modalidades').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
  </script>
<?php
  include ('../includes/modal_modalidades.php');
  include ('../includes/footer.php');
?>