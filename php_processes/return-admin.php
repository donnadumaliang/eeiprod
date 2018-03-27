<?php
// include "../templates/dbconfig.php";
session_start();

$db = mysqli_connect("localhost", "root", "", "eei_db");


$reason = mysqli_real_escape_string($db, $_POST['return_reason']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$logger = $_SESSION['user_id'];
// $ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);

$query = "UPDATE ticket_t SET it_group_manager_id = NULL WHERE ticket_id = '$id'";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query = "UPDATE ticket_t SET ticket_category = NULL WHERE ticket_id = '$id'";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query = "UPDATE ticket_t SET remarks='Ticket returned' WHERE ticket_id = '$id'";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query2 = "INSERT INTO ticket_returns_t VALUES (DEFAULT, '$id', '$reason')";
if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}

mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket returned to IT Service Desk Agent - $reason', '$logger', '$id')");

//notif table
$sql = "SELECT ticket_number from ticket_t WHERE ticket_id = '$id'";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];

$agentquery = "SELECT user_id, user_type FROM user_t WHERE user_type ='Administrator'";
$result = mysqli_query($db, $agentquery);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$adminId= $row['user_id'];
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$id','$adminId','Ticket No. $ticketNo has been returned',0,now())";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}


mysqli_close($db);
?>
