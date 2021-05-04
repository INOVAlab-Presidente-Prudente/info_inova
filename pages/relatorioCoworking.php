<?php include('../includes/header.php'); ?>



<body class="hold-transition sidebar-mini" onload="document.title='Relatório de Utilização pelos Usuários do Coworking'">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php")?>
    <div class="wrapper">
     <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Relatório de Utilização do Coworking</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                            <li class="breadcrumb-item active">Relatório de Utilização do Coworking</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
            
                <div class="col-md-12">
                    <div class="card card-primary">
                        
                        <form id="quickForm" method="post">
                            <!-- <div class="card-header">
                                <?php 
                                    //mostrar o retorno caso ocorra um erro
                                ?>
                            </div> -->
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-8">
                                            <label>Data inicial:</label>
                                            <input class="form-control" type="date" id="dtInicio" name="dtInicio"/><br>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-8">
                                            <label>Data final:</label>
                                            <input class="form-control" type="date" id="dtFim" name="dtFim"/> <br>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer mid">
                                <div class="row">
                                    <div class="col"></div>
                                        <div class="col-5">
                                            <button class="btn btn-primary w-100" name="consultar">Consultar</button>
                                        </div>
                                    <div class="col"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div  id="relatorio">
                            <?php
                            if(isset($_POST['consultar'])){
                                if(isset($_POST['dtInicio']) && isset($_POST['dtFim'])){
                                    require_once('../admin/DB.php');?>
                                    <div class="card-header">
                                        <h3 class="card-title">Relatório de Utilização pelos Usuários do Coworking </h3><br>
                                        <h5 class="card-title">referente as datas <?=date_format(date_create($_POST['dtInicio']),"d/m/Y")?> a <?=date_format(date_create($_POST['dtFim']),"d/m/Y")?> </h5>
                                        <button id="btn-gerarpdf" class="btn btn-info">PDF</button>
                                    </div>
                                    <div class="card-footer mid">
                                        <div class="card-body">
                                            <?php
                                                // pega quantidade de check in e tempo medio
                                                $sql = "SELECT r.cont, sec_to_time(r.res/r.cont) AS tempo_total FROM (
                                                SELECT COUNT(che_id) AS cont, SUM(TIME_TO_SEC(TIMEDIFF(che_horario_saida, che_horario_entrada))) AS res
                                                            FROM check_in 
                                                                WHERE che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' AND che_horario_saida <= '".$_POST['dtFim']." 23:59:59') r;";
                                                $query = mysqli_query($connect, $sql);
                                                $row = mysqli_fetch_assoc($query);
                                            ?>
                                            <div class="form-group">
                                                <label><p>Tempo médio entre todos usuários: <?=$row['tempo_total']?></p></label><br>
                                                <label><p>Quantidade de check-in: <?=$row['cont']?></p></label>
                                            </div>
                        </div>
                                            <table id="table-relatorio" class="table table-bordered table-hover">
                                                
                                                <?php
                                                    $sql = "SELECT usu_id, usu_nome, usu_area_atuacao FROM usuario ORDER BY usu_area_atuacao";
                                                    $query = mysqli_query($connect, $sql);
                                                    $row = mysqli_fetch_assoc($query);
                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Qtd Horas</th>
                                                        <th>Qtde check-in</th>
                                                        <th>Qtde Ocorrencias</th>
                                                        <th>Area atuacao</th>
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

                                                            if ($row2['tempo']){?>
                                                                    <tr>
                                                                        <td><?=$row['usu_nome']?></td>
                                                                        <td><?=$row2['tempo']?></td>
                                                                        <td><?=$row2['qtde']?></td>
                                                                        <td><?=$row3['qtdeOcorrencia']?></td>
                                                                        <td><?=$row['usu_area_atuacao']?></td>
                                                                    </tr>
                                                            <?php }
                                                            $row = mysqli_fetch_assoc($query);
                                                        }
                                                    ?>
                                                </tbody>
                                                
                                                <!-- <tfoot>
                                                
                                                </tfoot> -->
                                            </table>
                                        </div>
                                    </div>
                                <?php }?>            
                            <?php }?>
                    </div>
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
  $(function () {
    // $("#table-relatorio").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false, "searching":false,
    //   "buttons": [{
    //             extend: 'pdfHtml5',
    //             download: 'open'
    //         }]
    // }).buttons().container().appendTo('#table-relatorio_wrapper .col-md-6:eq(0)');
    $('#table-relatorio2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<?php include('../includes/footer.php'); ?>