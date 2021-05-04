<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Ocorrências'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ocorrências</h1>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title"><strong> </strong></h2>
                                </div>
                                <div class="card-body">
                                    <button type='button' class='btn btn-info w-100 mb-4' onclick="window.location.href = 'cadastrarOcorrencia.php?usu_id=<?=$_GET['usu_id']?>'">Nova ocorrência</button>
                                    
                                    <div class="container">
                                        <?php
                                            if(isset($_GET['excluido']))
                                                echo "excluido"; //ALERT EXCLUIDO
                                            if(isset($_GET['erroExcluir']))
                                                echo "erro ao excluir"; //ALERT
                                            require_once("../admin/DB.php");
                                            $sql = "SELECT usu_nome FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
                                            $query = mysqli_query($connect, $sql);
                                            if($query){
                                                $row = mysqli_fetch_assoc($query);
                                                echo "<h4 class='mb-4'>Todas Ocorrências de <strong>".$row['usu_nome']."</strong></h4>";
                                                
                                                $sql = "SELECT * FROM ocorrencia WHERE usu_id = '".$_GET['usu_id']."'";
                                                $query = mysqli_query($connect, $sql);
                                                $res = mysqli_fetch_array($query);
                                                if($res == null)
                                                    echo " O usuário não possui ocorrência!";//".$row['usu_nome']."
                                                $cont = 0;
                                                echo "<div class='row'>";
                                                while($res != null){
                                                    if($cont < 4){
                                                        echo "<div class='col-md-3 ml-1 mb-2'>";
                                                            echo "<div class='card card-outline card-info' style='width:14rem;'>";
                                                            echo "<div class='card-body'>";
                                                                echo "<div class='card-title'>Data:".$res['oc_data']."</div><br><div class='card-subtitle mb-2 text-muted'><strong>Ocorrência: </strong>".$res['oc_descricao']."</div>";
                                                                    echo "<div class='card-tools'";
                                                                        echo "<a style='cursor: pointer;' type='link' name='alterar' onclick=\"window.location.href='alterarOcorrencia.php?oc_id=".$res['oc_id']."'\"><i class='fas fa-edit mr-4'></i></a>";
                                                                        echo "<a style='cursor: pointer;' type='link' name='excluir' onclick=\"excluir(".$res['oc_id'].",".$_GET['usu_id'].")\"><i class='fas fa-trash'></i></a>";
                                                                    echo "</div>";
                                                                echo "</div>";
                                                            echo "</div>";
                                                        echo "</div>";
                                                        if($cont == 3)
                                                            echo "</div>";
                                                        $cont++;
                                                    }
                                                    else{
                                                        $cont = 0;
                                                        echo "<div class='row'>";
                                                    }
                                                    
                                                    
                                                    
                                                    $res = mysqli_fetch_array($query);
                                                    if($res == null)
                                                        echo "</div>";
                                                }
                                            }else echo "Usuario não encontrado";
                                        ?>
                                    </div>
                                </div>
                                <!-- <div class="card-footer">
                                
                                </div> -->
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