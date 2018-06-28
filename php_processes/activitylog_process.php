<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

// $name = $_REQUEST['name'];

$logger = $_SESSION['user_id'];
$comments = mysqli_real_escape_string($db, $_POST['comments']);
$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);



mysqli_query($db, "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('$comments', '$logger', '$ticketID')");

$result = mysqli_query($db, "SELECT * FROM activity_log_t ORDER BY activity_log_id DESC");
while($row=mysqli_fetch_array($result)){
echo "<div class='comments_content'>";
echo "<h6>" . $row['activity_log_details'] . "</h6>";
echo "</div>";
}

$query= "SELECT ticket_category, ticket_number, user_id, ticket_agent_id from ticket_t WHERE ticket_id= $ticketID";
$result=mysqli_query($db, $query);
$row= mysqli_fetch_array($result,MYSQLI_ASSOC);
$tagent = $row['ticket_agent_id'];
$requestor = $row['user_id'];
$ticketNo = $row['ticket_number'];

if ($row['ticket_category'] == 'Technicals'){
  $result = mysqli_query($db, "SELECT user_id WHERE user_type='Technicals Group Manager'");
  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  $mgrId = $row['user_id'];
} elseif ($row['ticket_category'] == 'Access'){
  $result = mysqli_query($db, "SELECT user_id WHERE user_type='Access Group Manager'");
  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  $mgrId = $row['user_id'];
}else{
  $result = mysqli_query($db, "SELECT user_id WHERE user_type='Network Group Manager'");
  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  $mgrId = $row['user_id'];
}


//notif to all people involved in the ticket if someone posted an activity log
if($_SESSION['user_id'] != $mgrId and $row['ticket_category'] != NULL){
  $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$ticketID','$itmgr','New activity log for $ticketNo',0, now())";
  if (!mysqli_query($db, $notifSql))
  {
    die('Error' . mysqli_error($db));
  }
}

if($_SESSION['user_id'] != $tagent AND $row['ticket_agent_id'] != NULL){
  $notifSql2 = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$ticketID','$tagent','New activity log for $ticketNo',0, now())";
  if (!mysqli_query($db, $notifSql2))
  {
    die('Error' . mysqli_error($db));
  }
}

if($_SESSION['user_id'] != $requestor){
  $notifSql3 = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$ticketID','$requestor','New activity log for $ticketNo',0, now())";
  if (!mysqli_query($db, $notifSql3))
  {
    die('Error' . mysqli_error($db));
  }
}


mysqli_close($db);
?>
