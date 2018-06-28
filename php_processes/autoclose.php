<?php

session_start();

   $db = mysqli_connect("localhost", "root", "", "eei_db");
   date_default_timezone_set('Asia/Manila');

   $dt = new DateTime(date('Y-m-d H:i:s'));
   $curDate = $dt->format('Y-m-d H:i:s');

    $sql = "UPDATE ticket_t set ticket_status = 8 WHERE auto_close_date<=now() AND ticket_status = 7 AND auto_close_date IS NOT NULL";

    $result=mysqli_query($db, $sql);

?>
