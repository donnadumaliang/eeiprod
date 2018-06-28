
<?php
session_start();
//server, db username, db password, db name
$db = mysqli_connect("localhost", "root", "", "eei_db");

$request_title = mysqli_real_escape_string($db, $_POST['title']);
$company = mysqli_real_escape_string($db, $_POST['company']);
$dp = mysqli_real_escape_string($db, $_POST['dp']);
$rc = mysqli_real_escape_string($db, $_POST['rc_no']);
$checker = mysqli_real_escape_string($db, $_POST['checker']);
$approver = mysqli_real_escape_string($db, $_POST['approver']);
$expdate = mysqli_real_escape_string($db, $_POST['expdate']);


$query5= "SELECT user_id from user_t WHERE CONCAT(first_name,' ',last_name)='$approver'";
$result2=mysqli_query($db, $query5);
$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$approverID= $row2['user_id'];

$query6= "SELECT user_id,email_address from user_t WHERE CONCAT(first_name,' ',last_name)='$checker'";
$result3=mysqli_query($db, $query6);
$row3= mysqli_fetch_array($result3,MYSQLI_ASSOC);
$checkerID= $row3['user_id'];
$checkerEmail = $row3['email_address'];

$query7= "SELECT user_id,email_address from user_t WHERE CONCAT(first_name,' ',last_name)='$approver'";
$result4=mysqli_query($db, $query7);
$row4= mysqli_fetch_array($result4,MYSQLI_ASSOC);
$aproverID= $row4['user_id'];
$approverEmail = $row4['email_address'];

$requestorname = $_SESSION['first_name'];
$requestorname .= " ";
$requestorname .= $_SESSION['last_name'];

//email notif to checker
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

if($checker!= NULL ){
  try{                           // Passing `true` enables exceptions
      //Server settings

      //check if checker and approver exists
      $query = "SELECT * FROM user_t WHERE CONCAT(first_name,' ',last_name)='$checker'";
      $result = mysqli_query($db, $query);
      $query2 = "SELECT * FROM user_t WHERE CONCAT(first_name,' ', last_name)='$approver'";
      $result2 = mysqli_query($db, $query2);

      if (( mysqli_num_rows($result2) == 0)|| (mysqli_num_rows($result) == 0) ){
        echo json_encode(array('error','invalid checker/approver'));//Pretty error messages from PHPMailer
        exit();
      }
      //end of checker

      $mail->isSMTP();
       $mail->Timeout  =   3;                           // Set mailer to use SMTP
      $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;
      $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
      $mail->Password = "service@EEI1";                           // SMTP password
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->SMTPSecure = "tls";
      //Recipients
      $mail->setFrom("eeiserviceteam@gmail.com", "IT Service Team");
      $mail->addAddress($checkerEmail, $checker);     // Add a recipient
      $mail->addReplyTo("eeiserviceteam@gmail.com", "IT Service Team");

            //Attachments
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Access Request for Review";
            $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
            $mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

            "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

              "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .

              "Hi <b>" . $checker . "</b>," . "<br><br>" .

               "$requestorname is requesting for access in " . $dp. " project/department." . "<br><br> As the checker assigned, kindly view and check the access request details through the EEI Service Desk website" .

              "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproductionv2/\">Click here to go to website" . "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

              "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

            $mail->send();


      date_default_timezone_set('Asia/Manila');
      //time
      $t = new DateTime(date('H:i:s'));
      $time = $t->format('H:i:s');
      //Tomorrow
      $dt = new DateTime(date('Y-m-d H:i:s') .  '+1 weekdays');
      $dateTomorrow = $dt->format('Y-m-d');
      $datet= $dateTomorrow . " 08:00:00";
      //Today
      $dt2day = new DateTime(date('Y-m-d H:i:s'));
      $dateNow = $dt2day->format('Y-m-d');
      $dateToday= $dateNow . " 08:00:00";
      $curDate = $dateNow . ' ' . $time;
      //Time now
      $time = $dt2day->format('H:i:s');
      //weekend or weekday if >= 6 then weekend
      $w = $dt->format('N');
      $w2 = $dt2day->format('N');
      if ($w2<6) {
        if (strtotime($time)>=strtotime('15:00:00')) {
          if ($rc!=NULL) {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}','$dp','$rc')";
          }else{
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'Service', '1', '$datet', '{$_SESSION['user_id']}','$dp')";

          }
        }

        elseif(strtotime($time)<strtotime('08:00:00')) {
          if ($rc!=NULL) {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$dateToday', '{$_SESSION['user_id']}','$dp', '$rc')";
          } else{
            $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$dateToday', '{$_SESSION['user_id']}','$dp')";
          }
        }

        else {
          if ($rc!=NULL) {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$curDate', '{$_SESSION['user_id']}','$dp', '$rc')";
          }else{
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$curDate', '{$_SESSION['user_id']}','$dp')";
          }
        }
      }
      else {
        if ($rc!=NULL) {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id, dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}','$dp', '$rc')";
        }else{
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id, dept_proj) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}','$dp')";
        }
      }

      if (!mysqli_query($db, $query1))
      {
        die('Error' . mysqli_error($db));
      }

      $latest_id = mysqli_insert_id($db);
      $query2 = "UPDATE ticket_t SET ticket_number= CONCAT(EXTRACT(YEAR FROM date_prepared), ticket_id)  WHERE ticket_id = '$latest_id'";
      if (!mysqli_query($db, $query2))
      {
        die('Error' . mysqli_error($db));
      }

      if($checker != NULL){
      $query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, expiry_date, approver, checker) VALUES('$latest_id', '$company', '$expdate', '$approverID', '$checkerID')";
      }else{
      $query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, expiry_date, approver) VALUES('$latest_id', '$company', '$expdate', '$approverID')";
      }


      if (!mysqli_query($db, $query3))
      {
        die('Error' . mysqli_error($db));
      }

      for ($i = 0; $i < count($_POST['name']); $i++) {
          $type = $_POST['type'][$i];
          $name = $_POST['name'][$i];
          $application = $_POST['app_name'][$i];
          $access = $_POST['access_request'][$i];
          $nameTypeApp= "'" . $name ."'" . ',' . "'" .$type . "'". ',' . "'" .$application . "'" . ',' . "'" .$access . "'" ;
        $sql = "INSERT INTO request_details_t (details_id,ticket_id,name,request_type,application_name,access_request)
        VALUES (DEFAULT,'$latest_id',$nameTypeApp)";
        if (!mysqli_query($db, $sql))
        {
          die('Error' . mysqli_error($db));
        }
      }


      //nav notification
      $query3= "SELECT user_id, ticket_number from ticket_t WHERE ticket_id = '$latest_id'";
      $result=mysqli_query($db, $query3);
      $row= mysqli_fetch_array($result,MYSQLI_ASSOC);

      //nav notification
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$latest_id',$checkerID,'Ticket No. $row[ticket_number] needs your review',0,now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }

      $query4 = "SELECT CONCAT(first_name, ' ', last_name) as name FROM user_t u left join ticket_t t on u.user_id = t.user_id WHERE t.ticket_id = '$latest_id'";
      $result4 = mysqli_query($db, $query4);
      $row4=mysqli_fetch_array($result4,MYSQLI_ASSOC);

      $query5 = "SELECT dept_proj FROM ticket_t t WHERE t.ticket_id = '$latest_id'";
      $result5 = mysqli_query($db, $query5);
      $row5=mysqli_fetch_array($result5,MYSQLI_ASSOC);

      $query4 = "SELECT ticket_number from ticket_t where ticket_id = '$latest_id'";

      $result = mysqli_query($db, $query4);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

      $ticketNo = $row['ticket_number'];

      echo json_encode(array('success',$ticketNo));

  }
  catch (Exception $e) {
     $e->errorMessage();
      echo json_encode('error');//Pretty error messages from PHPMailer
      exit();
  }
  } else{
  try{                           // Passing `true` enables exceptions
      //Server settings
   //check if checker and approver exists

      $query2 = "SELECT * FROM user_t WHERE CONCAT(first_name,' ', last_name)='$approver'";
      $result2 = mysqli_query($db, $query2);

      if (mysqli_num_rows($result2) == 0){
        echo json_encode(array('error','invalid checker/approver'));//Pretty error messages from PHPMailer
        exit();
      }

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = "eeiserviceteam@gmail.com";                 // SMTP username
      $mail->Password = "service@EEI1";                           // SMTP password
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->SMTPSecure = "tls";
      //Recipients
      $mail->setFrom("eeiserviceteam@gmail.com", "IT Service Team");
      $mail->addAddress($approverEmail, $approver);     // Add a recipient
      $mail->addReplyTo("eeiserviceteam@gmail.com", "IT Service Team");

            //Attachments
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Access Request for Review";
            $mail->AddEmbeddedImage('../img/email-header.png', 'email-header');    //Content
            $mail->Body = "<div style=\"background-color: #f5f5f5; padding: 50px\">" .

            "<img style=\"display: block;  margin: 0 auto;\" src=\"cid:email-header\">" .

              "<div style=\"background-color: white; height: max-content; margin: 0 auto; width: 662px; padding: 30px 40px 30px 40px; font-size: 14px; box-shadow: 0 2px 2px 0 rgba(66, 66, 66, 0.14), 0 1px 5px 0 rgba(134, 134, 134, 0), 0 3px 1px -2px rgba(134,135, 134, 0.2);\">" .

              "Hi <b>" . $checker . "</b>," . "<br><br>" .

               "$requestorname is requesting for access in " . $dp. " project/department." . "<br><br> As the checker assigned, kindly view and check the access request details through the EEI Service Desk website" .

              "<br><br><a style=\"background-color: #4b75ff; padding: 13px; color:white; border-radius: 3px; display: block; width: 26%; text-decoration: none; margin: 0 auto;\" href=\"http://localhost/eeiproductionv2/\">Click here to go to website" . "</a><br><br>--<br><b>IT Service Desk Team</b>" . "</div></div>" .

              "<div style=\"background-color: #2d3033; font-size: 11px; padding: 20px 0px; color:white; text-align: center;\">Copyright &copy; 2018 EEI Corporation | No. 12 Manggahan street, Libis, Quezon City 1101 Metro Manila.</div>";

            $mail->send();


      date_default_timezone_set('Asia/Manila');
      //time
      $t = new DateTime(date('H:i:s'));
      $time = $t->format('H:i:s');
      //Tomorrow
      $dt = new DateTime(date('Y-m-d H:i:s') .  '+1 weekdays');
      $dateTomorrow = $dt->format('Y-m-d');
      $datet= $dateTomorrow . " 08:00:00";
      //Today
      $dt2day = new DateTime(date('Y-m-d H:i:s'));
      $dateNow = $dt2day->format('Y-m-d');
      $dateToday= $dateNow . " 08:00:00";
      $curDate = $dateNow . ' ' . $time;
      //Time now
      $time = $dt2day->format('H:i:s');
      //weekend or weekday if >= 6 then weekend
      $w = $dt->format('N');
      $w2 = $dt2day->format('N');
      if (strtotime($time)>=strtotime('15:00:00')) {
        if ($rc!=NULL) {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}','$dp','$rc')";
        }else{
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'Service', '1', '$datet', '{$_SESSION['user_id']}','$dp')";

        }
      }

      elseif(strtotime($time)<strtotime('08:00:00')) {
        if ($rc!=NULL) {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$dateToday', '{$_SESSION['user_id']}','$dp', '$rc')";
        } else{
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$dateToday', '{$_SESSION['user_id']}','$dp')";
        }
      }

      else {
        if ($rc!=NULL) {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj, rc_no) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$curDate', '{$_SESSION['user_id']}','$dp', '$rc')";
        }else{
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id,dept_proj) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$curDate', '{$_SESSION['user_id']}','$dp')";
        }
      }

      if (!mysqli_query($db, $query1))
      {
        die('Error' . mysqli_error($db));
      }

      $latest_id = mysqli_insert_id($db);
      $query2 = "UPDATE ticket_t SET ticket_number= CONCAT(EXTRACT(YEAR FROM date_prepared), ticket_id)  WHERE ticket_id = '$latest_id'";
      if (!mysqli_query($db, $query2))
      {
        die('Error' . mysqli_error($db));
      }


      $query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, expiry_date, approver) VALUES('$latest_id', '$company', '$expdate', '$approverID')";

      if (!mysqli_query($db, $query3))
      {
        die('Error' . mysqli_error($db));
      }
      for ($i = 0; $i < count($_POST['name']); $i++) {
          $type = $_POST['type'][$i];
          $name = $_POST['name'][$i];
          $application = $_POST['app_name'][$i];
          $access = $_POST['access_request'][$i];
          $nameTypeApp= "'" . $name ."'" . ',' . "'" .$type . "'". ',' . "'" .$application . "'" . ',' . "'" .$access . "'" ;
        $sql = "INSERT INTO request_details_t (details_id,ticket_id,name,request_type,application_name,access_request)
        VALUES (DEFAULT,'$latest_id',$nameTypeApp)";
        if (!mysqli_query($db, $sql))
        {
          die('Error' . mysqli_error($db));
        }
      }

      //nav notification
      $query3= "SELECT user_id, ticket_number from ticket_t WHERE ticket_id = '$latest_id'";
      $result=mysqli_query($db, $query3);
      $row= mysqli_fetch_array($result,MYSQLI_ASSOC);

      //nav notification
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, '$latest_id',$approverID,'Ticket No. $row[ticket_number] needs your review',0,now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }

      $query4 = "SELECT CONCAT(first_name, ' ', last_name) as name FROM user_t u left join ticket_t t on u.user_id = t.user_id WHERE t.ticket_id = '$latest_id'";
      $result4 = mysqli_query($db, $query4);
      $row4=mysqli_fetch_array($result4,MYSQLI_ASSOC);

      $query5 = "SELECT dept_proj FROM ticket_t t WHERE t.ticket_id = '$latest_id'";
      $result5 = mysqli_query($db, $query5);
      $row5=mysqli_fetch_array($result5,MYSQLI_ASSOC);

      $query4 = "SELECT ticket_number from ticket_t where ticket_id = '$latest_id'";

      $result = mysqli_query($db, $query4);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

      $ticketNo = $row['ticket_number'];

      echo json_encode(array('success',$ticketNo));

  }
  catch (Exception $e) {
     $e->errorMessage();
      echo json_encode('error');//Pretty error messages from PHPMailer
      exit();
  }
}

  mysqli_close($db);
?>
