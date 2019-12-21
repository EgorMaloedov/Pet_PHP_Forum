<?php
session_start();
require_once "db.php";
$name = $_POST["nm"];
$email = $_POST["email"];
$password = password_hash($_POST["password"],PASSWORD_DEFAULT);
$password_confirm = $_POST["password_confirmation"];
$sql = "SELECT email,name FROM users";
$stmt = $pdo -> query($sql);
$emails = $stmt -> fetchAll();
if(password_verify($password_confirm,$password) != TRUE) //Пароли не совпадают
$_SESSION["reg"]["err"]["password_confirm"] = 1;
else
$_SESSION["reg"]["err"]["password_confirm"] = 0;

if(mb_strlen($name)==0)
$_SESSION["reg"]["err"]["name"] = 1; //Строка имени нулевая
elseif (mb_strlen($name)>32)
$_SESSION["reg"]["err"]["name"] = 2; //Кол-во символов в имени > 32
else
$_SESSION["reg"]["err"]["name"] = 0;

  foreach($emails as $em)
  {
    if(in_array($name,$em))
      $_SESSION["reg"]["err"]["name"] = 3; //Логин зарегестрирован
  }

if (mb_strlen($_POST["password"])==0)
$_SESSION["reg"]["err"]["pass"] = 1; //Пароль пустой
elseif (mb_strlen($_POST["password"])>32)
$_SESSION["reg"]["err"]["pass"] = 2; //Кол-во символов в пароле > 32
else
$_SESSION["reg"]["err"]["pass"] = 0;

if (mb_strlen($email)==0)
$_SESSION["reg"]["err"]["email"] = 1;//email пустой
elseif (mb_strlen($email)>40)
$_SESSION["reg"]["err"]["email"] = 2;//Кол-во символов в email > 40
elseif (filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE )
$_SESSION["reg"]["err"]["email"] = 3;//email не соответствует стандарту
else
$_SESSION["reg"]["err"]["email"] = 0;
  foreach($emails as $em)
  {
      if (in_array($email,$em))
        $_SESSION["reg"]["err"]["email"] = 4;//email зарегестрирован
  }
$_SESSION["reg"]["handler"] = 1;



if (($_SESSION["reg"]["err"]["password_confirm"] == 0) && ($_SESSION["reg"]["err"]["name"] == 0) && ($_SESSION["reg"]["err"]["pass"] == 0) && ($_SESSION["reg"]["err"]["email"] == 0)){
$sql = "INSERT INTO users (email,name,pass,img) VALUES (:email,:name,:pass,'no-user.jpg')" ;
$stmt = $pdo -> prepare($sql);
$stmt -> execute([":email"=>$email,":name"=>$name,":pass"=>$password]);
$_SESSION["user"]["success"] = 1;
$_SESSION["user"]["name"] = $name;
$_SESSION["user"]["email"] = $email;
$_SESSION["user"]['image'] = "no-user.jpg"; 
$_SESSION["flash"]["reg"] = 1;
header("Location: ../index.php");
}

else {
header("Location: ../register.php");
}


?>
