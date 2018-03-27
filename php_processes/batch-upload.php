<?php
$db = mysqli_connect("localhost", "root", "", "eei_db");


if (isset($_POST['submit'])){
$file = $_FILES['file']['tmp_name'];

$handle = fopen($file, "r");
$c = 0;
$password = "usr@EEI1";
fgetcsv($handle);
while(($filesop = fgetcsv($handle, 0, ",")) !== false)
  {
    $userid = $filesop[0];
    $fname = $filesop[1];
    $lname = $filesop[2];
    $email = $filesop[3];
    $type = $filesop[4];
    $name = $fname . " " . $lname;
    $password = 'usr@EEI1';

       $sql ="INSERT INTO user_t (user_id,userid,first_name,last_name,password,email_address,user_type) VALUES (DEFAULT,'$userid','$fname','$lname',MD5('$password'),'$email','$type')";
       if (!mysqli_query($db, $sql))
       {
         die('Error' . mysqli_error($db));
         echo "Sorry! A problem was encountered.";
       }



}?>
  <script>window.location='../manageUsers.php'</script>
  <?php
}

?>
