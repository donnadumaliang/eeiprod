<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    //Server settings$mail->

    $mail->isSMTP();             
      $mail->getSMTPInstance()->Timelimit = 15;	// Set mailer to use SMTP
    $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
    $mail->Password = "service@EEI1";                            // SMTP password
    $mail->Port = 587;       
      $mail->Timeout = 5;  	// TCP port to connect to
    $mail->SMTPSecure = "tls";
    $mail-> SMTPDebug = 2;
    //Recipients
    $mail->setFrom("eeiserviceteam@gmail.com", "EEI Service Desk Team");
    $mail->addAddress('aprilhannangelo@gmail.com', 'Hanney Angelo');     // Add a recipient
    $mail->addReplyTo("dondumaliang@gmail.com", "Donna Dumaliang");

    //Attachments

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "Access Request for Approval";
    $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
		$mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

    "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

      "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .


       "<br> The Request has already been checked, kindly view and approve access request details through the EEI Service Desk website" .
       "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/final-eei/details.php?id=\">Click here to go to website" . "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

      "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

    $mail->send();

mysqli_close($db);
?>
