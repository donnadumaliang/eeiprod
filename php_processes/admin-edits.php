<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$severity= mysqli_real_escape_string($db,$_POST['sevtime']);
$sevid = mysqli_real_escape_string($db, $_POST['sevid']);

$query = "UPDATE sla_t SET resolution_time=$severity WHERE id = $_GET['id']";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}


//else{
//   // header("Location: ..\home.php");
// }

// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }


//for swal Display
// $query4 = "SELECT ticket_category, severity_level FROM ticket_t WHERE ticket_id = $id";
//
// $result = mysqli_query($db, $query4);
// $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//
// echo json_encode($row['ticket_category']);
// echo json_encode($row['severity_level']);


mysqli_close($db);
?>
