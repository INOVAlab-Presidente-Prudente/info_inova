 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../pages/adminPage.php" class="brand-link">
            <img src="../images/logo_page.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">InfoInova</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <?php
                    if(in_array(hash("md5", $_SESSION['cpf']).".png", scandir("../images/usuarios")))
                        echo '<img src="../images/usuarios/'.hash("md5", $_SESSION['cpf']).'.png" class="img-circle elevation-2" style="width: 35px; height: 35px" alt="User Image">';
                    else
                        echo '<img src="../images/avatar-df.png" class="img-circle elevation-2" style="width: 35px; height: 35px;" alt="User Image">';
                ?>
                </div>  
                <div class="info">
                    <a class="d-block" href="../pages/consultarUsuarioEdit.php?cpf=<?=$_SESSION['cpf']?>&alterar=true"><?= $_SESSION['nome']?></a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2" onChange="activeElemts()">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <?php if((isset($_SESSION['admin']) || isset($_SESSION['coworking']))):?>
                <li class="nav-item">
                    <a href="/pages/checkin.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Check-in/Check-out
                            
                        </p>
                        
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Relatórios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                <?php if(isset($_SESSION['admin']) || isset($_SESSION['coworking'])):?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Agendamento de Salas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/relatorioCoworking.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilização - Coworking</p>
                            </a>
                        </li>
                <?php endif?>
                <?php if(isset($_SESSION['admin']) || isset($_SESSION['coworking']) ||isset($_SESSION['financeiro'])):?>
                        <li class="nav-item">
                            <a href="../pages/relatorioEmpresa.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilização - Empresas</p>
                            </a>
                        </li>
                <?php endif?>
                <?php if(isset($_SESSION['admin']) || isset($_SESSION['coworking'])):?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Eventos</p>
                            </a>
                        </li>    
                <?php endif?>
                    </ul>
                </li>
                <?php if((isset($_SESSION['admin']) || isset($_SESSION['coworking']))):?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Gerenciar Usuários
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/pages/cadastrarUsuario.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Usuário</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pages/consultarUsuario.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Usuário</p>
                            </a>
                        </li>
                        <!-- 
                        <li class="nav-item">
                            <a href="/pages/listarUsuario.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar todos Usuários</p>
                            </a>
                        </li> -->
                        
                    
                    </ul>
                </li>
                <?php endif?>
                
                
                <!--
                    Verificar dps para caso for utilizar
                    <li class="nav-item">
                    <a href="../widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Função 2
                        <span class="right badge badge-danger">New</span>
                    </p>
                    </a>
                </li>-->
                <?php if(isset($_SESSION['admin']) || isset($_SESSION['coworking']) || isset($_SESSION['financeiro'])):?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <p>
                        Gerenciar Empresas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <?php if(isset($_SESSION['admin']) || isset($_SESSION['coworking'])):?>
                        <li class="nav-item">
                            <a href="../pages/cadastrarEmpresa.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Empresa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/consultarEmpresa.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Empresa</p>
                            </a>
                        </li>
                        <?php endif?>
                        <?php if (isset($_SESSION['admin']) || isset($_SESSION['financeiro'])): ?>
                        <li class="nav-item">
                            <a href="../pages/gerenciarPendencia.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Gerenciar Pendência</p>
                            </a>
                        </li>
                        <?php endif?>
                    </ul>
                </li>
                <?php endif?>
                <?php if(isset($_SESSION['admin']) || isset($_SESSION['financeiro'])) { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-handshake"></i> 
                    <p>
                        Gerenciar Modalidades
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../pages/cadastrarModalidade.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Modalidade</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/consultarModalidade.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Modalidade</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php 
                }
                if(isset($_SESSION['admin'])){
                ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    
                    <p>
                        Gerenciar Salas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Adicionar Sala - Em Breve</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Sala - Em Breve</p>
                            </a>
                        </li>
                    </ul>
                </li>
<!--                 
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-dice-d6"></i>
                    <p>
                        Outras funcionalidades
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Coworking - Em Breve</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Eventos - Em Breve</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Financeiro - Em Breve</p>
                        </a>
                    </li>
                    </ul>
                </li> -->
                <?php
                }
                ?>
        </aside>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>