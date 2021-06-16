<?php include('../includes/header.php')?>
<?php include("../includes/primeirologin.php")?>
<?php include('../includes/permissoes.php')?>
<body class="hold-transition sidebar-mini" onload="document.title='Relatório de utilização do Coworking'">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php")?>
    <div class="wrapper">
     <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2>Relatório - Coworking</h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                            <li class="breadcrumb-item active">Relatório - Coworking</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Pesquisar um intervalo de dias</h3>
                        </div>
                        <form id="quickForm" method="post">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">    
                                        <label>Data inicial:</label>
                                        <input class="form-control" type="date" id="dtInicio" name="dtInicio"/><br>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Data final:</label>
                                        <input class="form-control" type="date" id="dtFim" name="dtFim"/> <br>
                                    </div>                                        
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" name="consultar"><i class="fas fa-search"></i>&nbsp;&nbsp;Pesquisar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if(isset($_POST['consultar'])){
                if(isset($_POST['dtInicio']) && isset($_POST['dtFim'])){
                    require_once('../admin/DB.php');
                
                    // pega quantidade de check in e tempo medio
                    $sql = "SELECT r.cont, sec_to_time(r.res/r.cont) AS tempo_total FROM (
                    SELECT COUNT(che_id) AS cont, SUM(TIME_TO_SEC(TIMEDIFF(che_horario_saida, che_horario_entrada))) AS res
                                FROM check_in 
                                    WHERE che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' AND che_horario_saida <= '".$_POST['dtFim']." 23:59:59') r;";
                    $query = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_assoc($query);
                
                    
                    $tmpMedio = explode(".",$row['tempo_total'])[0];
                    $tmpMedioVet = explode(":", $tmpMedio);
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                        <div class="callout callout-info">
                        
                            <p class="col-md-12 lead">        
                            Período: <strong><?=date_format(date_create($_POST['dtInicio']),"d/m/Y")?></strong> a <strong><?=date_format(date_create($_POST['dtFim']),"d/m/Y")?></strong>
                            </p>
                            <p>
                            Tempo médio entre todos usuários: <strong><?=$tmpMedioVet[0]."h ".$tmpMedioVet[1]."m ".$tmpMedioVet[2]."s "?></strong>
                            </p>
                            <p>
                            Quantidade de check-ins: <strong><?=$row['cont']?></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-right">
                                    <button id="btn-gerarpdf" onclick="window.open('../admin/RelatorioCoworking.php?dtInicio=<?=$_POST['dtInicio']?>&dtFim=<?=$_POST['dtFim']?>', '_blank')" class="btn btn-sm btn-danger">
                                        <i class="far fa-file-pdf"></i>&nbsp;
                                        Exportar em PDF
                                    </button>
                                </div>    
                                <p class="card-title">Lista de usuários</p>
                            </div>
                            <div class="card-footer mid">
                                <div class="card-body">
                                    <table id="table-relatorio" class="table table-bordered table-striped table-hover">
                                        
                                        <?php
                                            $sql = "SELECT DISTINCT u.usu_id, u.usu_nome, u.usu_area_atuacao, u.usu_cpf FROM usuario u, check_in c 
                                                    WHERE c.usu_id = u.usu_id AND c.che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' 
                                                                AND c.che_horario_saida <= '".$_POST['dtFim']." 23:59:59' ORDER BY usu_area_atuacao";
                                            $query = mysqli_query($connect, $sql);
                                            $row = mysqli_fetch_assoc($query);
                                            ?>
                                        <thead>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Horas (Total)</th>
                                                <th>N° de Check-ins</th>
                                                <th>N° de Ocorrências</th>
                                                <th>Área Atuação</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                                while($row != null){
                                                    $sql2 = "SELECT COUNT(c.che_id) AS qtde, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(c.che_horario_saida, c.che_horario_entrada)))) AS tempo 
                                                                FROM check_in c WHERE c.usu_id = ".$row['usu_id']." AND c.che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' 
                                                                AND c.che_horario_saida <= '".$_POST['dtFim']." 23:59:59'";
                                                                $query2 = mysqli_query($connect, $sql2);
                                                                $row2 = mysqli_fetch_assoc($query2);

                                                                $sql3 = "SELECT COUNT(oc_id) AS qtdeOcorrencia
                                                                FROM ocorrencia WHERE usu_id = ".$row['usu_id']." AND oc_data >= '".$_POST['dtInicio']." 00:00:00' 
                                                                AND oc_data <= '".$_POST['dtFim']." 23:59:59'";
                                                                $query3 = mysqli_query($connect, $sql3);
                                                                $row3 = mysqli_fetch_assoc($query3);

                                                                //if ($row2['tempo']){ 
                                                                    ?>
                                                            <tr>
                                                                <td><a href="visualizarUsuario.php?cpf=<?=$row['usu_cpf']?>"><?=htmlspecialchars($row['usu_nome'])?></a></td>
                                                                <td><?=htmlspecialchars($row2['tempo'])?></td>
                                                                <td><?=htmlspecialchars($row2['qtde'])?></td>
                                                                <td><?=htmlspecialchars($row3['qtdeOcorrencia'])?></td>
                                                                <td><?=htmlspecialchars($row['usu_area_atuacao'])?></td>
                                                            </tr>
                                                    <?php //}
                                                    $row = mysqli_fetch_assoc($query);
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>            
                <?php }?>
                </div>
            </div>
        </section>
     </div>
    </div>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script src="../js/gerarPDF.js"></script>
    
    <script>
  
    $('#table-relatorio').DataTable({
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
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

<?php include('../includes/footer.php'); ?>