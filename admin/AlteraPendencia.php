<?php
    if(!isset($_SERVER['HTTP_REFERER']))
        header('location: /');
    
    $id = $_POST['empresa'];

    $sql = "UPDATE empresa SET emp_pendencia = true WHERE emp_id=".$id;
    $query = mysqli_query($connect, $sql);
    if ($query)
        header("location: ../pages/gerenciarPendencia.php");