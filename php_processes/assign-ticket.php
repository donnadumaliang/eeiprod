<?php
// include "../templates/dbconfig.php";
session_start();

$db = mysqli_connect("localhost", "root", "", "eei_db");


$a = mysqli_real_escape_string($db, $_POST['assignee']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$logger = $_SESSION['user_id'];
// $ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);


$query = "UPDATE ticket_t SET ticket_agent_id = '$a' WHERE ticket_id = $id";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}


//change status from pending to assigned
$query = "UPDATE ticket_t SET ticket_status = '6' WHERE ticket_id = $id";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

//get ticket agent name for activity log
$assignee = "SELECT CONCAT(r.first_name, ' ', r.last_name) AS assignee FROM ticket_t t LEFT JOIN user_t r on r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
// $assignee = "SELECT ticket_agent_id AS assignee FROM ticket_t t LEFT JOIN user_t r ON r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
$result = mysqli_query($db, $assignee);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$tagent= $row['assignee'];


//working activity log query
mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket assigned to $tagent', '$logger', '$id')");

//for swal ticket number display
$query2 = "SELECT CONCAT(r.first_name, ' ', r.last_name) AS assignee FROM ticket_t t LEFT JOIN user_t r on r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
$result = mysqli_query($db, $query2);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo json_encode($row['assignee']);


//notif table
$sql = "SELECT ticket_number from ticket_t WHERE ticket_id = $id";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$id','$a','$ticketNo has been assigned to you',0, now())";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}



mysqli_close($db);
?>
