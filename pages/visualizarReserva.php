<?php
  $titulo = "Visualizar Reserva da Sala";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  if(isset($_GET['sala_id'])){
    require_once("../admin/DB.php");
    $sql = "SELECT * FROM sala WHERE sa_id = ".$_GET['sala_id']."";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    
    if($row == NULL)
      header("location: consultarSala.php");
  }else
    header("location: consultarSala.php");
?> 
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <?php 
            if (isset($_GET['sala_alterada'])){
              echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h5><i class='fas fa-check'></i>&nbspSala Alterada!</h5>
                  <p>Sala foi alterado com sucesso!</p>
              </div>";
            }
            if(isset($_GET['erro-alterar'])){
                echo "<div class='alert alert-info alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-info'></i>&nbspModalidade não alterada!</h5>
                        <p>Não foi possível alterar a modalidade, tente novamente!</p>
                      </div>";
            }
        ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Reserva da Sala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="checkin.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarSala.php">Salas</a></li>
              <li class="breadcrumb-item"><a href="visualizarSala.php?sala_id=<?=$_GET['sala_id']?>">Visualizar</a></li>
              <li class="breadcrumb-item">Reserva</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-12 mb-4">
                  <h2><?=htmlspecialchars(ucwords($row['sa_nome_espaco']))?></h2>
                  <a href="alterarReserva.php?sala_id=<?=$_GET['sala_id']?>&res_id=<?=$_GET['res_id']?>" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar dados da reserva
                  </a>
                </div>
              </div>
              <?php 
                $sql = "SELECT * FROM reserva_sala r 
                          LEFT JOIN evento e ON e.eve_id = r.eve_id 
                            LEFT JOIN usuario u ON u.usu_id = r.usu_id
                              LEFT JOIN empresa emp ON emp.emp_id = r.emp_id 
                                WHERE r.res_id = ".$_GET['res_id']."";

                $query = mysqli_query($connect, $sql);
                $dados = mysqli_fetch_assoc($query);
                $data = date_format(date_create(explode(" ", $dados['res_inicio'])[0]), "d/m/Y");
                $horaInicio = substr(explode(" ", $dados['res_inicio'])[1], 0, 5)."h";
                $horaFim = substr(explode(" ", $dados['res_fim'])[1], 0, 5)."h";
                $pagamento = $dados['res_pagamento'] == 1 ? "Pago" : "Pendente";
                $valTotal = $dados['res_valor_total'];

                $ministrante = $dados['eve_ministrante'];
                $nomeEvento = $dados['eve_nome'];
                $valEntrada = $dados['eve_valor_entrada'];
                $qtdInscritos = $dados['eve_qtd_inscritos'];
              ?>

              <div class="row invoice-info mb-4">
                  <div class="col-md-4 invoice-col">
                    <b>Data:</b> <?=htmlspecialchars($data)?><br>
                    <b>Horário de início:</b> <?=htmlspecialchars($horaInicio)?><br>
                    <b>Horário de término:</b> <?=htmlspecialchars($horaFim)?><br>
                    <b>Pagamento:</b> <?=htmlspecialchars($pagamento)?><br>
                    <b>Valor total:</b> <?=htmlspecialchars($valTotal)?><br>
                  </div>
                  <?php if($dados['eve_id'] != null):?>
                    <div class="col-md-4 invoice-col">
                      <b>Ministrante:</b> <?=htmlspecialchars($ministrante)?><br>
                      <b>Nome do evento:</b> <?=htmlspecialchars($nomeEvento)?><br>  
                      <b>Valor da entrada:</b > <?=htmlspecialchars($valEntrada)?><br>  
                      <b>Quantidade de inscritos:</b> <?=htmlspecialchars($qtdInscritos)?><br>  
                    </div>
                  <?php endif?>
                  <?php
                    if(!empty($dados['usu_id'])):?>
                      <div class="col-md-4 invoice-col">
                        <b>Nome/Razão Social:</b>&nbsp;<?=htmlspecialchars($dados["usu_nome"])?><br/>
                        <b>Email:</b>&nbsp;<?=htmlspecialchars($dados["usu_email"])?><br/>
                        <b>RG:</b>&nbsp;<?=htmlspecialchars($dados["usu_rg"])?><br/>
                        <b>CPF:</b>&nbsp;<?=htmlspecialchars($dados['usu_cpf'])?><br/>
                        <b>Telefone:</b>&nbsp;<?=htmlspecialchars($dados["usu_telefone"])?><br/>
                      </div>
                      <div class="col-md-4 invoice-col">
                        <b>CEP:</b>&nbsp;<?=htmlspecialchars($dados["usu_cep"])?><br/>
                        <b>Endereço:</b>&nbsp;<?=htmlspecialchars($dados["usu_endereco"])?><br/>
                        <b>Bairro:</b>&nbsp;<?=htmlspecialchars($dados["usu_bairro"])?><br/>
                        <b>Munícipio:</b>&nbsp;<?=htmlspecialchars($dados["usu_municipio"])?><br/>
                      </div>
                  <?php
                    else:?>
                      <div class="col-md-4 invoice-col">
                        <b>Nome/Razão Social:</b>&nbsp;<?=htmlspecialchars($dados["emp_razao_social"])?><br/>
                        <b>Email:</b>&nbsp;<?=htmlspecialchars($dados["emp_email"])?><br/>
                        <b>CNPJ:</b>&nbsp;<?=htmlspecialchars($dados["emp_cnpj"])?><br/>
                        <b>Telefone:</b>&nbsp;<?=htmlspecialchars($dados["emp_telefone"])?><br/>
                      </div>
                      <div class="col-md-4 invoice-col">
                        <b>CEP:</b>&nbsp;<?=htmlspecialchars($dados["emp_cep"])?><br/>
                        <b>Endereço:</b>&nbsp;<?=htmlspecialchars($dados["emp_endereco"])?><br/>
                        <b>Bairro:</b>&nbsp;<?=htmlspecialchars($dados["emp_bairro"])?><br/>
                        <b>Munícipio:</b>&nbsp;<?=htmlspecialchars($dados["emp_municipio"])?><br/>
                      </div>
                  <?php
                    endif;?>
                  
                
              </div>
              <?php if(strlen($dados['res_observacoes'])>0){ ?>
                <div class="row invoice-info mb-4">
                  <div class="col-12 invoice-col">
                      <b>Observações:</b> <?=htmlspecialchars($dados['res_observacoes']);?>
                      <br>  
                  </div>
                </div>
              <?php 
                }
              ?>
            </div>
          </div>
        </div>     
      </div>
    </section>
</div>
<?php
  include ('../includes/footer.php');
?>