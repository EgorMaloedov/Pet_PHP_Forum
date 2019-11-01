<?php
$driver = 'mysql';
$host = '127.0.0.1';
$db_name = 'project';
$db_user = 'root';
$db_password = '';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$dns = "$driver:$host=$host;dbname=$db_name;charset=$charset";
$pdo = new PDO($dns, $db_user, $db_password, $options);
 ?>
