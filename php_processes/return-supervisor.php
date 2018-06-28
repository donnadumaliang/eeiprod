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
$query3 = "UPDATE ticket_t SET ticket_status = 5, remarks='Ticket returned' WHERE ticket_id = '$id'";
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

$sql = "SELECT ticket_number from ticket_t WHERE ticket_id = $id";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];

//notif table
$query = "SELECT ticket_category FROM ticket_t WHERE ticket_id = '$id'";
$row=mysqli_fetch_array(mysqli_query($db, $query),MYSQLI_ASSOC);
if ($row['ticket_category'] == 'Technicals'){
  $result = mysqli_query($db, "SELECT user_id FROM user_t WHERE user_type='Technicals Group Manager'");
  while($row = mysqli_fetch_assoc($result)){
      $mgrId = $row['user_id'];
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead,timestamp) VALUES(DEFAULT, '$id','$mgrId','Ticket No. $ticketNo has been returned',0,now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }

  }
} elseif ($row['ticket_category'] == 'Access'){
  $result = mysqli_query($db, "SELECT user_id FROM user_t WHERE user_type='Access Group Manager'");
  while($row = mysqli_fetch_assoc($result)){
      $mgrId = $row['user_id'];
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead,timestamp) VALUES(DEFAULT, '$id','$mgrId','Ticket No. $ticketNo has been returned',0,now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }

  }

}else{
  $result = mysqli_query($db, "SELECT user_id FROM user_t WHERE user_type='Network Group Manager'");
  while($row = mysqli_fetch_assoc($result)){
      $mgrId = $row['user_id'];
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead,timestamp) VALUES(DEFAULT, '$id','$mgrId','Ticket No. $ticketNo has been returned',0,now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }

  }

}


mysqli_close($db);
?>
