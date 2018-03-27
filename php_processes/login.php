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

    if($firstlogin === NULL){ ?>
      <?php
        $db = mysqli_connect("localhost", "root", "", "eei_db");

        $usersession = $_SESSION['userid'];
        $islogin = "UPDATE user_t SET is_firstlogin = true WHERE userid = '$usersession'";
        if (!mysqli_query($db, $islogin))
        {
          die('Error' . mysqli_error($db));
        }
        ?>
        <script>window.location.assign('changepassword.php')</script>
        <?php
        }
        date_default_timezone_set('Asia/Manila');
        $dt = new DateTime(date('Y-m-d H:i:s'));
        $datet = $dt->format('Y-m-d H:i:s');
        if ($next_update <= $datet && !($next_update==null)) {?>
          <script>window.location.assign('changepassword.php')</script>
        <?php  }
        else { ?>
          <script>window.location.assign('home.php')</script>

        <?php }}else{
          echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
          echo '<script type="text/javascript">';
          echo 'setTimeout(function () { swal("Login Error!","Incorrect login details","error");';
          echo '});</script>';
        }}?>
<!-- END OF LOGIN PROCESS -->
