<?php
  $titulo = "Consultar Eventos";
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
            <h1>Eventos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item active">Eventos</li>
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
          if (isset($_GET['evento_cadastrada'])) {
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEvento Cadastrado!</h5>
                        <p>O evento foi cadastrado com sucesso!</p>
                  </div>";
          }
          if (isset($_GET['evento_excluida'])) {
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEvento excluído!</h5>
                        <p>O evento foi excluído com sucesso!</p>
                  </div>";  
          }
          if (isset($_GET['evento_nao_existe'])) {
            echo "<div class='alert alert-warning alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='icon fas fa-exclamation-triangle'></i> Evento não encontrada!</h5>
                        <p>Evento não encontrado no sistema!</p>
                  </div>";
          }
        ?>
        <div class="card">
        <div class="card-header">             
            <p class="card-title">Lista de Eventos</p>
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <a href="cadastrarEvento.php" class="btn btn-sm btn-success mr-2">
                  <i class="fas fa-briefcase"></i>&nbsp;
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
          <?php 
            require_once("../admin/DB.php");
            $sql = 'SELECT * FROM evento e LEFT JOIN tipo_evento t ON e.tip_id = t.tip_id ORDER BY e.tip_id';
            $query = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($query);
          ?>
          <div class="card-body table-responsive">
            <table id="tabela-empresas" class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Evento</th>
                  <th>Categoria</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php while($row != null):?>
                <tr>
                    <td class=" text-nowrap"><a href="#">
                        <?=htmlspecialchars($row['eve_nome'])?>
                    </a></td>
                    <td class=" text-nowrap">
                        <?=htmlspecialchars($row['tip_descricao'])?>
                    </td>
                    <td class=" text-nowrap">
                    <a href="#" class="btn btn-warning btn-sm center">
                      <i class="far fa-edit"></i>&nbsp;
                      Alterar
                    </a>
                    <a href="#" class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir esse evento?');">
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
        },
        
        "order": []
      });
      oTable = $('#tabela-empresas').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
  </script>
<?php
  include ('../includes/modal_empresas.php');
  include ('../includes/footer.php');
?>