<?php
//setting header to json
header('Content-Type: application/json');

//get connection
$db = mysqli_connect("localhost", "root", "", "eei_db");


if(!$db){
	die("Connection failed: " . $db->error);
}


//query to get data from the table
$query = sprintf("SELECT COUNT(ticket_id) as count, 'SEV1' as sla  FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id)  WHERE s.severity_level= 'SEV1' AND MONTH(t.date_prepared)=MONTH(CURRENT_DATE()) AND (t.date_required < t.resolution_date OR (t.date_required < now() AND t.ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'SEV2' as sla FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id) WHERE s.severity_level= 'SEV2' AND MONTH(t.date_prepared)=MONTH(CURRENT_DATE()) AND (t.date_required < t.resolution_date OR (t.date_required < now() AND t.ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'SEV3' as sla  FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id) WHERE s.severity_level= 'SEV3' AND MONTH(t.date_prepared)=MONTH(CURRENT_DATE()) AND (t.date_required < t.resolution_date OR (t.date_required < now() AND t.ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'SEV4' as sla  FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id) WHERE s.severity_level= 'SEV4'AND  MONTH(t.date_prepared)=MONTH(CURRENT_DATE()) AND (t.date_required < t.resolution_date OR (t.date_required < now() AND t.ticket_status <7))
UNION SELECT COUNT(ticket_id) as count, 'SEV5' as sla  FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id) WHERE s.severity_level= 'SEV5'AND  MONTH(t.date_prepared)=MONTH(CURRENT_DATE()) AND (t.date_required < t.resolution_date OR (t.date_required < now() AND t.ticket_status <7))");
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
