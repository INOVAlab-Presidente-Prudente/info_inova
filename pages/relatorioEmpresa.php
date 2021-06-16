<?php include('../includes/header.php');?>
<?php include("../includes/primeirologin.php");?>
<body class="hold-transition sidebar-mini" onload="document.title='Relatório de Utilização Empresas'">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php")?>
    <div class="wrapper">
     <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Relatório de Utilização Empresas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                            <li class="breadcrumb-item active">Relatório - Empresas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title text-center">Pesquisar um intervalo de dias</h3>
                        </div>
                        <form id="quickForm" method="post">
                            <div class="card-body h-5">
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                        <div class="callout callout-info">
                            <p class="col-md-12 lead">        
                                Período: <?php 
                                    $dif = date_diff(date_create($_POST['dtInicio']), date_create($_POST['dtFim']))->format('%d');
                                    if($dif != 0)
                                        echo "<strong>".date_format(date_create($_POST['dtInicio']),"d/m/Y")."</strong> a <strong>".date_format(date_create($_POST['dtFim']),"d/m/Y")."</strong>";
                                    else
                                        echo "Relatorio do dia <strong>".date_format(date_create($_POST['dtInicio']),"d/m/Y")."</strong>";
                                ?>
                            </p>
                        </div><!--  -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <?php
                            if(isset($_POST['consultar'])){
                                if(isset($_POST['dtInicio']) && isset($_POST['dtFim'])){
                                    ?>
                                    <div class="card-header">
                                        <div class="float-right">  
                                            <button id="btn-gerarpdf" onclick="window.open('../admin/RelatorioEmpresa.php?dtInicio=<?=$_POST['dtInicio']?>&dtFim=<?=$_POST['dtFim']?>', '_blank')" class="btn btn-sm btn-danger">
                                                <i class="far fa-file-pdf"></i>&nbsp;
                                                Exportar em PDF
                                            </button>
                                        </div>
                                        <p class='card-title'>Lista de empresas</p>
                                    </div>
                                    <div class="card-footer mid">
                                        <div class="card-body">
                                            <table id="table-relatorio" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Nº de dias que a empresa compareceu</th>
                                                        <th>Nº de funcionarios que compareceram</th>
                                                        <th>Quantidade de funcionarios total</th>
                                                        <th>Tempo restante de contrato</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        require_once('../admin/DB.php');
                                                        $sql = "SELECT * FROM empresa";
                                                        $query = mysqli_query($connect, $sql);
                                                        $empresas = mysqli_fetch_assoc($query);

                                                        

                                                        while($empresas!=null){
                                                        
                                                            $sql2 = "SELECT COUNT(usu_id) AS qtde FROM usuario WHERE emp_id = ".$empresas['emp_id'];
                                                            $query2 = mysqli_query($connect, $sql2);
                                                            $row = mysqli_fetch_assoc($query2);  

                                                            $sql3 = "SELECT COUNT(r.teste) AS qtde FROM (SELECT DISTINCT u.usu_id as teste FROM check_in c, usuario u 
                                                            WHERE u.emp_id = ".$empresas['emp_id']." AND c.usu_id = u.usu_id AND c.che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' AND c.che_horario_saida <= '".$_POST['dtFim']." 23:59:59' ) r;";
                                                            $query3 = mysqli_query($connect, $sql3);
                                                            $row3 = mysqli_fetch_assoc($query3);  
                                                            
                                                            $presenca = 0;
                                                            if($row3 != null && $row3['qtde'] > 0 ){
                                                                $date = date_create($_POST['dtInicio']);
                                                                $dateStr = $_POST['dtInicio'];
                                                                while($dateStr <= $_POST['dtFim']){
                                                                    $sql = "SELECT u.usu_id FROM check_in c, usuario u WHERE DATE(c.che_horario_entrada) = '".$dateStr."' AND c.usu_id = u.usu_id AND u.emp_id = ".$empresas['emp_id']." LIMIT 1";
                                                                    $query4 = mysqli_query($connect,$sql);
                                                                    if($query4){
                                                                        $row4 = mysqli_fetch_assoc($query4);
                                                                        if($row4)
                                                                            $presenca++;
                                                                    }
                                                                        
                                                                    $date->add(new DateInterval('P1D'));
                                                                    $dateStr = date_format($date, 'Y-m-d');
                                                                }
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td><?=empty($empresas['emp_nome_fantasia'])? htmlspecialchars($empresas['emp_razao_social']) : htmlspecialchars($empresas['emp_nome_fantasia'])?></td>
                                                                <td><?=htmlspecialchars($presenca)?></td>
                                                                <td><?=htmlspecialchars($row3['qtde'])?></td>
                                                                <td><?=htmlspecialchars($row['qtde'])?></td>
                                                                <td>?</td>
                                                            </tr>
                                                        <?php
                                                            $empresas = mysqli_fetch_assoc($query);
                                                        }
                                                    
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            <?php }
                            else{

                            }
                        }?>
                        </div>
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