<?php

$connect = mysqli_connect('db', 'tutorial', 'secret', 'infoinova');

$listdbtables = array_column($connect->query('SELECT ai_descricao FROM area_interesse')->fetch_all(), 0);

print_r($listdbtables);

?>