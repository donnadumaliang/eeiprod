<?php
//setting header to json
header('Content-Type: application/json');

//get connection
$db = mysqli_connect("localhost", "root", "", "eei_db");


if(!$db){
	die("Connection failed: " . $db->error);
}

//query to get data from the table
$query = sprintf("SELECT COUNT(ticket_id) as count, 'Technicals' as category FROM ticket_t WHERE ticket_category= 'Technicals' AND MONTH(date_prepared)=MONTH(CURRENT_DATE())AND (date_required < resolution_date OR (date_required < now() AND ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'Access' as category FROM ticket_t WHERE ticket_category= 'Access' AND MONTH(date_prepared)=MONTH(CURRENT_DATE()) AND (date_required < resolution_date OR (date_required < now() AND ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'Network' as category FROM ticket_t WHERE ticket_category= 'Network' AND MONTH(date_prepared)=MONTH(CURRENT_DATE()) AND (date_required < resolution_date OR (date_required < now() AND ticket_status <7))");

//execute query
$result = $db->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$db->close();

//now print the data
print json_encode($data);
