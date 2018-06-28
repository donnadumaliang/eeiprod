<?php
session_start();
   $db = mysqli_connect("localhost", "root", "", "eei_db");
    $id = mysqli_real_escape_string($db, $_POST['userid']);
    $sql="UPDATE notification_t SET isSeen = 1 WHERE user_id = '$id'";
    $result=mysqli_query($db, $sql);
?>
