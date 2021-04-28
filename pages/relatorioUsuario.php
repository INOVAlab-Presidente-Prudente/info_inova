<?php include('../includes/header.php'); ?>



<body class="hold-transition sidebar-mini">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <!-- <div class="card-header">
                            <?php 
                                //mostrar o retorno caso ocorra um erro
                            ?>
                        </div> -->
                        <div class="card-body">
                            <div class="form-group">
                                <form id="quickForm" method="post">
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
                                    
                                    <div class="row ">
                                        <div class="col"></div>

                                        <div class="col-5">
                                            <button class="btn btn-primary w-100" name="consultar">Consultar</button>
                                        </div>

                                        <div class="col"></div>
                                    </div>
                                    
                                </form>
                                <?php 
                                    if(isset($_POST['consultar'])){
                                        if(isset($_POST['dtInicio']) && isset($_POST['dtFim'])){
                                            require_once('../admin/DB.php');
                                            echo "<br><br><h5>Relatório de Utilização pelos Usuários do Coworking referente as datas ".$_POST['dtInicio']." a ".$_POST['dtFim']."</h5>";
                                            // pega quantidade de check in e tempo medio
                                            $sql = "SELECT r.cont, sec_to_time(r.res/r.cont) AS tempo_total FROM (
                                            SELECT COUNT(che_id) AS cont, SUM(TIME_TO_SEC(TIMEDIFF(che_horario_saida, che_horario_entrada))) AS res
                                                        FROM check_in 
                                                            WHERE che_horario_entrada >= '".$_POST['dtInicio']." 00:00:00' AND che_horario_saida <= '".$_POST['dtFim']." 23:59:59') r;";
                                            $query = mysqli_query($connect, $sql);
                                            $row = mysqli_fetch_assoc($query);
                                            echo "<br>Tempo médio entre todos usuários: ".$row['tempo_total'];
                                            echo "<br> Quantidade de check-in: ".$row['cont']."";
                                            ?>
                                            <!-- html entre as pesquisas -->
                                            <?php
                                            $sql = "SELECT usu_id, usu_nome, usu_area_atuacao FROM usuario ORDER BY usu_area_atuacao";
                                            $query = mysqli_query($connect, $sql);
                                            $row = mysqli_fetch_assoc($query);
                                            ?>
                                            <table border='1px solid black'>
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Qtd Horas</th>
                                                    <th>Qtde check-in</th>
                                                    <th>Area atuacao</th>
                                                </tr>
                                            <?php
                                            while($row != null){
                                                $sql2 = "SELECT COUNT(c.che_id) AS qtde, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(c.che_horario_saida, c.che_horario_entrada)))) AS tempo FROM check_in c WHERE c.usu_id = ".$row['usu_id']." AND c.che_horario_entrada >= '2021-04-01 00:00:00' AND c.che_horario_saida <= '2021-04-30 23:59:59'";
                                                $query2 = mysqli_query($connect, $sql2);
                                                $row2 = mysqli_fetch_assoc($query2);
                                                if ($row2['tempo']){?>
                                                        <tr>
                                                            <td><?=$row['usu_nome']?></td>
                                                            <td><?=$row2['tempo']?></td>
                                                            <td><?=$row2['qtde']?></td>
                                                            <td><?=$row['usu_area_atuacao']?></td>
                                                        </tr>
                                                <?php $i++;}
                                                $row = mysqli_fetch_assoc($query);
                                            }
                                        }
                                    }
                                ?>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
      </section>
     </div>
    </div>
    
    <!--  [x] quantidade de usuarios
          [x] deve ser informado o período (em dias) desejado. 
          [ ]quantidade de horas que cada usuário permaneceu no espaço,
          [ ]deve ser adicionado botão na consulta do usuario.
          
          [x]tempo médio de utilização do espaço
          [ ]área de conhecimento dos frequentadores
          [ ]entre outros
          de forma que os dados sejam anonimizados, de acordo com a LGPD. -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    
<?php include('../includes/footer.php'); ?>