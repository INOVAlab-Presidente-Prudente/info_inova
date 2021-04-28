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
                <img src="../images/avatar-df.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                <a class="d-block" href="/"><?= $_SESSION['nome']?></a>
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
                <li class="nav-item">
                    <a href="/pages/checkin.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Check-in/Check-out
                            
                        </p>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Relatórios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../layout/top-nav.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Agendamento de Salas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/relatorioUsuario.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilização - Coworking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/boxed.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilização - Empresas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/fixed-sidebar.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Eventos</p>
                            </a>
                        </li>
                    
                    </ul>
                </li>
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
                            <a href="cadastroUsers.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Usuários</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pages/consultaUsers.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Usuário</p>
                            </a>
                        </li>
                        <!-- 
                        <li class="nav-item">
                            <a href="/pages/listarUsuarios.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar todos Usuários</p>
                            </a>
                        </li> -->
                        
                    
                    </ul>
                </li>
                
                
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
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <p>
                        Gerenciar Empresa
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../pages/cadastraEmpresa.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Empresa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/consultaEmpresa.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Empresa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php 
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
                            <a href=".../pages/cadastraSala.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Adicionar Sala</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/consultaSala.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar Sala</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
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
                        <a href="../forms/general.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Coworking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../forms/advanced.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Eventos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../forms/editors.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Financeiro</p>
                        </a>
                    </li>
                    </ul>
                </li>
                <?php
                }
                ?>
        </aside>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>