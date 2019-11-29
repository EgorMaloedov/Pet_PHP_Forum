<?php
session_start();
require_once "db.php";
$name = $_POST["nm"];
$email = $_POST["email"];
$password = password_hash($_POST["password"],PASSWORD_DEFAULT);
$password_confirm = $_POST["password_confirmation"];
$sql = "SELECT email FROM users";
$stmt = $pdo -> query($sql);
$emails = $stmt -> fetchAll();
$_SESSION["handler_reg"] = 0;

if(password_verify($password_confirm,$password) != TRUE) //Пароли не совпадают
$_SESSION["password_confirm_err"] = 1;
else
$_SESSION["password_confirm_err"] = 0;

if(strlen($name)==0)
$_SESSION["name_err"] = 1; //Строка имени нулевая
elseif (strlen($name)>32)
$_SESSION["name_err"] = 2; //Кол-во символов в имени > 32
else
$_SESSION["name_err"] = 0;

if (strlen($_POST["password"])==0)
$_SESSION["pass_err"] = 1; //Пароль пустой
elseif (strlen($_POST["password"])>32)
$_SESSION["pass_err"] = 2; //Кол-во символов в пароле > 32
else
$_SESSION["pass_err"] = 0;

if (strlen($email)==0)
$_SESSION["email_err"] = 1;//email пустой
elseif (strlen($email)>40)
$_SESSION["email_err"] = 2;//Кол-во символов в email > 40
elseif (filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE )
$_SESSION["email_err"] = 3;//email не соответствует стандарту
else
$_SESSION["email_err"] = 0;
  foreach($emails as $em)
  {
      if (in_array($email,$em))
        $_SESSION["email_err"] = 4;//email зарегестрирован
  }




if (($_SESSION["password_confirm_err"] == 0) && ($_SESSION["name_err"] == 0) && ($_SESSION["pass_err"] == 0) && ($_SESSION["email_err"] == 0)){
$sql = "INSERT INTO users (email,name,pass) VALUES (:email,:name,:pass)" ;
$stmt = $pdo -> prepare($sql);
$stmt -> execute([":email"=>$email,":name"=>$name,":pass"=>$password]);
$_SESSION["user_log"] = 0;
header("Location: ../index.php");
}

else {
header("Location: ../register.php");
}


?>
