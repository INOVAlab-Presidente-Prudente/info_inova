<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

date_default_timezone_set('America/Sao_Paulo');
$cpf = $_GET['cpf'];

if (isset($cpf)) {
    require_once("DB.php");
    $sql = "SELECT usu_id, usu_socio, emp_id FROM usuario WHERE usu_cpf = '".$cpf."'";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    $usu_id = $row['usu_id'];
    $socio = $row['usu_socio'];
    $emp = $row['emp_id'];
    if ($usu_id != null) {
        $sql = "SELECT che_horario_entrada, che_id FROM check_in WHERE usu_id = '".$usu_id."' AND che_horario_saida is null";
        $query = mysqli_query($connect, $sql);
        $fetch = mysqli_fetch_assoc($query);
        $horarioEntrada = $fetch['che_horario_entrada'];
        $che_id = $fetch['che_id'];

        $aviso = "";
        if($socio != null){
            $sql2 = "SELECT emp_razao_social FROM empresa WHERE emp_pendencia = true AND emp_id=".$emp;
            $query2 = mysqli_query($connect, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            if($row2 != null){
                $aviso = "&avisoPendencia=true";
            }
        }
        // verifica se ja existe um check in aberto
        if ($horarioEntrada != null) {
            $sql = "UPDATE check_in SET che_horario_saida = '".date("Y-m-d H:i:s")."' WHERE che_id = '".$che_id."'";
            $query = mysqli_query($connect, $sql);
            header("location: ../pages/checkin.php?status=checkin&usu_id=".$usu_id.$aviso);
        } else {
            $sql = "INSERT INTO check_in VALUES (null, $usu_id, '".date("Y-m-d H:i:s")."', null)";
            $query = mysqli_query($connect, $sql);
            header("location: ../pages/checkin.php?status=checkout&usu_id=".$usu_id.$aviso);
        }
    } else {
        header("location: ../pages/checkin.php?status=cpf_nao_encontrado");
    }
}