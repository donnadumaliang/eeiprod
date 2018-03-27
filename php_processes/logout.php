<?php
session_start();
setcookie('userid', 'x', 1, '/');
session_destroy();
header('location: ../index.php');
exit;
?>
