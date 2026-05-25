<?php

$host = "localhost";
$username = "root";
$password = "123123";
$database = "barangay_db";

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

if(!$conn){

    die("Database Connection Failed: " . mysqli_connect_error());

}

/*
|--------------------------------------------------------------------------
| DEFAULT TIMEZONE
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Asia/Manila');

/*
|--------------------------------------------------------------------------
| CHARACTER SET
|--------------------------------------------------------------------------
| Prevent encoding issues & improve security
*/

mysqli_set_charset($conn, "utf8mb4");

/*
|--------------------------------------------------------------------------
| ERROR REPORTING
|--------------------------------------------------------------------------
| ENABLE ONLY DURING DEVELOPMENT
|--------------------------------------------------------------------------
*/

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

?>