<?php
session_start();
require_once "db.php";
$name = $_POST["name"];
$email = $_POST["email"];
$email_log = "'".$_SESSION["user"]["email"]."'";
$file = $_FILES["image"];
$folder = "uploads/images/";

$sql = "SELECT email,name FROM users";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$data = $stmt -> FetchAll(PDO::FETCH_ASSOC);

$_SESSION["profile"]["err"]["image"] = 0;
$_SESSION["profile"]["err"]["email"] = 0;
$_SESSION["profile"]["handler"] = 1;

if (mb_strlen($name) == 0)
  $_SESSION["profile"]["err"]["name"] = 1;//Имя пустое
elseif (mb_strlen($name) > 32)
  $_SESSION["profile"]["err"]["name"] = 2;//Строка переполнена
else
$_SESSION["profile"]["err"]["name"] = 0;
foreach ($data as $em) {
  if (in_array($name,$em))
  $_SESSION["profile"]["err"]["name"] = 3;//Имя занято
}

if (mb_strlen($email) == 0)
  $_SESSION["profile"]["err"]["email"] = 1;//Email пустой
elseif (mb_strlen($email) > 40)
  $_SESSION["profile"]["err"]["email"] = 2;//Строка переполнена
elseif (filter_var($email,FILTER_VALIDATE_EMAIL) != TRUE )
  $_SESSION["reg"]["err"]["email"] = 4;//email не соответствует стандарту
foreach($data as $em){
  if (in_array($email,$em))
  $_SESSION["profile"]["err"]["email"] = 3;//Email зарегестрирован
}

if(mb_strlen($file["name"])==0){
  $_SESSION["profile"]["err"]["image"] = 1;//Файл не загружен
}
else
$_SESSION["profile"]["err"]["image"] = 0;

if ($_SESSION["profile"]["err"]["name"] == 0 || $_SESSION["profile"]["err"]["email"] == 0 || $_SESSION["profile"]["err"]["image"] == 0){
  $_SESSION["flash"]["profile"] = 1;
  if ($_SESSION["profile"]["err"]["name"] == 0){
  $sql = "UPDATE users SET name = :name WHERE email = ".$email_log."";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute([":name"=>$name]);
  $_SESSION["user"]["name"] = $name;
}
  if($_SESSION["profile"]["err"]["email"] == 0){
  $sql = "UPDATE users SET email = :email WHERE email = ".$email_log."";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute([":email"=>$email]);
  $sql = "UPDATE comments SET mail = :email WHERE mail = ".$email_log."";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute([":email"=>$email]);
  $_SESSION["user"]["email"] = $email;
}
  if($_SESSION["profile"]["err"]["image"] == 0)
  {
    if($_SESSION["user"]["image"]!="no-user.jpg")
    unlink($_SESSION["user"]["image"]);
    $img_name = uniqid();
    $type = explode("/",$file["type"])[1];
    $image = $folder.$img_name.".".$type;
    $file["name"] = $img_name.".".$type;
    move_uploaded_file($file["tmp_name"],$image);
    $_SESSION["user"]["image"] = $image;
    $sql = "UPDATE users SET img=:img  WHERE email=".$email_log."";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([":img"=>$image]);
  }
}
  else
  $_SESSION["flash"]["profile"] = 0;


header("Location: ../profile.php");
 ?>
