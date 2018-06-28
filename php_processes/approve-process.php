<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");



$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);


$query = "UPDATE user_access_ticket_t SET isApproved = true WHERE ticket_id = $ticketID";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

// $errorMsg = mysqli_error($db);

$query2 = "UPDATE ticket_t SET ticket_status = '3' WHERE ticket_id  = $ticketID";

if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}

$query3= "SELECT user_id, ticket_number from ticket_t WHERE ticket_id =$ticketID";
$result=mysqli_query($db, $query3);
$row= mysqli_fetch_array($result,MYSQLI_ASSOC);

$sql = "SELECT user_id from user_t where user_type= 'Administrator'";
$result2= mysqli_query($db, $sql);
while($row2 = mysqli_fetch_assoc($result2)){
$adminId  = $row2['user_id'];
  $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead,timestamp) VALUES(DEFAULT, '$ticketID','$adminId','Ticket No. $row[ticket_number] needs your review',0,now())";
  if (!mysqli_query($db, $notifSql))
  {
    die('Error' . mysqli_error($db));
  }
}

// $errorMsg = mysqli_error($db);

// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }


mysqli_close($db);
?>
