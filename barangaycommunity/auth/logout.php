<?php

session_start();

session_unset();

session_destroy();

/*
|-------------------------------------------------------
| REDIRECT TO HOMEPAGE
|-------------------------------------------------------
*/

header("Location: ../index.php");
exit();

?>