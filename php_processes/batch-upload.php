<?php
$db = mysqli_connect("localhost", "root", "", "eei_db");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

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

if (isset($_POST['submit'])){
$file = $_FILES['file']['tmp_name'];

$handle = fopen($file, "r");
$c = 0;
$password = "usr@EEI1";
fgetcsv($handle);
while(($filesop = fgetcsv($handle, 0, ",")) !== false)
  {
    $userid = $filesop[0];
    $fname = $filesop[1];
    $lname = $filesop[2];
    $email = $filesop[3];
    $type = $filesop[4];
    $name = $fname . " " . $lname;
    $randpass = randomPassword();

       $sql ="INSERT INTO user_t (user_id,userid,first_name,last_name,password,email_address,user_type) VALUES (DEFAULT,'$userid','$fname','$lname',MD5('$password'),'$email','$type')";
       if (!mysqli_query($db, $sql))
       {
         die('Error' . mysqli_error($db));
         echo "Sorry! A problem was encountered.";
       }

       $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

           //Server settings$mail->

           $mail->isSMTP();                                      // Set mailer to use SMTP
           $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
           $mail->SMTPAuth = true;                               // Enable SMTP authentication
           $mail->Username = "dondumaliang@gmail.com";                 // SMTP username
           $mail->Password = "tritondrive";                           // SMTP password
           $mail->Port = 587;
           $mail->SMTPSecure = "tls";
           //Recipients
           $mail->setFrom("eeiserviceteam@gmail.com", "IT Service Team");
           $mail->addAddress($email,$name);     // Add a recipient
           $mail->addReplyTo("eeiserviceteam@gmail.com", "IT Service Team");
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

           "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproductionv2/index.php\">Click here to go to website" .

           "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

           "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

           $mail->send();


}?>
  <script>window.location='../manageUsers.php'</script>
  <?php
}

?>
