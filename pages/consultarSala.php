
<?php
  $titulo = "Consultar Sala";
  include ('../includes/header.php');
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
        <div class="col-md-12">
            <?php /* Colocar os alerts dps */ ?>
            <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <a href="cadastrarSala.php" class="btn btn-sm btn-success">
                            <i class="nav-icon fas fa-briefcase"></i>&nbsp;
                            Cadastrar
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#companiesModal">
                            <i class="fas fa-search"></i>&nbsp;
                            Pesquisar
                        </button>
                    </div>
                    <p class="card-title">Lista de Salas</p>
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
                                <td class="text-nowrap"><?=$row['sa_nome_espaco']?></td>
                                <td class="text-nowrap"><?=$row['sa_capacidade']?></td>
                                <td class="text-nowrap"><?=$row['sa_valor_periodo']?></td>
                                <td class="text-nowrap"><?=$row['sa_valor_hora']?></td>
                                <td class="text-nowrap"><?=$row['sa_localizacao']?></td>
                                <td class="text-nowrap">
                                    <a class="btn btn-primary btn-sm center" href="visualizarSala.php?id=<?= $row['sa_id'] ?>">
                                        <i class="far fa-eye"></i>&nbsp;
                                        Visualizar
                                    </a>
                                    <a class="btn btn-warning btn-sm center" href="consultarSalaEdit.php?id=<?= $row['sa_id'] ?>">
                                        <i class="far fa-edit"></i>&nbsp;
                                        Alterar
                                    </a>
                                    <a class="btn btn-danger btn-sm center" href="../admin/ExcluiSala.php?id=<?= $row['sa_id'] ?>">
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
</script>
<?php
    include ('../includes/footer.php');
?>  