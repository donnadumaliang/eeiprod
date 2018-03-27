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
          <span class="table-title">Settings</span>
        </div>
        <div class="content-body">
        <div class="row">
          <div class="col s12 m12 l5">
            <span><h6>Service Level Agreement</h6></span>
            <table class="striped">
              <thead>
                 <tr>
                   <th>Severity Level</th>
                   <th>Priority Level</th>
                   <th>Resolution Time (hrs)</th>
                   <!-- <th><a class="waves-effect waves-light modal-trigger" href="#edit_sla"><i id="edit" class="small material-icons">edit</i></a></th> -->
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
                    <td><div class = 'information'><?php echo $row['resolution_time']?></div></td>

                    <td class = 'info'><input id="<?php echo $row['id'] ?>" type="button" name="edit" value="Edit" class="edit_sla"><input id="<?php echo $row['id'] ?>" type="button" name="save" value="Save" class="save_sla" hidden>
                    </td>
                  </tr>
                <?php };?>
              </tbody>
            </table>
          </div>
          <div class="col s12 m12 l5">
            <span><h6>Knowledge Base Categories</h6></span>
            <table id="sla" class="striped">
              <thead>
                 <tr>
                   <th>Category</th>
                   <th>Subcategory</th>
                 </tr>
              </thead>
              <tbody>
               <?php
                 $db = mysqli_connect("localhost", "root", "", "eei_db");
                 $sevlvl = "SELECT * FROM faq_subcategory_t";
                 $result = mysqli_query($db,$sevlvl);
                 while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td> <?php echo $row['category']?></td>
                    <td> <?php echo $row['subcategory_name']?> </td>
                  </tr>
                <?php };?>
              </tbody>
            </table>
          </div>
          <!-- Modal sana but not yet final  -->
          <div id="edit_sla" data-target="edit_sla" class="modal modal-fixed-footer">
            <div class="modal-content">
              <h6>Edit Service Level Agreement</h6>
              <div class="row col s12 m6 l7">
              <form id="edit-sla" name="edit-sla" method="post">
                <table>
                  <thead>
                    <tr>
                    <th>Severity</th>
                    <th>Description</th>
                    <th>Hours</th>
                  </tr>
                </thead>
                    <tr>
                      <td><input type="text" name="sevlvl" required/></td>
                      <td><input type="text" name="desc" required/></td>
                      <td class="sevtime"><input type="text" name="sevtime"/></td>
                    </tr>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <input class="modal-action btn-flat" id="request-form-row" name="submit" type="submit" value="Save">
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php' ?>
  </body>
</html>
