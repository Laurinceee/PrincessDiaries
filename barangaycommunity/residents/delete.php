<?php

include '../config/database.php';
session_start();

if($_SESSION['role'] != 'Admin') {

    die("Access Denied");

}

$id = $_GET['id'];

$query = "DELETE FROM residents
          WHERE resident_id = '$id'";

mysqli_query($conn, $query);

header("Location: index.php");

?>