<?php
session_start();
require_once "db.php";
if ($_SESSION["user"]["success"] == 1)
$name = $_SESSION["user"]["name"];
else
$name = $_POST['name'];
$text = $_POST['text'];
$day = date("d");
$month = date("m");
$year = date("Y");
$date = $day."/".$month."/".$year;
if (mb_strlen($name)<32 && mb_strlen($text)<255 && mb_strlen($name)!=0 && mb_strlen($text)!=0){
$sql = "INSERT INTO comments (name,text,date) VALUES (:name,:text,:date)";
$stmt=$pdo->prepare($sql);
$stmt->execute([":name"=>$name,":text"=>$text,":date"=>$date]);
$_SESSION["message"]["err"]["name"] = 0;
$_SESSION["message"]["err"]["text"] = 0;
$_SESSION["flash"]["message"] = 1;
}
else {

  if (mb_strlen($name)==0) {
$_SESSION["message"]["err"]["name"] = 1; //НЕДОСТАТОК
  }
else if (mb_strlen($name)>32){
$_SESSION["message"]["err"]["name"] = 2; //ПЕРЕИЗБЫТОК(32)
}
else {
$_SESSION["message"]["err"]["name"] = 0;//С ИМЕНЕМ ВСЁ НОРМАЛЬНО
}

if (mb_strlen($text)==0) {
$_SESSION["message"]["err"]["text"] = 1; //НЕДОСТАТОК
}
else if (mb_strlen($text)>32){
$_SESSION["message"]["err"]["text"] = 2; //ПЕРЕИЗБЫТОК(255)
}
else {
$_SESSION["message"]["err"]["text"] = 0;//С ТЕКСТОМ ВСЁ НОРМАЛЬНО
$_SESSION["flash"]["message"] = 0;
}
}
$_SESSION["message"]["handler"] = 1;
header("Location: ../index.php");
?>
