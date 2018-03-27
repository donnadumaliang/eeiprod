<?php
$db = mysqli_connect("localhost", "root", "", "eei_db");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

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
    $password = 'usr@EEI1';

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
           $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
           $mail->Password = "service@EEI1";                          // SMTP password
           $mail->Port = 587;
           $mail->SMTPSecure = "tls";
           //Recipients
           $mail->setFrom("eeiserviceteam@gmail.com", "EEI Service Desk Team");
           $mail->addAddress($email,$name);     // Add a recipient
           $mail->addReplyTo("dondumaliang@gmail.com", "Donna Dumaliang");
           // $mail->AddCC($accessmanager);
           //Attachments
           $mail->isHTML(true);                                  // Set email format to HTML
           $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
           $mail->Subject = "EEI Service Desk User Details";
          $mail->Body = "<img src=\"cid:email-header\">" .
           "<div style=\"background-color: #f5f5f5;width: 662px;padding: 30px 40px 30px 40px;border-radius: 5px;font-size: 14px;\">" .
           "Hi <b>" . $name . "</b>," . "<br><br>" .
           "You have been granted access to the EEI Service Desk Application as a <b>" . $type . "</b>.<br><br>" .
           "The following are your login credentials: <br>" .
           "Username: <b>" . $userid . "</b><br>" .
           "Password: <b> usr@EEI1 </b>" . "<br><br>" .
           "You will be prompted to change your password on your first login. For inquiries, kindly reply to this email." .
           "<br><br>" .
           "<b>IT Service Desk Team</b>" . "</div>";
           $mail->send();


}?>
  <script>window.location='../manageUsers.php'</script>
  <?php
}

?>
