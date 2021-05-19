<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
 
    <ul class="navbar-nav ml-auto my-auto"> 
        <li class="nav-item dropdown mr-3 mb-2">
            <a class="nav-link" data-toggle="dropdown" href="#">
               <?php
                    if(in_array(hash("md5", $_SESSION['cpf']).".png", scandir("../images/usuarios")))
                        echo '<img src="../images/usuarios/'.hash("md5", $_SESSION['cpf']).'.png" class="img-circle img-fluid elevation-2 mb-1" style="width: 35px; height: 35px;" alt="User Image">';
                    else
                        echo '<img src="../images/avatar-df.png" class="img-circle img-fluid elevation-2 mb-1" style="width: 35px; height: 35px;" alt="User Image">';
                ?>
                &nbsp;&nbsp;
                <?=$_SESSION['nome']?>
                &nbsp;&nbsp;
                <i class="fas fa-chevron-circle-down"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><u>Perfil:&nbsp;<?= $_SESSION['perfil_usuario']?></u></span>
            <div class="dropdown-divider"></div>
                <a href="../pages/consultarUsuarioEdit.php?cpf=<?=$_SESSION['cpf']?>&alterar=true" class="dropdown-item"><i class="fas fa-user mr-2"></i>Alterar Dados Pessoais</a><div class="dropdown-divider"></div>
                <a href="../pages/alterarSenha.php" class="dropdown-item"><i class="fas fa-unlock-alt mr-2"></i>Alterar Senha</a><div class="dropdown-divider"></div>
                <a href="../admin/Logout.php" class="dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i> Sair do sistema</a></div>
            </div>
        </li>

        </li>
    </ul>
</nav>