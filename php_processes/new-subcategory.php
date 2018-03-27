<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$subcategory = mysqli_real_escape_string($db, $_POST['subcategory_name']);
$category = mysqli_real_escape_string($db, $_POST['category']);

$result = $mysqli->query("SELECT subcategory_name FROM faq_subcategory_t WHERE subcategory_name = '$subcategory'");
if($result->num_rows == 0) {
     // row not found, do stuff...

     $sql = "INSERT INTO faq_subcategory_t VALUES(DEFAULT, '$subcategory','$category')";
     if (!mysqli_query($db, $sql))
     {
       die('Error' . mysqli_error($db));
     }
     echo json_encode('success');

} else {
  $error = "Subcategory already existing";
  echo json_encode('error');
    // do other stuff...
}

mysqli_close($db);

?>
