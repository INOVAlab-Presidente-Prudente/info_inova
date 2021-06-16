<?php
  $titulo = "Consultar Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/permissoes.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Salas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
                <li class="breadcrumb-item active">Salas</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <?php 
          if (isset($_GET['sala_cadastrada'])){
            echo "<div class='col alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspSala Cadastrada!</h5>
                        <p>A sala foi cadastrado com sucesso!</p>
                  </div>";
          }
        ?>
        <div class="col-md-12">
            <?php /* Colocar os alerts dps */ ?>
            <div class="card">
                <div class="card-header">             
                    <p class="card-title">Lista de Salas</p>
                    <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <a href="cadastrarSala.php" class="btn btn-sm btn-success mr-2">
                        <i class="fab fa-houzz"></i>&nbsp;
                        Cadastrar
                        </a>
                        <input type="text" id="pesquisar" class="form-control" placeholder="Pesquisar">
                        <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>              
                    </div>
                </div>
                <?php 
                    require_once("../admin/DB.php");
                    $sql = 'SELECT * FROM sala ORDER BY sa_nome_espaco';
                    $query = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_assoc($query);
                ?>
                <div class="card-body table-responsive">
                    <table id="tabela-salas" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Capacidade</th>
                                <th>Valor Periodo</th>
                                <th>Valor Hora</th>
                                <th>Localização</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row != null):?>
                            <tr>
                                <td class="text-nowrap">
                                    <a href="visualizarSala.php?sala_id=<?=$row['sa_id']?>"><?=$row['sa_nome_espaco']?></a>
                                </td>
                                <td class="text-nowrap"><?=$row['sa_capacidade']?></td>
                                <td class="text-nowrap">R$<?=$row['sa_valor_periodo']?></td>
                                <td class="text-nowrap">R$<?=$row['sa_valor_hora']?></td>
                                <td class="text-nowrap"><?=$row['sa_localizacao']?></td>
                                <td class="text-nowrap">
                                    <a <?=$dis?> class="btn btn-info btn-sm center" name="reservarSala" href="reservarSala.php?sa_id=<?=$row['sa_id']?>">
                                        <i class="far fa-calendar-check"></i>&nbsp;
                                        Reservar Sala
                                    </a>
                                    <a class="btn btn-warning btn-sm center" href="consultarSalaEdit.php?sala_id=<?=$row['sa_id']?>&alterar=true">
                                        <i class="far fa-edit"></i>&nbsp;
                                        Alterar
                                    </a>
                                    <a class="btn btn-danger btn-sm center" onclick="return confirm('Você realmente quer excluir essa sala?');" href="../admin/ExcluiSala.php?sala_id=<?=$row['sa_id']?>">
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
    $('#tabela-salas').DataTable({
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
      oTable = $('#tabela-salas').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#pesquisar').keyup(function(){
          oTable.search($(this).val()).draw() ;
        })
</script>
<?php
    include ('../includes/modal_sala.php');
    include ('../includes/footer.php');
?>  