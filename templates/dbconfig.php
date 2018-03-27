<?php
$host = 'localhost';
$dbname = 'eei_db';
$user = 'root';
$pass = '';

try {
  $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
// $db = mysqli_connect("localhost", "root", "", "eei_db");


?>
