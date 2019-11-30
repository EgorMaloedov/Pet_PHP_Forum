<?php
session_start();
require_once("db.php");
$email = $_POST["email"];
$password = $_POST["password"];
$sql = "SELECT email, pass FROM users WHERE email= '".$email."'";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$em = $stmt -> fetchAll(PDO::FETCH_ASSOC);
if ($em){
foreach ($em as $mail) {
  if  (password_verify($mail["pass"],$password) != TRUE){
  $_SESSION["user_log"] = 0;
  header("Location: ../index.php");
}
  else
  $_SESSION["pass_log_err"] = 1;
    header("Location: ../login.php");
  }
}
else {
  $_SESSION["name_log_err"] = 1;
  header("Location: ../login.php");
}

 ?>
