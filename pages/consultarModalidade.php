<?php 
    include("../includes/header.php");
    include("../includes/primeirologin.php");
    if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");
?>
<body class="hold-transition sidebar-mini" onload="document.title='Consultar Modalidade'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
  <div class="wrapper"> 
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Consultar Modalidade</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                <li class="breadcrumb-item active">Consulta Modalidade</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['modalidade_excluida'])) {?>
              <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-check'></i>&nbspModalidade Excluída!</h5>
                    <p>A Modalidade foi excluída com sucesso!.</p>
              </div>
          <?php } 
           if (isset($_GET['exclusao_negada'])) {?>
              <div class='alert alert-warning' role='alert'>Empresas estão cadastradas nessa modalidade</div>
              <div class='alert alert-warning alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='icon fas fa-exclamation-triangle'></i>Exclusão Negada!</h5>
                    <p>Empresas estão cadastradas nesta modalidade, exclusão não permitida.</p>
              </div>
          
          <?php } ?>
          <div class="col-md-12">
            <div class="card">
                  <div class="card-header"><h3 class="card-title"> Lista de Modalidades</h3></div>
                  
                  <div class="card-footer mid">
                    <?php 
                      require_once("../admin/DB.php");
                      $sql = 'SELECT * FROM modalidade ORDER BY mod_nome';
                      $query = mysqli_query($connect, $sql);
                      $row = mysqli_fetch_assoc($query);
                    ?>
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                              <th>Modalidade</th>
                              <th>Edital</th>
                              <th>Alterar</th>
                              <th>Excluir</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while($row != null) { ?>
                            <tr>
                              <td><a href="consultarModalidadeEdit.php?mod_id=<?=$row['mod_id']?>"><?= ucwords($row['mod_nome'])?></a></td>
                              <td><?= ucwords($row['mod_edital'])?></td>
                              <!-- botoes -->
                              <td><button class="btn btn-warning center" name="alterar" onclick="redireciona('<?=$row['mod_id']?>')">
                                <i class="fas fa-edit"></i>
                              </button></td>
                              <td><button class="btn btn-danger center" name="excluir" onclick="excluirModalidade(this,'<?=$row['mod_id']?>', '<?=$row['mod_nome']?>')">
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
          <div class="container-fluid"> 
            <div class="row align-itens-center justify-content-center">
            <div class="text-center"> 
                <h4>Excluir Modalidade</h4> 
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
      </section>
    </div>
  </div>
      <script>
          const modal = document.getElementById("modal-excluir");
          const btnSim = document.getElementById("btn-sim");
          const btnNao = document.getElementById("btn-nao");

        function redireciona(id){
            window.location.href="consultarModalidadeEdit.php?mod_id="+id+"&alterar=enabled";
        }

        function excluirModalidade(e, id, modalidade){
          if (e.target == document.getElementById("btn-excluir")) {
                modal.style.display = "block";
                document.getElementById("mensagem").innerText = `Deseja excluir a modalidade ${modalidade}?`;
              }
              btnSim.onclick = () => {
                window.location.href="../admin/ExcluiModalidade.php?mod_id="+id;
              }
        }

        window.onclick = (e) => {
            if (e.target === modal || e.target === btnNao)
              modal.style.display = 'none';
        }
      </script>
    
<?php include('../includes/footer.php'); ?>
 