<?php
  session_start();
  if(!isset($_SESSION['user_id'])){
    header('location: index.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="img/x-icon.jpg" />
  <title>EEI Service Desk</title>
  <?php include 'templates/css_resources.php' ?>
  <script>
  function deactivateAccount($id){
          swal({
          title: "Deactivate this account?",
          text: "This will set the user's account as inactive",
          icon: "warning",
          buttons: ["Cancel", "Deactivate"],
          dangerMode: true,
         })
         .then((willDeactivate) => {
          if (willDeactivate) {
          //get the input value
          $.ajax({
              //the url to send the data to
              url: "php_processes/deactivate-account.php",
              //the data to send to
              data: {id : $id},
              //type. for eg: GET, POST
              type: "POST",
              success: function()
               {
                 swal({
                    title: "Account deactivated",
                    type: "success",
                    icon: "success"
                }).then(function(){
                  location.reload();
                });
               }
              })
              } else {
                   swal("", "Account is not deactivated!","error");
                 }
                });
               };

     function reactivateAccount($id){
             swal({
             title: "Reactivate this account?",
             text: "This will set the user's account as active.",
             icon: "warning",
             buttons: ["Cancel", "Reactivate"],
             dangerMode: true,
            })
            .then((willSubmit) => {
             if (willSubmit) {
             //get the input value
             $.ajax({
                 //the url to send the data to
                 url: "php_processes/reactivate-account.php",
                 //the data to send to
                 data: {id : $id},
                 //type. for eg: GET, POST
                 type: "POST",
                 success: function()
                  {
                    swal({
                       title: "Account reactivated",
                       type: "success",
                       icon: "success"
                   }).then(function(){
                     location.reload();
                  });
                  }
                 })
                 } else {
                      swal("", "Account is not deactivated!","error");
                    }
                   });
                  };

  </script>
</head>
  <body>
    <?php include 'templates/navheader.php'; ?>
    <?php include 'templates/sidenav.php'; ?>
    <div class="col s12 m12 l12" id="content">
      <div class="main-content">
        <div class="col s12 m12 l12 table-header">
          <span class="table-title">User Profile
          </span>
          <?php
            $db = mysqli_connect("localhost", "root", "", "eei_db");
            $id = $_GET["id"];

            $query1 = "SELECT * from user_t where user_id = $id";

            if (!mysqli_query($db, $query1))
            {
              die('Error' . mysqli_error($db));
            }

            $result = mysqli_query($db, $query1);
            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

            mysqli_close($db); ?>
        <span class="row" id="ticket-actions">
          <button id="reactivate" class = "btn orange-btn edit_profile" name="submit" type="submit">Edit Profile</button>
          <button id="reactivate" class = "btn blue-btn save_profile" name="submit" type="submit" type="hidden">Save Profile</button>
          <?php
          if($row['isActive'] == '0'){ ?>
            <button disabled id="deactivated" class="btn">Deactivated</button>
            <button onclick="reactivateAccount(<?php echo $row['user_id']?>)" id="reactivate" class="btn blue-btn">Reactivate</button>
          <?php } else{
          ?>
            <button onclick="deactivateAccount(<?php echo $row['user_id']?>)" id="deactivate" class="btn red-btn">Deactivate</button>
          <?php } ?>
        </span>
        <div class="col s12" id="breadcrumb">
          <a href="manageUsers.php" class="breadcrumb">Manage Users</a>
          <a href="#!" class="breadcrumb">User Profile</a>
        </div>

        </div>
        <div class="profile-body">
          <h4 class="body-header"><b><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></b></h4>
          <h6 class="body-header" id="line2"><b><?php echo $row['user_type'] ?></b></h6>
              <table id="profile">
                <tbody>
                  <tr>
                    <td>First Name</td>
                    <td class = "pflBody editable"><?php echo $row['first_name']?></td>
                  </tr>
                  <tr>
                    <td>Last Name</td>
                    <td class = "pflBody editable"><?php echo $row['last_name']?></td>
                  </tr>
                  <tr>
                    <td>Userid</td>
                    <td class = "pflBody editable"><?php echo $row['userid']?></td>
                  </tr>
                  <tr>
                    <td>E-mail Address</td>
                    <td class = "pflBody editable"><?php echo $row['email_address']?></td>

                  </tr>
                  <tr>
                    <td>User Type</td>
                    <td class = "pflBody ">
                    <select id= "selectutype" name = "type" >
                      <option value ="<?php echo $row['status_id']?>" selected ><?php echo $row['user_type']?></option>
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");?>
                    <?php
                    $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'user_t' AND COLUMN_NAME = 'user_type'");
                    $row = mysqli_fetch_array($get_user_type);
                    $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                    foreach($enumList as $value){?>
                    <option> <?php echo $value?> </option>
                        <?php } ?>
                    </select></td>
                  </tr>
                  <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  $id = $_GET["id"];

                  $query1 = "SELECT * from user_t where user_id = $id";

                  if (!mysqli_query($db, $query1))
                  {
                    die('Error' . mysqli_error($db));
                  }

                  $result = mysqli_query($db, $query1);
                  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

                  mysqli_close($db);

                   ?>
                  <tr>
                    <td>Deactivation Date</td>
                    <td class = "pflBody" ><?php echo $row['deactivation_date']?></td>
                  </tr>
                  <tr>
                    <td>Reactivation Date</td>
                    <td class = "pflBody" ><?php echo $row['reactivation_date']?></td>
                  </tr>
                </tbody>
              </table>

            </div>
            <?php include 'templates/ticketforms.php'; ?>
          </div> <!-- End of main container of col 10 -->
        </div> <!-- End of wrapper of col l10 -->
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php' ?>
  </body>
</html>
