<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

//donna's
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/Exception.php';
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/PHPMailer.php';
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/SMTP.php';


// $password = mysqli_real_escape_string($db, $_POST['password']);
$userid = mysqli_real_escape_string($db, $_POST['userid']);
$fname = mysqli_real_escape_string($db, $_POST['fname']);
$lname = mysqli_real_escape_string($db, $_POST['lname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$name = $fname . " " . $lname;
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);

//random password generator
// function randomPassword() {
//     $char = "!@#$%&()abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
//     $pass = array(); //remember to declare $pass as an array
//     $charLength = strlen($char) - 1; //put the length -1 in cache
//     for ($i = 0; $i < 8; $i++) {
//         $n = rand(0, $charLength);
//         $pass[] = $char[$n];
//     }
//     return implode($pass); //turn the array into a string
// }
//
// $randpass = randomPassword();


$query = "INSERT INTO user_t (user_id,userid,first_name,last_name,password,email_address,user_type) VALUES (DEFAULT,'$userid','$fname','$lname', MD5('usr@EEI1'),'$email','$type')";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$latest_id = mysqli_insert_id($db);

$query4 = "SELECT CONCAT(first_name, ' ', last_name) as user_name from user_t where user_id = '$latest_id'";
$result = mysqli_query($db, $query4);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo json_encode($row['user_name']);




mysqli_close($db);
?>
