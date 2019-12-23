<?php
session_start();
$_SESSION["user"]["email"] = 0;
$_SESSION["user"]["pass"] = 0;
$_SESSION["user"]["name"] = 0;
$_SESSION["user"]["success"] = 0;
$_SESSION["user"]["image"] = 0;
$_SESSION["admin"]["success"] = 0;
if ($_COOKIE["name_cookie"] =! NULL && $_COOKIE["email_cookie"]!=NULL){
setcookie("name_cookie",NULL);
setcookie("email_cookie",NULL);
setcookie("image_cookie",NULL);
}
header("Location: ../index.php");
 ?>
