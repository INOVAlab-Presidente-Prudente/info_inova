<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: ../');

session_start();
session_destroy();
header("location: ../");