<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
// Create new Spreadsheet object

$db = mysqli_connect("localhost", "root", "", "eei_db");

$startdate = mysqli_real_escape_string($db, $_POST['startdate']);
$enddate = mysqli_real_escape_string($db, $_POST['enddate']);

$end = $enddate . ' 23:59:59';
$spreadsheet = new Spreadsheet();

// Set workbook properties


// Set active sheet index to the first sheet, so Excel opens this as the first sheet


//new spreadsheet for dashboard summary
$myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Dashboard Summary');
$spreadsheet->addSheet($myWorkSheet, 1);
$spreadsheet->setActiveSheetIndex(1);
$spreadsheet->getActiveSheet()->setCellValue('A1', 'Dashboard Summary for ' . $startdate . ' - ' . $enddate);
$spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('A2', 'SLA Ticket Summary');
$spreadsheet->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->setCellValue('A2', 'Severity Level');
$spreadsheet->getActiveSheet()->setCellValue('B2', 'Open Tickets Left');
for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
    $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
}
#severity levels
$query2 = "SELECT s.severity_level, count(t.ticket_id) as count, s.description FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id)  group by s.id";
$result2 = mysqli_query($db,$query2);
$row2=3;
while($row = mysqli_fetch_assoc($result2)){
  $sev = $row['severity_level'];

$query = "SELECT COUNT(*) as notclosed, (SELECT COUNT(*) FROM ticket_t k LEFT JOIN sla_t s ON s.id = k.severity_level WHERE s.severity_level= '$sev' AND (k.date_prepared BETWEEN '$startdate' AND '$end')) as sevtotal FROM ticket_t t LEFT JOIN sla_t s ON (s.id=t.severity_level) WHERE (t.date_prepared BETWEEN '$startdate' AND '$end') AND s.severity_level = '$sev' AND t.ticket_status >= 5 AND t.ticket_status < 8";
$result = mysqli_query($db,$query);

  while($row_data = mysqli_fetch_assoc($result)){
       $spreadsheet->getActiveSheet()->setCellValue('A'. $row2, $sev);
       $spreadsheet->getActiveSheet()->setCellValue('B'. $row2, $row_data['notclosed'] . '/' . $row_data['sevtotal']);
  }
$row2++;
}
$query = "SELECT COUNT(*) as unassigned, (SELECT COUNT(*) FROM ticket_t t WHERE t.ticket_status >= 5 and t.ticket_status <=8) as totaltickets FROM ticket_t t WHERE t.severity_level IS NULL";
$result = mysqli_query($db,$query);

  while($row_data = mysqli_fetch_assoc($result)){
       $spreadsheet->getActiveSheet()->setCellValue('A'. $row2, 'Unassigned');
       $spreadsheet->getActiveSheet()->setCellValue('B'. $row2, $row_data['unassigned'] . '/' . $row_data['totaltickets']);
  }

$row2=$row2+2;

$spreadsheet->getActiveSheet()->setCellValue('A' . $row2, 'Open/Closed Ticket Summary');
$spreadsheet->getActiveSheet()->getStyle('A' . $row2 . ':D' . $row2)->getFont()->setBold(true);

$query = "SELECT 'Open' as ticket_status, COUNT(ticket_id) AS count FROM ticket_t WHERE ticket_status <= '7' AND ticket_status >= '5' AND (ticket_t.date_prepared BETWEEN '$startdate' AND '$end')
UNION SELECT 'Closed' ticket_status, COUNT(ticket_id) AS count FROM ticket_t WHERE ticket_status > '6' and (ticket_t.date_prepared BETWEEN '$startdate' AND '$end')
";
$result = mysqli_query($db,$query);
$row2=$row2+1;
$spreadsheet->getActiveSheet()->setCellValue('A'. $row2, 'Ticket Status');
$spreadsheet->getActiveSheet()->setCellValue('B'. $row2, 'Ticket Count');

$row2=$row2+1;
while($row_data = mysqli_fetch_assoc($result)){
     $spreadsheet->getActiveSheet()->setCellValue('A'. $row2, $row_data['ticket_status']);
     $spreadsheet->getActiveSheet()->setCellValue('B'. $row2, $row_data['count']);

  $row2++;
}

$row2=$row2+2;
$spreadsheet->getActiveSheet()->setCellValue('A' . $row2, 'Ticket By Category Summary');
$spreadsheet->getActiveSheet()->getStyle('A' . $row2 . ':D' . $row2)->getFont()->setBold(true);

$query = "SELECT t.ticket_category, count(t.ticket_id) as 'Ticket Count' FROM ticket_t t WHERE t.ticket_category is not null AND t.ticket_category!='' and (t.date_prepared BETWEEN '$startdate' AND '$end')
group by t.ticket_category UNION SELECT 'Unassigned', count(t.ticket_id) as 'Ticket Count' FROM ticket_t t WHERE t.ticket_category is null AND (t.date_prepared BETWEEN '$startdate' AND '$end')";

$result = mysqli_query($db,$query);
$row2=$row2+1;
$spreadsheet->getActiveSheet()->setCellValue('A'. $row2, 'Ticket Category');
$spreadsheet->getActiveSheet()->setCellValue('B'. $row2, 'Ticket Count');

$row2=$row2+1;
while($row_data = mysqli_fetch_assoc($result)){
     $spreadsheet->getActiveSheet()->setCellValue('A'. $row2, $row_data['ticket_category']);
     $spreadsheet->getActiveSheet()->setCellValue('B'. $row2, $row_data['Ticket Count']);

  $row2++;
}
#tickets per month
$query = "SELECT MONTHNAME(t.date_prepared) as Month, count(t.ticket_id) as 'Ticket Count' FROM ticket_t t WHERE (t.date_prepared BETWEEN '$startdate' AND '$end') group by MONTHNAME(t.date_prepared)";
$result = mysqli_query($db,$query);
$row=2;
while($row_data = mysqli_fetch_assoc($result)){
  $month = $row_data['Month'];
  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $row_data['Month']);
  $spreadsheet->addSheet($myWorkSheet, $row);
  $spreadsheet->setActiveSheetIndex($row);
    $contentRow =2;
    $query2 = "SELECT * FROM ticket_t LEFT JOIN sla_t ON(ticket_t.severity_level = sla_t.id) WHERE MONTHNAME(ticket_t.date_prepared)= '$month'";
    $result2 = mysqli_query($db, $query2);
    $spreadsheet->getActiveSheet()->setCellValue('A1', 'Ticket Number');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'Ticket Title');
    $spreadsheet->getActiveSheet()->setCellValue('C1', 'Date Prepared');
    $spreadsheet->getActiveSheet()->setCellValue('D1', 'Ticket Category');
    $spreadsheet->getActiveSheet()->setCellValue('E1', 'Severity Level');
    $spreadsheet->getActiveSheet()->setCellValue('F1', 'Date Assigned');
    $spreadsheet->getActiveSheet()->setCellValue('G1', 'Resolution Date');
    for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
        $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
    }
    $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    while($row_data2 = mysqli_fetch_assoc($result2)){
         $spreadsheet->getActiveSheet()->setCellValue('A'. $contentRow, $row_data2['ticket_number']);
         $spreadsheet->getActiveSheet()->setCellValue('B'. $contentRow, $row_data2['ticket_title']);
         $spreadsheet->getActiveSheet()->setCellValue('C'. $contentRow, $row_data2['date_prepared']);
         $spreadsheet->getActiveSheet()->setCellValue('D'. $contentRow, $row_data2['ticket_category']);
         $spreadsheet->getActiveSheet()->setCellValue('E'. $contentRow, $row_data2['severity_level']);
         $spreadsheet->getActiveSheet()->setCellValue('F'. $contentRow, $row_data2['date_assigned']);
         $spreadsheet->getActiveSheet()->setCellValue('G'. $contentRow, $row_data2['resolution_date']);
         if ($row_data2['resolution_date'] > $row_data2['date_required']) {
           $spreadsheet->getActiveSheet()->setCellValue('H'. $contentRow, 'Overdue');
         }

      $contentRow++;
    }
  $row++;
}
// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Service Desk Report" (' . $startdate . ' - ' . $enddate . '").xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('php://output');


?>
