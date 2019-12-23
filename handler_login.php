<?php
session_start();
require_once("db.php");
$email = '"'.$_POST["email"].'"';
$password = $_POST["password"];
$sql = "SELECT email, pass FROM users WHERE email = ".$email."";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$em = $stmt -> fetchAll(PDO::FETCH_ASSOC);
$_SESSION["login"]["handler"] = 1;
if ($em != NULL)
{
    if (password_verify($password,$em[0]["pass"])){
    $sql = "SELECT email, pass,name,img,status  FROM users WHERE email = ".$email."";
    $stmt  = $pdo -> prepare($sql);
    $stmt -> execute();
    $mails = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["user"]["email"] = $mails[0]["email"];
    $_SESSION["user"]["pass"] = $mails[0]["pass"];
    $_SESSION["user"]["name"] = $mails[0]["name"];
    $_SESSION["user"]["image"] = $mails[0]["img"];
    $_SESSION["flash"]["login"] = 1;
    if($mails[0]["status"] == "user")
    $_SESSION["user"]["success"] = 1;
    if($mails[0]["status"] == "admin")
    $_SESSION["admin"]["success"] = 1;
    if ($_POST["remember"] == "remember") {
      setcookie("email_cookie",$_SESSION["user"]["email"]);
      setcookie("name_cookie",$_SESSION["user"]["name"]);
      setcookie("image_cookie",$_SESSION["user"]["image"]);
    }
    header("Location: ../index.php");
    }
    else{
    $_SESSION["login"]["err"]["pass"] = 1;
    $_SESSION["login"]["err"]["email"] = 1;
    if($mails[0]["status"] == "user")
    $_SESSION["user"]["success"] = 0;
    if($mails[0]["status"] == "admin")
    $_SESSION["admin"]["success"] = 0;
    header("Location: ../login.php");
    }
}
else{
    $_SESSION["login"]["err"]["email"] = 1;//Ошибка в пароле или email
    $_SESSION["login"]["err"]["pass"] = 1;
    if($mails[0]["status"] == "user")
    $_SESSION["user"]["success"] = 0;
    if($mails[0]["status"] == "admin")
    $_SESSION["admin"]["success"] = 0;
    header("Location: ../login.php");
}
 ?>
