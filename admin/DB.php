<?php

$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0)
{
    header("location: /");
    die();
}
$DB_HOST = 'den1.mysql6.gear.host';
$DB_USER = 'infoinova';
$DB_PASSWORD = 'infoinova123!';
$DB_NAME = 'infoinova';

$connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
