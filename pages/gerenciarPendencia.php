<?php 
    include("../includes/header.php");
    include("../includes/primeirologin.php");
    if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");
?>
<body class="hold-transition sidebar-mini" onload="document.title='Cadastrar Modalidade'">
    <?php include("../includes/sidebar.php") ?>
    <?php include("../includes/navbar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Gerenciar Pendências</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                                <li class="breadcrumb-item active">Gerenciar Pendências</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <form method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <label>Empresa</label>
                                                <select required name="empresa" class="form-control ">
                                                    <option>...</option>
                                                    <?php 
                                                        require_once("../admin/DB.php");
                                                        $sql = "SELECT * FROM empresa WHERE emp_pendencia != true";
                                                        $query = mysqli_query($connect, $sql);
                                                        $res = mysqli_fetch_array($query);

                                                        while ($res != null) {
                                                            $nome  = (empty($res['emp_nome_fantasia']))? $res['emp_razao_social'] : $res['emp_nome_fantasia'];
                                                            echo "<option value='".$res['emp_id']."'>". $nome ."</option>";
                                                            $res = mysqli_fetch_array($query);
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <button type="submit" class="btn btn-primary w-100" name="inserir">Inserir</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            <?php
                                if(isset($_POST['inserir'])){
                                    require_once('../admin/AlteraPendencia.php');
                                }
                            
                            ?>
                            <div class="card-header">
                                <h3 class="card-title"> Lista de Empresas com Pendência</h3>
                            </div>
                                <div class="card-body">
                                    <?php
                                        require_once('../admin/DB.php');
                                        $sql = "SELECT * FROM empresa e, modalidade m WHERE emp_pendencia = true AND e.mod_id = m.mod_id";
                                        $query = mysqli_query($connect, $sql);
                                        $row = mysqli_fetch_assoc($query);
                                    ?>
                                    <table id="lista-pendencia" class="table text-nowrap table-hover">
                                        <thead><tr>
                                            <th>Razão Social</th>
                                            <th>Modalidade</th>
                                            <th>Excluir Pendência</th>                                        
                                        </tr></thead>

                                        <tbody>
                                            <?php while($row != null){ ?>
                                                <tr>
                                                    <td><a href="consultarEmpresaEdit.php?cnpj=<?=$row['emp_cnpj']?>">
                                                        <?=$row['emp_razao_social']?>
                                                    </a></td>
                                                    <td><?=$row['mod_nome']?></td>
                                                    <td><button class='btn btn-danger center' name="excluir"><i class="fas fa-trash-alt"></i></button></td>                                            
                                                </tr>
                                            <?php $row = mysqli_fetch_assoc($query);
                                            }?>                                    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer mid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include("../includes/footer.php") ?>