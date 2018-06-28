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


  //notif table
  $sql = "SELECT ticket_number from ticket_t WHERE ticket_id = $id";
  $row3=mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
  $ticketNo = $row3['ticket_number'];




  if ($status == 7) {
          $query = "SELECT * FROM ticket_t WHERE ticket_id = '$id' ";
          $result  = mysqli_query($db, $query);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          $ticketNo = $row['ticket_number'];
          $user = $row['user_id'];

          //for autoclosing of ticket
          date_default_timezone_set('Asia/Manila');
          $dt = new DateTime(date('Y-m-d H:i:s') . ' + 3 weekdays');
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
          while($row = mysqli_fetch_assoc($result)){
            $mgr = $row['user_id'];
            $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $id,'$mgr','$ticketNo has been assigned to you',0, now())";

            if (!mysqli_query($db, $notifSql))
            {
              die('Error' . mysqli_error($db));
            }
          }
          $query2 = "UPDATE ticket_t SET date_assigned = NOW() WHERE ticket_id = $id";
          $row2=mysqli_query($db, $query2);
          $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Technicals Supervisor', '$logger', '$id')";
          $row3=mysqli_query($db, $querylog);


      }
      elseif ($category=='Access') {
        $query3 = "SELECT user_id, CONCAT(first_name, ' ', last_name) as mgr from user_t where user_type = 'Access Group Manager'";
        $result = mysqli_query($db, $query3);
        while($row = mysqli_fetch_assoc($result)){
          $mgr = $row['user_id'];
          $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $id,'$mgr','$ticketNo has been assigned to you',0, now())";

          if (!mysqli_query($db, $notifSql))
          {
            die('Error' . mysqli_error($db));
          }
        }
        $query2 = "UPDATE ticket_t SET date_assigned = NOW() WHERE ticket_id = $id";
        $row2=mysqli_query($db, $query2);
        $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Access Supervisor', '$logger', '$id')";
        $row3=mysqli_query($db, $querylog);


      }
      elseif ($category=='Network') {
        $query3 = "SELECT user_id, CONCAT(first_name, ' ', last_name) as mgr from user_t where user_type = 'Network Group Manager'";
        $result = mysqli_query($db, $query3);
        while($row = mysqli_fetch_assoc($result)){
          $mgr = $row['user_id'];
          $notifSql = "INSERT INTO notification_t (notification_id,ticket_id, user_id, notification_description, isRead, timestamp) VALUES(DEFAULT, $id,'$mgr','$ticketNo has been assigned to you',0, now())";

          if (!mysqli_query($db, $notifSql))
          {
            die('Error' . mysqli_error($db));
          }
        }
        $query2 = "UPDATE ticket_t SET date_assigned = NOW() WHERE ticket_id = $id";
        $row2=mysqli_query($db, $query2);
        $querylog = "INSERT INTO activity_log_t(activity_log_details, logger, ticket_id) VALUES('Ticket forwarded to Network Supervisor', '$logger', '$id')";
        $row3=mysqli_query($db, $querylog);
      }


      $sql = "SELECT resolution_time FROM sla_t WHERE id = '$severity'";
      $row3 = mysqli_fetch_array(mysqli_query($db, $sql),MYSQLI_ASSOC);
      $interval = $row3['resolution_time'];
      //date required
      $dateAssigned = "SELECT date_assigned FROM ticket_t WHERE ticket_id = $id";
      $row4 =mysqli_fetch_array(mysqli_query($db, $dateAssigned),MYSQLI_ASSOC);
      $dateAssigned = $row4['date_assigned'];

      function addRollover($givenDate, $addtime, $dayStart, $dayEnd, $weekDaysOnly) {
          //Break the working day start and end times into hours, minuets
          $dayStart = explode(',', $dayStart);
          $dayEnd = explode(',', $dayEnd);
          $datetime = new DateTime($givenDate);
          $startofday = clone $datetime;
          $startofday->setTime($dayStart[0], $dayStart[1]);
          $start=$startofday->format('Y-m-d H:i:s');
          //Create required datetime objects and hours interval
          if ($givenDate < $start) {
              $datetime = new DateTime($givenDate);
              $date = $datetime->format('Y-m-d');
              $newDate = $date . ' 08:00:00';
              $datetime = new DateTime($newDate);
          }
          else{
          $datetime = new DateTime($givenDate);
          }
          $endofday = clone $datetime;
          $endofday->setTime($dayEnd[0], $dayEnd[1]); //set end of working day time
          $interval = 'PT'.$addtime.'H';
          //Add hours onto initial given date
          $datetime->add(new DateInterval($interval));
          //if initial date + hours is after the end of working day

          if($datetime > $endofday)
          {
              //get the difference between the initial date + interval and the end of working day in seconds
              $seconds = $datetime->getTimestamp()- $endofday->getTimestamp();

              //Loop to next day
              while(true)
              {
                  $endofday->add(new DateInterval('PT24H'));//Loop to next day by adding 24hrs
                  $nextDay = $endofday->setTime($dayStart[0], $dayStart[1]);//Set day to working day start time
                  //If the next day is on a weekend and the week day only param is true continue to add days
                  if(in_array($nextDay->format('l'), array('Sunday','Saturday')) && $weekDaysOnly)
                  {
                      continue;
                  }
                  else //If not a weekend
                  {
                      $tmpDate = clone $nextDay;
                      $tmpDate->setTime($dayEnd[0], $dayEnd[1]);//clone the next day and set time to working day end time
                      $nextDay->add(new DateInterval('PT'.$seconds.'S')); //add the seconds onto the next day
                      //if the next day time is later than the end of the working day continue loop
                      if($nextDay > $tmpDate)
                      {
                          $seconds = $nextDay->getTimestamp()-$tmpDate->getTimestamp();
                          $endofday = clone $tmpDate;
                          $endofday->setTime($dayStart[0], $dayStart[1]);
                      }
                      else //else return the new date.
                      {
                          return $endofday;

                      }
                  }
              }
          }

          return $datetime;
      }

      date_default_timezone_set('Asia/Manila');

      $now = new DateTime($dateAssigned);
      $currentTime = $now->format('Y-m-d H:i:s');
      $day = $now->format('N');
      $time = $now->format('H:i:s');
      if ($day>=6 OR $time >'17:00:00') {
        $ct = new DateTime(date('Y-m-d') .  '+1 weekdays');
        $dt =$ct->format('Y-m-d');
        $currentTime = $dt . " 08:00:00";
      }


      $dayStart = '08,00';
      $dayEnd = '17,00';

      $future = addRollover($currentTime, $interval, $dayStart, $dayEnd, true);
      $date_required = $future->format('Y-m-d H:i:s');

      $dateRequired = "UPDATE ticket_t set date_required = '$date_required' WHERE ticket_id = $id";
      $run = mysqli_query($db, $dateRequired);

}
mysqli_close($db);
?>
