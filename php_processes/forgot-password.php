<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$email = mysqli_real_escape_string($db, $_POST['email']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

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

  try{
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

      //Server settings
      $mail->isSMTP();
       $mail->Timeout  =   3;                                     // Set mailer to use SMTP
      $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;
      $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
      $mail->Password = "service@EEI1";                           // SMTP password
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->SMTPSecure = "tls";
      //Recipients
      $mail->setFrom("eeiserviceteam@gmail.com", "IT Service Team");
      $mail->addAddress($email);     // Add a recipient
      $mail->addReplyTo("eeiserviceteam@gmail.com", "IT Service Team");

      //Attachments

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = "Change Password - EEI Service Desk";
      $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
      $mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

      "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

      "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .

      "Good day! <br><br>" .

      "You received this e-mail because you forgot your password. Kindly click the button below to reset your password </b><br><br>" .

      "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproductionv2/reset-password.php?token=$token\">Click here to go to website" .

      "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

      "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

      $mail->send();
      echo json_encode(array('success',$row['user_name']));
    }
    catch (Exception $e) {
       $e->errorMessage();
        echo json_encode('error');//Pretty error messages from PHPMailer
        exit();
    }

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
