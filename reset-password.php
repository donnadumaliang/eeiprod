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

    </div>
</div>
</div>
<?php  include 'templates/js_resources.php'; ?>
  </body>
</html>
