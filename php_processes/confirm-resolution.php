<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);
$logger = $_SESSION['user_id'];

$query = "UPDATE ticket_t SET ticket_status = 8 WHERE ticket_id = $ticketID";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

//working activity log query
mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Confirmed by requestor. Ticket closed', '$logger', '$ticketID')");

$tagent = "SELECT ticket_number, ticket_agent_id FROM ticket_t WHERE ticket_id = $ticketID";
$result = mysqli_query($db, $tagent);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$ticketagent = $row['ticket_agent_id'];
$ticketNo = $row['ticket_number'];

$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead) VALUES(DEFAULT, $ticketID,$ticketagent,'Ticket $ticketNo has been closed',0)";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}



echo $ticketID;
mysqli_close($db);
?>
