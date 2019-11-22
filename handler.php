<?php
session_start();
require_once "db.php";
$name = $_POST['name'];
$text = $_POST['text'];
$day = date("d");
$month = date("m");
$year = date("Y");
$date = $day."/".$month."/".$year;
if (strlen($name)<32 && strlen($text)<255 && strlen($name)!=0 && strlen($text)!=0){
$sql = "INSERT INTO comments (name,text,date) VALUES (:name,:text,:date)";
$stmt=$pdo->prepare($sql);
$stmt->execute([":name"=>$name,":text"=>$text,":date"=>$date]);
$_SESSION["err_name"] = 0;
$_SESSION["err_text"] = 0;
}
else {

  if (strlen($name)==0) {
$_SESSION["err_name"] = 1; //НЕДОСТАТОК
  }
else if (strlen($name)>32){
$_SESSION["err_name"] = 2; //ПЕРЕИЗБЫТОК(32)
}
else {
$_SESSION["err_name"] = 0;//С ИМЕНЕМ ВСЁ НОРМАЛЬНО
}

if (strlen($text)==0) {
$_SESSION["err_text"] = 1; //НЕДОСТАТОК
}
else if (strlen($text)>32){
$_SESSION["err_text"] = 2; //ПЕРЕИЗБЫТОК(255)
}
else {
$_SESSION["err_text"] = 0;//С ТЕКСТОМ ВСЁ НОРМАЛЬНО
}
}
$_SESSION["handler"] = 0;
header("Location: ../index.php");
?>
