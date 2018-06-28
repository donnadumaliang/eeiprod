<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$query2 = "SELECT * from user_access_ticket_t WHERE ticket_id = '$ticketID'";
$result = mysqli_query($db, $query2);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$query3 = "SELECT email_address, CONCAT(first_name, ' ', last_name) as name FROM user_t WHERE user_id = $row[approver]";
$result2 = mysqli_query($db, $query3);
$row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);

$query4 = "SELECT CONCAT(first_name, ' ', last_name) as name FROM user_t u left join ticket_t t on u.user_id = t.user_id WHERE t.ticket_id = '$ticketID'";
$result4 = mysqli_query($db, $query4);
$row4=mysqli_fetch_array($result4,MYSQLI_ASSOC);

//nav notification
$sql = "SELECT ticket_number,dept_proj from ticket_t WHERE ticket_id = $ticketID";
$row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
$ticketNo = $row3['ticket_number'];
$notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead) VALUES(DEFAULT, $ticketID,$row[approver],'New ticket $ticketNo for approval',0)";
if (!mysqli_query($db, $notifSql))
{
  die('Error' . mysqli_error($db));
}

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try{                           // Passing `true` enables exceptions
    //Server settings
    $mail->isSMTP();
     $mail->Timeout  =   3;                                      // Set mailer to use SMTP
    $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
    $mail->Password = "service@EEI1";                           // SMTP password
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->SMTPSecure = "tls";
    //Recipients
    $mail->setFrom("eeiserviceteam@gmail.com", "IT Service Team");
    $mail->addAddress($row2['email_address']);     // Add a recipient
    $mail->addReplyTo("eeiserviceteam@gmail.com", "IT Service Team");

    //Attachments

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "Access Request for Approval";
    $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
		$mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

    "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

      "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .

      "Hi <b>" . $row4['name'] . "</b>," . "<br><br>" .

       $row4['name'] . " is requesting for " . $row3['dept_proj']  . " access" .
       "<br> The Request has already been checked, kindly view and approve access request details through the EEI Service Desk website" .
       "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproductionv2/details.php?id=$ticketID\">Click here to go to website" . "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

      "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

    $mail->send();


    $query = "UPDATE user_access_ticket_t SET isChecked = true WHERE ticket_id = $ticketID";

    if (!mysqli_query($db, $query))
    {
      die('Error' . mysqli_error($db));
    }

    $query2 = "UPDATE ticket_t SET ticket_status = '2' WHERE ticket_id = $ticketID";

    if (!mysqli_query($db, $query2))
    {
      die('Error' . mysqli_error($db));
    }

    echo json_encode(array('success',$ticketNo));
  }
  catch (Exception $e) {
     $e->errorMessage();
      echo json_encode('error');//Pretty error messages from PHPMailer
      exit();
  }
mysqli_close($db);
?>
