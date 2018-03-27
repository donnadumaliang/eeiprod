<?php
  session_start();
  if(!isset($_SESSION['user_id'])){
    header('location: index.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.eei.com.ph/img/favicon.ico" />
  <title>EEI Service Desk</title>
  <?php include 'templates/css_resources.php' ?>
</head>

<body>
  <?php include 'templates/navheader.php'; ?>
  <?php include 'templates/sidenav.php'; ?>

  <!-- ****************************************************** -->

  <!--body-->
  <div class="col s12 m12 l12" id="content">
    <div class="main-content">
      <div class="col s12 m12 l12 table-header">
        <span class="table-title">Your Notifications</span>
        <div class="col s12" id="breadcrumb">
          <a href="home.php" class="breadcrumb">Home</a>
          <a href="#!" class="breadcrumb">Notifications</a>
        </div>
        <?php
        // $crumbs = explode("/",$_SERVER["REQUEST_URI"]);
        // foreach($crumbs as $crumb){
        //   echo ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
        // }
        ?>
      </div>
      <div class="profile-body">
        <div class="all-notifs">
        <?php
        $db = mysqli_connect("localhost", "root", "", "eei_db");


        $sql="SELECT CONCAT(if( TIMESTAMPDIFF(day,n.timestamp,now())=0,'',concat(TIMESTAMPDIFF(day,n.timestamp,now()),'d ')) ,if(MOD( TIMESTAMPDIFF(hour,n.timestamp,now()), 24)=0,'',concat(MOD( TIMESTAMPDIFF(hour,n.timestamp,now()), 24), 'h ')), MOD( TIMESTAMPDIFF(minute,n.timestamp,now()), 60), 'm ago' ) as datediff, n.ticket_id, n.timestamp, n.notification_id, n.notification_description, t.date_assigned FROM notification_t n LEFT JOIN ticket_t t ON n.ticket_id = t.ticket_id  WHERE n.user_id = '{$_SESSION['user_id']}' ORDER BY n.notification_id DESC LIMIT 30";
        $result=mysqli_query($db, $sql);
        $response='';
        while($row=mysqli_fetch_array($result)) {
          $id = $row['notification_id'];
          $sql3="UPDATE notification_t SET isSeen = 1 WHERE notification_id = '$id'";
          $result3=mysqli_query($db, $sql3); ?>
          <div class="per-notif">
          <li>
            <a onclick="read(<?php echo $row['notification_id']?>)"><i class="tiny material-icons">notifications</i>&nbsp;&nbsp;<?php echo $row['notification_description']?></a>
            <span id="datediff"><?php echo $row['datediff'] ?></span>
          </li>
        </div>
      <?php }
        ?>

</div>
    </div>
  </div>  <!-- end of main body div -->

      <!-- ****************************************************** -->

        <!-- HIDDEN FORMS -->
        <?php include 'templates/ticketforms.php'; ?>
      </div> <!-- End of main container of col 10 -->
  <?php include 'templates/mobile-ticket-buttons.php' ?>
  <?php include 'templates/js_resources.php' ?>

</body>
</html>
