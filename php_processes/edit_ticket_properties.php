<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$status = mysqli_real_escape_string($db, $_POST['status']);
$category = mysqli_real_escape_string($db, $_POST['category']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$severity= mysqli_real_escape_string($db,$_POST['severity']);
$al= mysqli_real_escape_string($db,$_POST['al']);
$logger = $_SESSION['user_id'];

  $query1 = "UPDATE ticket_t SET ticket_status='$status', ticket_category='$category', severity_level='$severity' WHERE ticket_id = $id";
  if (!mysqli_query($db, $query1))
  {
    die('Error' . mysqli_error($db));
  }

  //date required
  $datePrepared = "SELECT date_assigned FROM ticket_t WHERE ticket_id = $id";
  $row4 =mysqli_fetch_array(mysqli_query($db, $datePrepared),MYSQLI_ASSOC);
  $datePrepared = $row4['date_assigned'];
  $date = $datePrepared;

  $sql = "SELECT resolution_time FROM sla_t WHERE id = '$severity'";
  $row3 = mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
  $interval = $row3['resolution_time'];

  $dateRequired = "UPDATE ticket_t set date_required = DATE_ADD('$date', INTERVAL $interval  HOUR) WHERE ticket_id = $id";
  $run = mysqli_query($db, $dateRequired);

  if ($status == 7) {
          $query = "SELECT * FROM ticket_t WHERE ticket_id = '$id' ";
          $result  = mysqli_query($db, $query);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          $ticketNo = $row['ticket_number'];
          $user = $row['user_id'];

          //for autoclosing of ticket
          date_default_timezone_set('Asia/Manila');
          $dt = new DateTime(date('Y-m-d H:i:s') . ' + 4 weekdays');
          $closingDate = $dt->format('Y-m-d');
          //time
          $t = new DateTime(date('H:i:s'));
          $time = $t->format('H:i:s');
          $close = $closingDate . ' ' . $time;
            $query2 = "UPDATE ticket_t SET auto_close_date = '$close' WHERE ticket_id = $id";
              if (!mysqli_query($db, $query2))
              {
                die('Error' . mysqli_error($db));
              }

              $query3 = "UPDATE ticket_t SET resolution_date = NOW() WHERE ticket_id = $id";
                if (!mysqli_query($db, $query3))
                {
                  die('Error' . mysqli_error($db));
                }

        if($al != ""){
          $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Resolved - $al', '$logger', '$id')";
          $row3=mysqli_query($db, $querylog);
        }


          //nav notification
          $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $id,$user,'Your ticket: $ticketNo has been resolved',0,now())";
          if (!mysqli_query($db, $notifSql))
          {
            die('Error' . mysqli_error($db));
          }
      }

else{
      if ($category=='Technicals') {
          $query3 = "SELECT user_id, CONCAT(first_name, ' ', last_name) as mgr from user_t where user_type = 'Technicals Group Manager'";
          $result = mysqli_query($db, $query3);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          $mgrId= $row['user_id'];
          $mgrname = $row['mgr'];
          $query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId'   ,  date_assigned = NOW() WHERE ticket_id = $id";
          $row2=mysqli_query($db, $query2);
          $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Technicals Supervisor - $mgrname', '$logger', '$id')";
          $row3=mysqli_query($db, $querylog);
      }
      elseif ($category=='Access') {
        $query3 = "SELECT user_id, CONCAT(first_name, ' ', last_name) as mgr from user_t where user_type = 'Access Group Manager'";
        $result = mysqli_query($db, $query3);
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $mgrId= $row['user_id'];
        $query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId'  ,  date_assigned = NOW() WHERE ticket_id = $id";
        $row2=mysqli_query($db, $query2);
        $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Access Supervisor - $mgrname', '$logger', '$id')";
        $row3=mysqli_query($db, $querylog);
      }
      elseif ($category=='Network') {
        $query3 = "SELECT user_id, CONCAT(first_name, ' ', last_name) as mgr from user_t where user_type = 'Network Group Manager'";
        $result = mysqli_query($db, $query3);
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $mgrId= $row['user_id'];
        $query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId' , date_assigned = NOW() WHERE ticket_id = $id";
        $row2=mysqli_query($db, $query2);
        $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Network Supervisor - $mgrname', '$logger', '$id')";
        $row3=mysqli_query($db, $querylog);
      }

      //notif table
      $sql = "SELECT ticket_number from ticket_t WHERE ticket_id = '$id'";
      $row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
      $ticketNo = $row3['ticket_number'];
      $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $id, $mgrId,'$ticketNo has been assigned to you',0, now())";
      if (!mysqli_query($db, $notifSql))
      {
        die('Error' . mysqli_error($db));
      }
}


mysqli_close($db);
?>
