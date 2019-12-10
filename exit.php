<?php
session_start();
$_SESSION["user"]["email"] = 0;
$_SESSION["user"]["pass"] = 0;
$_SESSION["user"]["name"] = 0;
$_SESSION["user"]["success"] = 0;
setcookie("name_cookie",NULL);
setcookie("email_cookie",NULL);
header("Location: ../index.php");
 ?>
