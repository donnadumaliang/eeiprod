<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");
$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
$reason = mysqli_real_escape_string($db, $_POST['reason']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);
$logger = $_SESSION['user_id'];

//working activity log query
mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Resolution rejected by requestor : $reason', '$logger', '$ticketID')");

$result = mysqli_query($db, "SELECT it_group_manager_id,ticket_agent_id,ticket_number FROM ticket_t WHERE ticket_id = $ticketID");
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
if ($row['ticket_agent_id']!=NULL) {
  $personIC= $row['ticket_agent_id'];
  $sql = "UPDATE ticket_t SET ticket_status = '6', auto_close_date = DEFAULT WHERE ticket_id = $ticketID";
}
else {
  $personIC= $row['it_group_manager_id'];
  $sql = "UPDATE ticket_t SET ticket_status = '5', auto_close_date = DEFAULT WHERE ticket_id = $ticketID";

}

if (!mysqli_query($db, $sql))
{
  die('Error' . mysqli_error($db));
}


//nav notification
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $ticketID,'$personIC','Your ticket: $row[ticket_number] resolution has been rejected by user',0,now())";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}

echo $ticketID;
mysqli_close($db);
?>
