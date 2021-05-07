<?php include('../includes/header.php'); ?>
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
                            <li class="breadcrumb-item active">Relatório de Utilização Empresas</li>
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
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <label>Data inicial:</label>
                                            <input class="form-control" type="date" id="dtInicio" name="dtInicio"/><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Data final:</label>
                                            <input class="form-control" type="date" id="dtFim" name="dtFim"/> <br>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <button class="btn btn-primary w-100" name="consultar">Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <?php
                        if(isset($_POST['consultar'])){
                            if(isset($_POST['dtInicio']) && isset($_POST['dtFim'])){
                                ?>
                                <div id="info-1" class="card-header">
                                    <div class="row">
                                        <div class="col-11">
                                            <h3 class='card-title'>
                                                <?php 
                                                    $dif = date_diff(date_create($_POST['dtInicio']), date_create($_POST['dtFim']))->format('%d');
                                                    if($dif != 0)
                                                        echo "Relatório de Utilização Empresa referente as datas ".date_format(date_create($_POST['dtInicio']),"d/m/Y")." a ".date_format(date_create($_POST['dtFim']),"d/m/Y");
                                                    else
                                                        echo "Relatorio do dia ".date_format(date_create($_POST['dtInicio']),"d/m/Y");
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="col-1"> <button id="btn-gerarpdf" onclick="getPDF('relatorio_<?=$_POST['dtInicio']?>_<?=$_POST['dtFim']?>')" class="btn btn-info">PDF</button></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                        <?php 
                                            if($dif != 0)
                                                echo "Periodo escolhido de ".($dif + 1)." dias";
                                        
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nome da empresa | Qtde presenca | Aluguel atrasado???? | Numero de funcionarios que compareceram nesses dias | Numero de funcionarios que a empresa possui |Tempo restante do contrato -->
                                <!-- Relatório de Utilização de Empresas Residentes. 
                                    O sistema deve permitir a geração de relatórios de frequência das empresas residentes.
                                    Para a criação do relatório deve ser informado o período (em dias) desejado. 
                                    No relatório devem constar informações que permitam gerar conhecimento de informações sobre utilização dos espaços (se o aluguel está em dia, se a empresa está frequentando corretamente o espaço, quantidade de funcionários que utilizam o espaço da empresa, se o contrato está para vencer, entre outros).
 -->                            
                                
                                <table id="table-relatorio" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Nº de dias que a empresa compareceu</th>
                                            <th>Nº de funcionarios que compareceram</th>
                                            <th>Quantidade de funcionarios total</th>
                                            <th>Aluguel Atrasado</th>
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
                                                    <td><?=$empresas['emp_razao_social']?></td>
                                                    <td><?=$presenca?></td>
                                                    <td><?=$row3['qtde']?></td>
                                                    <td><?=$row['qtde']?></td>
                                                    <td>?</td>
                                                    <td>?</td>
                                                </tr>
                                            <?php
                                                $empresas = mysqli_fetch_assoc($query);
                                            }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            <?php }
                            else{

                            }
                        }?>
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

<?php include('../includes/footer.php'); ?>