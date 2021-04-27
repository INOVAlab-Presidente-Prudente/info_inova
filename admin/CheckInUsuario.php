<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

date_default_timezone_set('America/Sao_Paulo');
$cpf = $_GET['cpf'];

if (isset($cpf)) {
    require_once("DB.php");
    $sql = "SELECT usu_id FROM usuario WHERE usu_cpf = '".$cpf."'";
    $query = mysqli_query($connect, $sql);
    $usu_id = mysqli_fetch_assoc($query)['usu_id'];
    if ($usu_id != null) {
        $sql = "SELECT che_horario_entrada, che_id FROM check_in WHERE usu_id = '".$usu_id."' AND che_horario_entrada LIKE '".date('Y-m-d')."%' AND che_horario_saida is null";
        $query = mysqli_query($connect, $sql);
        $fetch = mysqli_fetch_assoc($query);
        $horarioEntrada = $fetch['che_horario_entrada'];
        $che_id = $fetch['che_id'];

        // verifica se ja existe um check in aberto
        if ($horarioEntrada != null) {
            $sql = "UPDATE check_in SET che_horario_saida = '".date("Y-m-d H:i:s")."' WHERE che_id = '".$che_id."'";
            $query = mysqli_query($connect, $sql);
            header("location: ../pages/checkin.php?checkout=true");
        } else {
            $sql = "INSERT INTO check_in VALUES (null, $usu_id, '".date("Y-m-d H:i:s")."', null)";
            $query = mysqli_query($connect, $sql);
            header("location: ../pages/checkin.php?checkin=true");
        }
    } else {
        header("location: ../pages/checkin.php?erro=cpf_nao_encontrado");
    }
}