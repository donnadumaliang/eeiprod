<?php
  session_start();
  if(!isset($_SESSION['userid'])){
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
    <!--body-->
    <div class="col s12 m12 l12" id="content">
      <div class="main-content">
        <div class="col s12 m12 l12 table-header">
          <span class="table-title">Administrator Settings</span>
        </div>
        <div class="content-body">
        <div class="row">
          <div class="col s12 m12 l8">
            <h5><b>Service Level Agreement</b></h5>
            <table class="striped">
              <thead>
                 <tr>
                   <th>Severity Level</th>
                   <th>Priority Level</th>
                   <th>Resolution Time (hrs)</th>
                   <th></th>
                 </tr>
              </thead>
              <tbody>
               <?php
                 $db = mysqli_connect("localhost", "root", "", "eei_db");
                 $sevlvl = "SELECT * FROM sla_t";
                 $result = mysqli_query($db,$sevlvl);
                 while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>

                    <td> <div class = 'information'><?php echo $row['severity_level']?></div></td>
                    <td> <div class = 'information'><?php echo $row['description']?></div> </td>
                    <td><div class = 'information sla'><?php echo $row['resolution_time']?></div></td>

                    <td class = 'info'><input id="<?php echo $row['id'] ?>" type="button" name="edit" value="Edit" class="edit_sla"><input id="<?php echo $row['id'] ?>" type="button" name="save" value="Save" class="save_sla" hidden>
                    </td>
                  </tr>
                <?php };?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php' ?>
  </body>
</html>
