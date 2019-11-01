<?php
require_once "db.php";
$name = $_POST['name'];
$text = $_POST['text'];
$sql = "INSERT INTO comments (name,text) VALUES (:name,:text)";
$stmt=$pdo->prepare($sql);
$stmt->execute([":name"=>$name,":text"=>$text]);
header("Location: ../index.php");
?>
