<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$email = mysqli_real_escape_string($db, $_POST['email']);


$sql = "SELECT email_address, CONCAT(first_name, ' ' , last_name) as username from user_t WHERE email_address = '$email'";
if (!mysqli_query($db, $sql))
{
  die('Error' . mysqli_error($db));
  echo 'Email not registered';
}
else {
  $token=getRandomString(10);
  $query="INSERT INTO token_t (token,email_address) values ('$token','$email')";
  mysqli_query($db, $query);

}

function getRandomString($length)
	   {
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
    $validCharNumber = strlen($validCharacters);
    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
	return $result;}


mysqli_close($db);
?>
