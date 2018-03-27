<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");



//mailer start
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//varies per computer
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

//donna's
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/Exception.php';
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/PHPMailer.php';
// require '/Applications/XAMPP/xamppfiles/htdocs/eei_merged/PHPMailer-master/src/SMTP.php';
$db = mysqli_connect("localhost", "root", "", "eei_db");


// $password = mysqli_real_escape_string($db, $_POST['password']);
$userid = mysqli_real_escape_string($db, $_POST['userid']);
$fname = mysqli_real_escape_string($db, $_POST['fname']);
$lname = mysqli_real_escape_string($db, $_POST['lname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$name = $fname . " " . $lname;
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);

//random password generator
function randomPassword() {
    $char = "!@#$%&()abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $charLength = strlen($char) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $charLength);
        $pass[] = $char[$n];
    }
    return implode($pass); //turn the array into a string
}

$randpass = randomPassword();


$query = "INSERT INTO user_t (user_id,userid,first_name,last_name,password,email_address,user_type) VALUES (DEFAULT,'$userid','$fname','$lname', MD5('$randpass'),'$email','$type')";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$latest_id = mysqli_insert_id($db);

$query4 = "SELECT CONCAT(first_name, ' ', last_name) as user_name from user_t where user_id = '$latest_id'";
$result = mysqli_query($db, $query4);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo json_encode($row['user_name']);


$accessmanager = "dondumaliang@gmail.com";
//mailer script
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    //Server settings$mail->

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
    $mail->Password = "service@EEI1";                            // SMTP password
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    //Recipients
    $mail->setFrom("eeiserviceteam@gmail.com", "EEI Service Desk Team");
    $mail->addAddress($email,$name);     // Add a recipient
    $mail->setFrom("dondumaliang@gmail.com", "Donna Dumaliang");
    // $mail->AddCC($accessmanager);
    //Attachments
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
    $mail->Subject = "EEI Service Desk User Details";
    $mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

    "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

    "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .

    "Hi <b>" . $name . "</b>," . "<br><br>" .

    "You have been granted access to the EEI Service Desk Application as a <b>" . $type . "</b>.<br><br>" .
    "The following are your login credentials: <br>" .
    "Username: <b>" . $userid . "</b><br>" .
    "Password: <b>" . $randpass . "</b><br><br>" .
    "You will be prompted to change your password on your first login. For inquiries, kindly reply to this email." .

    "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproduction/index.php\">Click here to go to website" .

    "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

    "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

    $mail->send();


mysqli_close($db);
?>
