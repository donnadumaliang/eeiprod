<?php
//setting header to json
header('Content-Type: application/json');

//get connection
$db = mysqli_connect("localhost", "root", "", "eei_db");


if(!$db){
	die("Connection failed: " . $db->error);
}

//query to get data from the table
$query = sprintf("SELECT COUNT(ticket_id) as count, 'January' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='January'
UNION SELECT COUNT(ticket_id) as count, 'February' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='February'
UNION SELECT COUNT(ticket_id) as count, 'March' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='March'
UNION SELECT COUNT(ticket_id) as count, 'April' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='April'
UNION SELECT COUNT(ticket_id) as count, 'May' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='May'
UNION SELECT COUNT(ticket_id) as count, 'June' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='June'
UNION SELECT COUNT(ticket_id) as count, 'July' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='July'
UNION SELECT COUNT(ticket_id) as count, 'August' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='August'
UNION SELECT COUNT(ticket_id) as count, 'September' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='September'
UNION SELECT COUNT(ticket_id) as count, 'October' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='October'
UNION SELECT COUNT(ticket_id) as count, 'November' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='November'
UNION SELECT COUNT(ticket_id) as count, 'December' as month FROM ticket_t WHERE  MONTHNAME(date_prepared)='December'");

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
