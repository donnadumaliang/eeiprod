<?php
session_start();
   $db = mysqli_connect("localhost", "root", "", "eei_db");
$id = mysqli_real_escape_string($db, $_POST['userid']);
   $count=0;
   $sql2 = "SELECT * FROM notification_t where user_id = '$id' AND isSeen = 0";
   $result=mysqli_query($db, $sql2);
   $count=mysqli_num_rows($result);
   echo $count;
?>
