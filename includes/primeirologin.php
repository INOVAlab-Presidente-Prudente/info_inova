<?php
if (isset($_SESSION['primeiro_login']))
    header("location: /pages/alterarSenha.php");