<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.eei.com.ph/img/favicon.ico" />
  <title>EEI Service Desk</title>
  <?php include 'templates/css_resources.php' ?>
</head>

<body id="login-page">
  <div class="row">
  <div class="col s12 m12 l4 offset-l4">
      <div class="card-panel" id="login" class="row">
        <div class="card-content white-text">
          <div class="row">
          </div>
          <span class="card-title">
            <img src="img/logo.png" class="login-logo">
            <span class="card-title"><h5>Update Your Password</h5></span>
          </span>
        <form method="post">
            <div class="input-field form-field login" data-position="right" data-delay="50" data-html="true" data-tooltip="Password Requirements:<br>
                - 8-20 characters <br>
                - At least one uppercase letter (A-Z) <br>
                - At least one lowercase letter (a-z) <br>
                - At least one number (0-9) <br>
                - At least one special character (!@#$%^*())" class="tooltipped input-field col s12">
                <input  id="newpass" name="newpass" type="password" class="validate">
                <label for="newpass" id="newpass">New Password</label>
            </div>
            <div class="input-field form-field login">
              <input id="confirmnewpass" name="confirmnewpass" type="password" class="validate">
              <label for="confirmnewpass" id="confirmnewpass">Confirm New Password</label>
            </div>

            <div class="form-field input-field">
             <button style="width: 100%;" class="waves-effect waves-light btn" id="login" name="submit" type="submit">Update Password</button>
             <input value = "<?php echo $_SESSION['userid']?>" name="userid" type="hidden">

             <br>
          </div>
        </form>
      </div>

      <!-- end of modal -->

    </div>
</div>
</div>


  <?php
  session_start();
  $db = mysqli_connect("localhost", "root", "", "eei_db");

  if(isset($_POST['newpass']) && isset($_POST['confirmnewpass'])){

  $newpass = $_POST['newpass'];
  $confirmnewpass = $_POST['confirmnewpass'];
  $session = $_SESSION['userid'];

  //90days next update
  date_default_timezone_set('Asia/Manila');
  $dt = new DateTime(date('Y-m-d H:i:s') . ' + 90 days');
  $datet = $dt->format('Y-m-d H:i:s');
  if($newpass === $confirmnewpass){
    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $newpass)) {
      $query = "UPDATE user_t SET password = MD5('$newpass'), last_update = NOW(), next_update = '$datet' WHERE userid = '$session'";
      if (!mysqli_query($db, $query))
      {
        die('Error' . mysqli_error($db));
      } else{
        echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Success!","Your password has been updated!","success").then(function(){window.location="home.php";})';
        echo '});</script>';
      }
    }
    else{
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Error!","Password does not meet the requirements!","error");';
    echo '});</script>';
    }
  }
  else{
  echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
  echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("Error!","Passwords not matching!","error");';
  echo '});</script>';
  }}

  include 'templates/js_resources.php'; ?>
  </body>
</html>
