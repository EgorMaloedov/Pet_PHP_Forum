<?php
session_start();
require_once "db.php";
$pass_current = $_POST["current"];
$new_pass = $_POST["password"];
$pass_confirm = $_POST["password_confirmation"];
$email_log = "'".$_SESSION["user"]["email"]."'";

$sql = "SELECT pass FROM users WHERE email = ".$email_log."";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$pass =  $stmt -> FetchAll(PDO::FETCH_ASSOC);
$_SESSION["security"]["handler"] = 1;

if (mb_strlen($pass_current)==0)
$_SESSION["profile"]["err"]["pass_current"] = 1; //Пароль пустой
elseif (mb_strlen($pass_current)>32)
$_SESSION["profile"]["err"]["pass_current"] = 2; //Кол-во символов в пароле > 32
elseif(password_verify($pass_current,$pass[0]["pass"]))
$_SESSION["profile"]["err"]["pass_current"] = 0;
else
$_SESSION["profile"]["err"]["pass_current"] = 3; //Пароль неправильный


if (mb_strlen($new_pass)==0)
$_SESSION["profile"]["err"]["new_pass"] = 1; //Пароль пустой
elseif (mb_strlen($new_pass)>32)
$_SESSION["profile"]["err"]["new_pass"] = 2; //Кол-во символов в пароле > 32
else
$_SESSION["profile"]["err"]["new_pass"] = 0;

if (mb_strlen($pass_confirm)==0)
$_SESSION["profile"]["err"]["pass_confirm"] = 1; //Пароль пустой
elseif (mb_strlen($pass_confirm)>32)
$_SESSION["profile"]["err"]["pass_confirm"] = 2; //Кол-во символов в пароле > 32
elseif ($pass_confirm != $new_pass)
$_SESSION["profile"]["err"]["pass_confirm"] = 3; //Пароли не совпадают
else
$_SESSION["profile"]["err"]["pass_confirm"] = 0;

if ($_SESSION["profile"]["err"]["pass_current"] == 0 && $_SESSION["profile"]["err"]["new_pass"] == 0 && $_SESSION["profile"]["err"]["pass_confirm"] == 0){
  $_SESSION["flash"]["security"] = 1;
  $pass = password_hash($new_pass,PASSWORD_DEFAULT);
  $sql = "UPDATE users SET pass = :pass WHERE email = ".$email_log."";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute([":pass"=>$pass]);
}
  else
  $_SESSION["flash"]["security"] = 0;

header("Location: ../profile.php");
 ?>
