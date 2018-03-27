
<?php
	#connect to the server and database
	$db = mysqli_connect("localhost", "root", "", "eei_db");
	$details=$_POST['details'];

  $old = $_POST['old'];
  $oldsev = $old[0];
  $oldpriority = $old[1];
  $oldrestime = $old[2];

	$sev = $details[0];
	$priority = $details[1];
	$restime = $details[2];

	#default value of image path
	#include middle name siguro
	$sql = "UPDATE sla_t SET severity_level='$sev', description='$priority',resolution_time='$restime' WHERE severity_level= '$oldsev'";
  if (mysqli_query($db, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($db);
}

?>
