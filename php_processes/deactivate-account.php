<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$id = $_POST['id'];

$query = "SELECT concat(first_name,last_name) as name FROM user_t WHERE user_id = $id";

$result  = mysqli_query($db, $query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$query = "UPDATE user_t SET isActive='0', deactivation_date = NOW() WHERE user_id = $id";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}


echo json_encode($row['name']);

mysqli_close($db);
?>
