<?php
require_once("db.php");
$id = $_GET["id"];
$action = $_GET["action"];

if ($action == "accept")
{
  $sql = "UPDATE comments SET status=1 WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt -> execute([":id"=>$id]);
  header("Location: ../admin.php");
}
if ($action == "ban")
{
  $sql = "UPDATE comments SET status=0 WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt -> execute([":id"=>$id]);
    header("Location: ../admin.php");
}
if ($action == "delete")
{
  $sql = "DELETE FROM comments WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt -> execute([":id"=>$id]);
    header("Location: ../admin.php");
}
 ?>
