<?php
// include "../templates/dbconfig.php";
session_start();

$db = mysqli_connect("localhost", "root", "", "eei_db");


$reason = mysqli_real_escape_string($db, $_POST['return_reason']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$logger = $_SESSION['user_id'];
// $ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);

$query = "UPDATE ticket_t SET ticket_agent_id = NULL WHERE ticket_id = '$id'";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query2 = "INSERT INTO ticket_returns_t VALUES (DEFAULT, '$id', '$reason')";
if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}

//change status from assigned back to pending
$query3 = "UPDATE ticket_t SET ticket_status = 5 WHERE ticket_id = '$id'";
if (!mysqli_query($db, $query3))
{
  die('Error' . mysqli_error($db));
}

$query4 = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Returned to Supervisor - $reason', '$logger', '$id')";
if (!mysqli_query($db, $query4))
{
  die('Error' . mysqli_error($db));
}


//
// //get ticket agent name for activity log
// $assignee = "SELECT CONCAT(r.first_name, ' ', r.last_name) AS assignee FROM ticket_t t LEFT JOIN user_t r on r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
// // $assignee = "SELECT ticket_agent_id AS assignee FROM ticket_t t LEFT JOIN user_t r ON r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
// $result = mysqli_query($db, $assignee);
// $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
// $tagent= $row['assignee'];


//working activity log query

// //for swal ticket number display
// $query2 = "SELECT CONCAT(r.first_name, ' ', r.last_name) AS assignee FROM ticket_t t LEFT JOIN user_t r on r.user_id=t.ticket_agent_id WHERE ticket_id = $id";
// $result = mysqli_query($db, $query2);
// $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
// echo json_encode($row['assignee']);


//notif table

//get supervisor for activity log
$assignee = "SELECT u.user_id AS mgrID FROM user_t u LEFT JOIN ticket_t t on t.it_group_manager_id = u.user_id WHERE ticket_id = $id";
$result = mysqli_query($db, $assignee);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$mgrId= $row['mgrID'];

$sql = "SELECT ticket_number from ticket_t WHERE ticket_id = $id";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead,timestamp) VALUES(DEFAULT, '$id','$mgrId','Ticket No. $ticketNo has been returned',0,now())";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}



mysqli_close($db);
?>
