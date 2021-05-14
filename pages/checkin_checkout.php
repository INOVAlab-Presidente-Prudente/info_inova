<?php
  include ('../includes/header.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Check-in / Check-out</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_page.php">Início</a></li>
              <li class="breadcrumb-item active">Checkin-Checkout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de usuários no Coworking</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped table-hover">
              <thead>                  
                <tr>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Horário de Entrada</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class=" text-nowrap">Ana Souza</td>
                  <td class=" text-nowrap">123.456.789-00</td>
                  <td class=" text-nowrap">14h35 - 21/04/2021</td>
                  <td class=" text-nowrap">
                    <button class="btn btn-danger btn-sm center">Fazer Checkout</button>
                  </td>
                </tr>
                <tr>
                  <td class=" text-nowrap">Jose Silva</td>
                  <td class=" text-nowrap">987.654.321-22</td>
                  <td class=" text-nowrap">16h08 - 21/04/2021</td>
                  <td class=" text-nowrap">
                    <button class="btn btn-danger btn-sm center">Fazer Checkout</button>
                  </td>
                </tr>
                <tr>
                  <td class=" text-nowrap">
                    <a href="visualizar_usuario.php">Alexander Pierce</a>
                  </td>
                  <td class=" text-nowrap">369.258.147-99</td>
                  <td class=" text-nowrap">8h015 - 21/04/2021</td>
                  <td class=" text-nowrap">
                    <button class="btn btn-danger btn-sm center">Fazer Checkout</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  include ('../includes/footer.php');
?>