<!DOCTYPE html>
<html>
  <head>
<link rel="shortcut icon" type="image/x-icon" href="https://www.eei.com.ph/img/favicon.ico" />
<title>EEI Service Desk</title>
    <?php include 'templates/css_resources.php' ?>
  </head>
  <?php if(isset($_COOKIE['userid'])){ ?>
    <script>window.location.assign('home.php')</script>
    <?php } ?>
  <body id="login-page">
      <div class="row">
      <div class="col s12 m12 l4 offset-l4">
          <div class="card-panel" id="login" class="row">
            <div class="card-content white-text">
              <div class="row">
              </div>
              <span class="card-title">
                <img src="img/logo.png" class="login-logo">
                <h5 id="login">EEI Corporation's Service Desk</h5>
              </span>
            <form method="post">
                <div class="input-field form-field login">
                  <input id="userid" name="userid" type="text" class="validate" value="<?php
                        if(isset($_COOKIE['remember_meuser'])) {
                        echo $_COOKIE['remember_meuser'];
                        } ?>">
                <label for="userid" id="login">User Id</label>
                </div>
                <div class="input-field form-field login">
                  <label for="password" id="login">Password</label>
                  <input id="password" name="password" type="password" class="validate">
                </div>
                <div class="form-field row" id="controls">
                 <input type="checkbox" id="remember_me" name="remember_me" />
                 <label for="remember_me">Remember Me</label>
                 <a id="forgot-password" class="password-forgot modal-trigger" href="#modal2">Forgot Password?</a>
              </div>
                <div class="form-field input-field">
                 <button style="width: 100%;" class="waves-effect waves-light btn" id="login" name="submit" type="submit">Login</button>
                 <br>
              </div>
            </form>
          </div>

          <!-- Modal Structure -->
          <div id="modal2" class="modal modal-fixed-footer">
            <div class="modal-content">
              <h6>Enter registered email address</h6>
              <br>
              <form id="forgot-password" name="forgot-password" method="post">
                <div class="col s12 m12 l12 forgot-password-box" id="forgot-password-box">
                  <div class="input-field forgot-password" id="request-form-row2">
                    <div class="input-field" id="request-form">
                      <input placeholder=" " class="title" name="email" type="text" data-length="40" class="validate" required>
                      <label for="title">Email Address</label>
                    </div>

                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <input class="modal-action modal-close btn-flat" id="request-form-row" name="submit" type="submit" value="Save">
            </div>
          </form>
          </div>
          <!-- end of modal -->

        </div>
    </div>
</div>

    <!--LOGIN PROCESS-->
    <?php
    include "templates/dbconfig.php";
    if(isset($_POST['userid']) && isset($_POST['password'])){
      $username = $_POST['userid'];
      $password = md5($_POST['password']);
      $stmt = $db->prepare("SELECT * FROM user_t WHERE userid=? AND password=? ");
      $stmt->bindParam(1, $username);
      $stmt->bindParam(2, $password);
      $stmt->execute();
      $row = $stmt->fetch();
      $user = $row['userid'];
      $pass = $row['password'];
      $id = $row['user_id'];
      $fname = $row['first_name'];
      $lname = $row['last_name'];
      $email = $row['email_address'];
      $user_type = $row['user_type'];
      $firstlogin = $row['is_firstlogin'];
      $isActive = $row['isActive'];
      $next_update = $row['next_update'];
      if($username==$user && $password==$pass && $isActive=='1'){
        session_start();
        $_SESSION['userid'] = $user;
        $_SESSION['password'] = $pass;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['first_name'] = $fname;
        $_SESSION['last_name'] = $lname;
        $_SESSION['email_address'] = $email;

        $hour = time() + 3600;
        setcookie('userid', $_POST['userid'], $hour, '/');

        $year = time() + 31536000;
        if($_POST['remember_me']) {
            setcookie('remember_meuser', $_POST['userid'], $year);
            }
            elseif(!$_POST['remember_me']) {
            	if(isset($_COOKIE['remember_me'])) {
            		$past = time() - 100;
            		setcookie(remember_me, gone, $past);
            	}
            }


          if($firstlogin === NULL){
            $data = array("userid" => "$user");
            $islogin = $db->prepare("UPDATE user_t SET is_firstlogin = true WHERE userid = :userid");
            $islogin->execute($data);?>
            <script>window.location.assign('changepassword.php')</script>
            <?php
          }
            date_default_timezone_set('Asia/Manila');
            $dt = new DateTime(date('Y-m-d H:i:s'));
            $datet = $dt->format('Y-m-d H:i:s');
            if ($next_update <= $datet && !($next_update==null)) {?>
              <script>window.location.assign('changepassword.php')</script>
            <?php  }
            else {
              if($user_type != "Requestor" AND $user_type != "Administrator"){ ?>
                <script>window.location.assign('review-incoming-tickets.php')</script>
              <?php } else { ?>
              <script>window.location.assign('home.php')</script>

            <?php }}}else{
              echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
              echo '<script type="text/javascript">';
              echo 'setTimeout(function () { swal("Login Error!","Incorrect login details","error");';
              echo '});</script>';
            }}?>
    <!-- END OF LOGIN PROCESS -->


    <!--Import jQuery before materialize.js-->
      <?php include 'templates/js_resources.php' ?>
  </body>
</html>
