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
        <span class="table-title">My Profile</span>
        <?php
        // $crumbs = explode("/",$_SERVER["REQUEST_URI"]);
        // foreach($crumbs as $crumb){
        //   echo ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
        // }
        ?>


      </div>
      <div class="profile-body">
          <h5 class="body-header"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></h5>
          <h6 class="body-header" id="line2"><?php echo $_SESSION['user_type'] ?></h6>
          <hr>
          <br>
          <table id="profile">
            <tbody>
              <tr>
                <td>First Name</td>
                <td><?php echo $_SESSION['first_name']?></td>
              </tr>
              <tr>
                <td>Last Name</td>
                <td><?php echo $_SESSION['last_name']?></td>
              </tr>
              <tr>
                <td>Userid</td>
                <td><?php echo $_SESSION['userid']?></td>
              </tr>
              <tr>
                <td>E-mail Address</td>
                <td><?php echo $_SESSION['email_address']?></td>
              </tr>
              <tr>
                <td>User Type</td>
                <td><?php echo $_SESSION['user_type']?></td>
              </tr>

            </tbody>
          </table>
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
