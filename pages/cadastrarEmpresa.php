<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Cadastrar Empresa'">
    <?php include("../includes/navbar.php")?>
    <?php include("../includes/sidebar.php")?>
      <div class="wrapper">
      <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Cadastro de Empresas</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                    <li class="breadcrumb-item active">Cadastro de Empresas</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- jquery validation -->
                  <div class="card card-primary">
                    
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm" method="post">
                    <div class="card-header">
                      <?php 
                        if (isset($_POST['cadastrar'])) {
                            require_once("../admin/CadastroEmpresa.php");
                        } 
                      ?>
                    </div>
                      <div class="card-body">
                          <div class="form-group">
                              <label>CNPJ</label>
                              <input required pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}" minlength="18" maxlength="18" onpaste="consultaCNPJ(this.value)" oninput="consultaCNPJ(this.value)" type="text" id="cnpj" name="cnpj" class="form-control" placeholder="xx.xxx.xxx/0001-xx">
                          </div>
                          <div class="form-group">
                              <label>Razão Social</label>
                              <input required type="text" name="razaoSocial" id="razaoSocial" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Telefone</label>
                              <input required pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" type="phone" name="telefone" id="telefone" class="form-control" placeholder="(xx)xxxxx-xxxx">
                          </div>
                          <div class="form-group">
                              <label>Ramo de atuação</label>
                              <input required type="text" name="areaAtuacao" id="ramo" class="form-control" >
                          </div>
                          <div class="form-group">
                              <label>Modalidade</label>
                              <select required name="modalidade" class="form-control">
                              <?php
                                require_once("../admin/DB.php");
                                  $sql = "SELECT * FROM modalidade";
                                  $query = mysqli_query($connect, $sql);
                                  $res = mysqli_fetch_array($query);    

                                  while ($res != null) {
                                      if (isset($_SESSION['admin']) || isset($_SESSION['coworking']) || isset($_SESSION['financeiro']))
                                          echo "<option value='".$res['mod_id']."'>". ucwords($res['mod_nome']) ."</option>";
                                      $res = mysqli_fetch_array($query);
                                  }
                                ?>
                              </select>
                          </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.card -->
                  </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>
      </div>
      <script>
        function consultaCNPJ(CNPJ){
          CNPJ = CNPJ.replace(/[./-]/g, "")
          if(CNPJ.length==14){
            var script = document.createElement('script');
            script.src = "https://www.receitaws.com.br/v1/cnpj/"+CNPJ+"?callback=meuCallback";
            document.body.appendChild(script);

          }
        }
        function meuCallback(conteudo){
          document.getElementById('razaoSocial').value=(conteudo.nome);
          if (conteudo.telefone.length > 14)
              conteudo.telefone = conteudo.telefone.split("/")[0]
          document.getElementById('telefone').value=(conteudo.telefone.replace(" ", ""));
          document.getElementById('ramo').value= (conteudo.atividade_principal[0].text);
        }
      </script>
<?php include("../includes/footer.php")?>