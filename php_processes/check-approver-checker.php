<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$checker= mysqli_real_escape_string($db,$_POST['checker']);
$approver = mysqli_real_escape_string($db, $_POST['approver']);

  $query = "SELECT * FROM user_t WHERE CONCAT(first_name,last_name)='$checker'";
  $result = mysqli_query($db, $query);
  $query2 = "SELECT * FROM user_t WHERE CONCAT(first_name, last_name)='$approver'";
  $result2 = mysqli_query($db, $query2);

  if (( mysqli_num_rows($result2) == 0)|| (mysqli_num_rows($result) == 0) ){
    echo 'error';
  }
  else{
  echo 'success';
}

mysqli_close($db);

