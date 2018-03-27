<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");



$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);


$query = "UPDATE user_access_ticket_t SET isChecked = true WHERE ticket_id = $ticketID";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$query2 = "UPDATE ticket_t SET ticket_status = '2' WHERE ticket_id = $ticketID";

if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}
// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }

$query2 = "SELECT * from user_access_ticket_t WHERE ticket_id = '$ticketID'";
$result = mysqli_query($db, $query2);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$query3 = "SELECT email_address, CONCAT(first_name, ' ', last_name) as name FROM user_t WHERE user_id = $row[approver]";
$result2 = mysqli_query($db, $query3);
$row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);

$query4 = "SELECT CONCAT(first_name, ' ', last_name) as name FROM user_t u left join ticket_t t on u.user_id = t.user_id WHERE t.ticket_id = '$ticketID'";
$result4 = mysqli_query($db, $query4);
$row4=mysqli_fetch_array($result4,MYSQLI_ASSOC);

//nav notification
$sql = "SELECT ticket_number from ticket_t WHERE ticket_id = $ticketID";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead) VALUES(DEFAULT, $ticketID,$row[approver],'New ticket $ticketNo for approval',0)";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}


mysqli_close($db);
?>
