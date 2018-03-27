<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$article = mysqli_real_escape_string($db, $_POST['article']);
$articleid = mysqli_real_escape_string($db, $_POST['article_id']);

$sql = "UPDATE faq_article_t SET article_body = '$article' WHERE article_id = '$articleid'";
if (!mysqli_query($db, $sql))
{
  die('Error' . mysqli_error($db));
}

$query = "SELECT * FROM faq_article_t where article_id = '$articleid'";
$result = mysqli_query($db, $query);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
echo json_encode($row['article_id']);


mysqli_close($db);
?>
