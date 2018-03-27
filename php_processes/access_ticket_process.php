
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
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}')";
        }

        elseif(strtotime($time)<strtotime('08:00:00')) {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$dateToday', '{$_SESSION['user_id']}')";
        }

        else {
          $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$curDate', '{$_SESSION['user_id']}')";
        }
      }
      else {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, ticket_status, date_prepared, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '1', '$datet', '{$_SESSION['user_id']}')";
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


      $query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, dept_proj, expiry_date, rc_no, approver, checker) VALUES('$latest_id', '$company', '$dp', '$expdate', '$rc', '$approverID', '$checkerID')";

      if (!mysqli_query($db, $query3))
      {
        die('Error' . mysqli_error($db));
      }

      for ($i = 0; $i < count($_POST['name']); $i++) {
          $type = $_POST['type'][$i];
          $name = $_POST['name'][$i];
          $application = $_POST['app_name'][$i];
          $nameTypeApp= "'" . $name ."'" . ',' . "'" .$type . "'". ',' . "'" .$application . "'" ;
        $sql = "INSERT INTO request_details_t (details_id,ticket_id,name,request_type,application_name)
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

      $query5 = "SELECT dept_proj FROM user_access_ticket_t u left join ticket_t t on u.ticket_id = t.ticket_id WHERE t.ticket_id = '$latest_id'";
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
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, date_prepared, ticket_status, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '$datet', '1', '{$_SESSION['user_id']}')";
      }
      elseif(strtotime($time)<strtotime('08:00:00')) {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, date_prepared, ticket_status, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '$dateToday', '1', '{$_SESSION['user_id']}')";
      }
      else {
        $query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, date_prepared, ticket_status, user_id) VALUES(DEFAULT, '$request_title', 'User Access', '$curDate', '1', '{$_SESSION['user_id']}')";
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


      $query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, dept_proj, expiry_date, rc_no, approver) VALUES('$latest_id', '$company', '$dp', '$expdate', '$rc', '$approverID')";

      if (!mysqli_query($db, $query3))
      {
        die('Error' . mysqli_error($db));
      }

      for ($i = 0; $i < count($_POST['name']); $i++) {
          $type = $_POST['type'][$i];
          $name = $_POST['name'][$i];
          $application = $_POST['app_name'][$i];
          $nameTypeApp= "'" . $name ."'" . ',' . "'" .$type . "'". ',' . "'" .$application . "'" ;
        $sql = "INSERT INTO request_details_t (details_id,ticket_id,name,request_type,application_name)
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

      $query5 = "SELECT dept_proj FROM user_access_ticket_t u left join ticket_t t on u.ticket_id = t.ticket_id WHERE t.ticket_id = '$latest_id'";
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
