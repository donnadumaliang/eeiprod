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
      <div class="col s12 m12 l12 table-header">
        <span class="table-title">Help and Support</span>
      </div>
      <div class="main-content">
        <div style="text-align:left" id="knowledge-base">
          <p style="font-size:24px;font-weight:500" class='no-margin'>Download User Manuals Here:</p>
          <?php
          if ($_SESSION['user_type'] == "Administrator"){?>
            <a href="<?php echo 'resources/ADMINISTRATOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'ADMINISTRATOR_EEI Service Desk User Manual _v1.0'?></a><br>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>
          <?php }
          else if ($_SESSION['user_type'] == "Access Group Manager"){?>
            <a href="<?php echo 'resources/ACCESS-GROUP-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'ACCESS-GROUP-MANAGER_EEI Service Desk User Manual _v1.0'?></a><br>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>
          <?php }
          else if ($_SESSION['user_type'] == "Technicals Group Manager"){?>
            <a href="<?php echo 'resources/TECHNICALS-GROUP-MANAGER_EEI Service Desk User Manual _v1.0.pdf'?>"><?php echo 'TECHNICALS-GROUP-MANAGER_EEI Service Desk User Manual _v1.0'?></a><br>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>
          <?php }
          else if ($_SESSION['user_type'] == "Network Group Manager"){?>
            <a href="<?php echo 'resources/NETWORK-GROUP-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'NETWORK-GROUP-MANAGER_EEI Service Desk User Manual _v1.0'?></a><br>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>
          <?php }
          elseif (($_SESSION['user_type'] == 'Technician') || ($_SESSION['user_type'] == 'Network Engineer')) {?>
            <a href="<?php echo 'resources/TECHNICIANS&NETWORK-ENGINEERS_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'TECHNICIANS&NETWORK-ENGINEERS_EEI Service Desk User Manual_v1.0'?></a><br>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>
          <?php }
          else {?>
            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>"><?php echo 'REQUESTOR_EEI Service Desk User Manual _v1.0'?></a><br>

          <?php } ?>
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
