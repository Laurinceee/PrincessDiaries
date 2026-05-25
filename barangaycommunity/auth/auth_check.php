<?php

session_start();

if(!isset($_SESSION['official_id'])) {

    header("Location: ../auth/login.php");
    exit();

}

if(
    $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']
    ||
    $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']
){

    session_unset();
    session_destroy();

    header("Location: ../auth/login.php");
    exit();

}
?>