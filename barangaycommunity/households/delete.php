<?php

session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

include '../config/database.php';

$id = $_GET['id'];

$query = "

    DELETE FROM households
    WHERE household_id = '$id'

";

mysqli_query($conn, $query);

header("Location: index.php");