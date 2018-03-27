<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


if (isset($_POST['id']))
{
  $id = $_POST['id'];
  $query = "DELETE FROM faq_article_t WHERE article_id = $id";
  if (!mysqli_query($db, $query))
  {
    die('Error' . mysqli_error($db));
  }
}
mysqli_close($db);

?>
