<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);

//id of cancelled is 9
$query = "UPDATE ticket_t SET ticket_status = '9' WHERE ticket_id = $ticketID";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}


$query4 = "SELECT ticket_number from ticket_t where ticket_id = $ticketID";
$result = mysqli_query($db, $query4);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo json_encode($row['ticket_number']);
mysqli_close($db);
?>
