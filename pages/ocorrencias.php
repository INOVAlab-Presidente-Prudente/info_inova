<?php include("../includes/header.php")?>
<?php include("../includes/primeirologin.php")?>
<?php include("../includes/permissoes.php")?>
<body class="hold-transition sidebar-mini" onload="document.title=' Ocorrências';">
    <?php include("../includes/navbar.php"); $output = ""; $typeAlert = ""; $icon = ""; $title = "";?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ocorrências</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">    <a href="adminPage.php">Home</a> </li>
                                <li class="breadcrumb-item">    <a href="consultarUsuario.php">Usuários</a> </li>
                                <li class="breadcrumb-item active">Ocorrências</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(isset($_GET['excluido'])){
                                $output = "Ocorrência excluída com sucesso.";
                                $icon = "fa-check";
                                $typeAlert = "success";
                                $title = "Sucesso!";
                                $alertSetted = true;

                            }
                            if(isset($_GET['erroExcluir'])){
                                $output = "Erro ao excluir ocorrência.";
                                $icon = "fa-exclamation-triangle";
                                $typeAlert = "warning";
                                $title = "Erro!";
                                $alertSetted = true;
                            }
                            if(isset($_GET['alterado'])){  
                                $output = "Ocorrência alterada com sucesso.";
                                $icon = "fa-check";
                                $typeAlert = "success";
                                $title = "Sucesso!";
                                $alertSetted = true;
                            }
                            if(isset($_GET['error'])){  
                                $output = "Erro ao alterar a ocorrência.";
                                $icon = "fa-exclamation-triangle";
                                $typeAlert = "warning";
                                $title = "Erro!";
                                $alertSetted = true;
                            }
                            if(isset($alertSetted))
                            {
                                $alertSetted = true;
                                echo "<div class='alert alert-".$typeAlert." alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h3><i class='icon fas ".$icon."'></i>".$title."</h3>
                                        <p>".$output."</p>
                                </div>";
                            }
                            if (isset($_GET['ocorrencia_cadastrada'])) {
                                echo "<div class='alert alert-success alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h5><i class='fas fa-check'></i>&nbspOcorrência Cadastrada!</h5>
                                        <p>A ocorrência foi cadastrada com sucesso!</p>
                                    </div>";
                            }
                        ?> 
                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Lista de ocorrências</p>
                                <div class="float-right">
                                    <a class="btn btn-sm btn-success" onclick="window.location.href = 'cadastrarOcorrencia.php?usu_id=<?=$_GET['usu_id']?>'">
                                    <i class="fas fa-portrait"></i>&nbsp;
                                        Nova Ocorrência
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php    
                                    require_once("../admin/DB.php");
                                    $sql = "SELECT usu_nome, usu_cpf FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
                                    $query = mysqli_query($connect, $sql);
                                    if($query){
                                        $row = mysqli_fetch_assoc($query);?>
                                        <div class="lead">
                                           Nome: <strong><?=htmlspecialchars($row['usu_nome'])?></strong>
                                           <br/>
                                           <small>CPF: <?=htmlspecialchars($row['usu_cpf'])?></small>
                                        </div>
                                        <?php 
                                            $sql = "SELECT * FROM ocorrencia WHERE usu_id = '".$_GET['usu_id']."' ORDER BY oc_data";
                                            $query = mysqli_query($connect, $sql);
                                            $res = mysqli_fetch_array($query);
                                            if($res == null){
                                                echo "</br>";
                                                echo "<div class='h5'>O usuário não possui ocorrência! </div>";
                                            }    
                                            while($res != null){
                                                $data = date_create($res['oc_data']);
                                                echo "<blockquote  class='quote-info'>";
                                                    echo "Data: <strong>".htmlspecialchars(date_format($data,"d/m/Y"))."</strong> - Horário: <strong>".htmlspecialchars(date_format($data, 'H:i\m\i\n'))."</strong>";
                                                    echo "<p>".htmlspecialchars($res['oc_descricao'])."</p>"; //Colocar modal de excluir
                                                    echo "<a class='btn btn-danger btn-sm center' type='link' name='excluir' onclick=\"excluir(".$res['oc_id'].",".$_GET['usu_id'].")\"><i class='fas fa-trash'></i>&nbsp;Excluir</a>";
                                                echo "</blockquote>";
                                                $res = mysqli_fetch_array($query);
                                            }
                                    }
                                    else
                                        $output = "Usuario não encontrado";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function excluir(oc_id, usu_id){
            if(confirm("Deseja mesmo excluir esta ocorrência?")) //substituir pela modal
                window.location.href="../admin/ExcluiOcorrencia.php?usu_id="+usu_id+"&oc_id="+oc_id;
        }
    </script>
<?php 
    include("../includes/footer.php");
?>