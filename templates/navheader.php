<!-- Header Navbar goes here -->
<?php
   $db = mysqli_connect("localhost", "root", "", "eei_db");

   $count=0;
   $sql2 = "SELECT * FROM notification_t where user_id = '{$_SESSION['user_id']}' AND isSeen = 0";
   $result=mysqli_query($db, $sql2);
   $count=mysqli_num_rows($result);
?>
<script>
  function read($id){
    //get the input value
    $.ajax({
        //the url to send the data to
        url: "php_processes/updateNotif.php",
        //the data to send to
        data: {id : $id},
        //type. for eg: GET, POST
        type: "POST",
        success: function(data)
         {
           ticketNo= JSON.parse(data);
           window.location="details.php?id=" + ticketNo;
         }
    });
}
</script>
<!-- <header class="page-topbar"> -->
  <nav  class="color">
     <div class="nav-wrapper">
       <a href="#!" class="brand-logo"><img class="company_logo" src="img/eei-logo.jpg"></a><span class="name">EEI Corporation Help Desk</span>
       <ul class="right">
          <!-- Dropdown Trigger for New Ticket -->
          <li><a class="dropdown-button btn-invert hide-on-med-and-down" data-activates="dropdown2" data-beloworigin="true">New Ticket<i class="tiny material-icons" id="add-ticket">add</i></a></li>
          <!-- Dropdown Structure -->
          <ul id="dropdown2" class="dropdown-content collection">
              <li><a class="service"> Service Request</a></li>
              <li><a class="access">Access Request</a></li>
          </ul>

        <!-- Notification Bell Button -->
        <li><a  class="dropdown-button " href="#!" data-activates="dropdownNotifications" data-beloworigin="true"><i class="small material-icons">notifications_none</i>
          <?php if($count>0) { ?>
           <span class="new badge" id="notif"><?php echo $count; ?></span>
           <?php }?>
          <div id='notification_count'></div></a></li>
        <!-- Dropdown Structure -->
        <ul id="dropdownNotifications" class="dropdown-content collection arrow_box">
          <li disabled class="dropdown3content header">Notifications</li>

          <?php
          $db = mysqli_connect("localhost", "root", "", "eei_db");


          $sql="SELECT CONCAT(if( TIMESTAMPDIFF(day,n.timestamp,now())=0,'',concat(TIMESTAMPDIFF(day,n.timestamp,now()),'d ')) ,if(MOD( TIMESTAMPDIFF(hour,n.timestamp,now()), 24)=0,'',concat(MOD( TIMESTAMPDIFF(hour,n.timestamp,now()), 24), 'h ')), MOD( TIMESTAMPDIFF(minute,n.timestamp,now()), 60), 'm ago' ) as datediff, n.ticket_id, n.notification_id, n.notification_description, t.date_assigned FROM notification_t n LEFT JOIN ticket_t t ON n.ticket_id = t.ticket_id  WHERE n.user_id = '{$_SESSION['user_id']}' AND isRead = 0 ORDER BY n.notification_id DESC";
          $result=mysqli_query($db, $sql);
          $response='';
          while($row=mysqli_fetch_array($result)) {
            $id = $row['notification_id'];
            $sql3="UPDATE notification_t SET isSeen = 1 WHERE notification_id = '$id'";
            $result3=mysqli_query($db, $sql3);
          ?>
            <li class="dropdown3content">
              <a onclick="read(<?php echo $row['notification_id']?>)"><?php echo $row['notification_description']?><br><span class="datediff-gray"><?php echo $row['datediff'] ?></span></a>
            </li>

          <?php  } ?>
            <li class="dropdown3content viewall"><a id="viewall" href="all-notifications.php">View all notifications</a></li>
        </ul>

          <!-- Dropdown Trigger for My Profile -->
          <a disabled class="hide-on-med-and-down" id="account_circle" style="float:left; margin-right:-12px;"><i class="medium material-icons">account_circle</i></a>
          <li><a class="dropdown-button hide-on-med-and-down" href="#!" data-activates="dropdown" data-beloworigin="true"><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?><i class="right tiny material-icons" id="profile">keyboard_arrow_down</i></a></li>
          <!-- Dropdown Structure -->
          <ul id="dropdown" class="dropdown-content collection">
              <li><a href="myprofile.php">My Profile</a></li>
              <?php if($_SESSION['user_type'] == 'Administrator'){ ?>
                <li><a href="admin-settings.php">Admin Settings</a></li>
              <?php } ?>
              <li><a href="php_processes/logout.php">Log out</a></li>
          </ul>
       </ul>
     </div>
  </nav>
  <?php include 'templates/mobile-ticket-buttons.php' ?>

<!-- </header> -->
