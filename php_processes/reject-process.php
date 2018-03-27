<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$reason = mysqli_real_escape_string($db, $_POST['reason']);

$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);

$logger = $_SESSION['user_id'];
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);

mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Resolution rejected by reviewer : $reason', '$logger', '$ticketID')");

$query = "UPDATE ticket_t SET ticket_status = 9 WHERE ticket_id= '$ticketID'";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query = "SELECT * FROM ticket_t WHERE ticket_id = '$ticketID' ";
$result  = mysqli_query($db, $query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$ticketNo = $row['ticket_number'];
$user = $row['user_id'];

//nav notification
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$ticketID',$user,'Your ticket $ticketNo has been cancelled',0, timestamp)";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}

mysqli_close($db);
?>
