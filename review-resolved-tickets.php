<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: index.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="img/x-icon.jpg" />
  <title>EEI Service Desk</title>
  <?php include 'templates/css_resources.php' ?>
</head>
  <body>
    <?php include 'templates/navheader.php'; ?>
    <?php include 'templates/sidenav.php'; ?>
    <!--body-->
    <div class="col s12 m12 l12" id="content">
      <div class="main-content">
        <div class="col s12 m12 l12 table-header">
          <span class="table-title">Reviewed Resolved Tickets</span>
          <div class="count">
            <!-- Badge Counter -->
            <?php
              if ($_SESSION['user_type'] == "Administrator"){
                $query = "SELECT COUNT(*) as count FROM ticket_t WHERE ticket_t.ticket_status=7";
              }
              else if ($_SESSION['user_type'] == "Access Group Manager"){
                $id = $_SESSION['user_id'];
                $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 7 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
              }
              else if ($_SESSION['user_type'] == "Technicals Group Manager"){
                $id = $_SESSION['user_id'];
                $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 7 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
              }
              else if ($_SESSION['user_type'] == "Network Group Manager"){
                $id = $_SESSION['user_id'];
                $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 7 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
              }
              elseif (($_SESSION['user_type'] == 'Technician') || ($_SESSION['user_type'] == 'Network Engineer')) {
                $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status  = 7 AND (t.ticket_agent_id = '$id' OR (uat.checker='$id' AND uat.isChecked = true) OR (uat.approver = '$id' AND uat.isApproved = true))";
              }

              $result = mysqli_query($db,$query);
              while($row = mysqli_fetch_assoc($result)) { ?>
                <span class="badge main-count"> <?php echo $row['count'] . " tickets" ?></span>
              <?php } ?>
          </div>
          <div class="col s12" id="breadcrumb">
            <a href="#!" class="breadcrumb">Tickets for Review</a>
            <a href="#!" class="breadcrumb">Resolved Tickets Reviewed</a>
          </div>
        </div>
        <div class="material-table" id="my-tickets">
          <div class="actions">
              <?php include 'templates/filter-buttons.php' ?>
          </div>            <!-- MAIN TABLE -->
            <?php if ($_SESSION['user_type']=='Administrator') {?>
              <table id="datatable" class="striped">
                  <thead>
                      <tr>
                        <th class="col-catsev"></th>
                        <th class="col-ticketno">Ticket No.</th>
                        <th class="col-title">Title</th>
                        <th class="col-hidedatecreated">Date Created</th>
                        <th class="col-resolutiondate">Resolution Date</th>
                        <th class="col-remarks">Remarks</th>
                      </tr>
                    </thead>
                  <tbody>
                    <?php
                   $query = "SELECT *, DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status=7";
                   $stat = 'Resolved';
                   include 'templates/review-tickets-sorter.php';

                   $result = mysqli_query($db,$query);?>
                    <?php while($row = mysqli_fetch_assoc($result)){
                      switch($row['ticket_category'])
                       {
                           case("Technicals"):
                               $class = 'ticket_cat_t';
                               break;
                           case("Access"):
                              $class = 'ticket_cat_a';
                              break;
                           case("Network"):
                             $class = 'ticket_cat_n';
                             break;
                           case(""):
                             $class = 'ticket_cat_blank';
                             break;
                       }
                      ?><?php $date_required = $row['date_required'];
                      date_default_timezone_set('Asia/Manila');
                      $date1 = new DateTime(date('Y-m-d H:i:s'));
                      $date2 = new DateTime($date_required);
                      $interval = $date1->diff($date2);
                       ?>
                       <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                         <td class="col-sevcat" id="type">
                           <?php if ($date1<$date2) {?>
                           <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                         <?php } else{?>
                          <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                         </td>
                         <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                         <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                         <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                         <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                         <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
                       </tr>
                     <?php } ?>
                     </tbody>
              </table>

            <?php } elseif ($_SESSION['user_type']=='Access Group Manager') {?>
              <table id="datatable" class="striped">
                <thead>
                  <tr>
                    <th class="col-sevcat"></th>
                    <th class="col-ticketno">Ticket No.</th>
                    <th class="col-hidedatecreated">Date Created</th>
                    <th class="col-title">Title</th>
                    <th class="col-deptproj">Department/Project</th>
                    <th class="col-resolutiondate">Resolution Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php include 'templates/review-tickets-sorter.php';
                  $stat = 'Resolved';
                  $query = "SELECT *, DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date FROM ticket_t LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Access' AND ticket_t.ticket_status=7";
                  $result = mysqli_query($db,$query);
                  ?>

                  <?php while($row = mysqli_fetch_assoc($result)){
                    switch($row['ticket_category'])
                     {
                         case("Technicals"):
                             $class = 'ticket_cat_t';
                             break;
                         case("Access"):
                            $class = 'ticket_cat_a';
                            break;
                         case("Network"):
                           $class = 'ticket_cat_n';
                           break;
                         case(""):
                           $class = 'ticket_cat_blank';
                           break;
                     }
                    ?>
                    <?php $date_required = $row['date_required'];
                    date_default_timezone_set('Asia/Manila');
                    $date1 = new DateTime(date('Y-m-d H:i:s'));
                    $date2 = new DateTime($date_required);
                    $interval = $date1->diff($date2);
                     ?>
                     <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                       <td class="col-sevcat" id="type">
                         <?php if ($date1<$date2) {?>
                         <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                       <?php } else{?>
                        <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                       </td>
                       <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                       <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                       <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                       <td class="col-deptproj"> <?php echo $row['dept_proj']?>   </td>
                       <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                     </tr>
                   <?php } ?>
                 </tbody>
              </table>

            <?php } elseif ($_SESSION['user_type']=='Technicals Group Manager') {?>
              <table id="datatable" class="striped">
                <thead>
                  <tr>
                    <th class="col-sevcat"></th>
                    <th class="col-ticketno">Ticket No.</th>
                    <th class="col-title">Title</th>
                    <th class="col-hidedatecreated">Date Created</th>
                    <th class="col-resolutiondate">Resolution Date</th>
                    <th class="col-remarks">Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT *,DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Technicals' AND ticket_t.ticket_status=7";
                  $stat = 'Resolved';
                  include 'templates/review-tickets-sorter.php';
                  $result = mysqli_query($db,$query);?>

                  <?php while($row = mysqli_fetch_assoc($result)){
                    switch($row['ticket_category']) {
                         case("Technicals"):
                             $class = 'ticket_cat_t';
                             break;
                         case("Access"):
                            $class = 'ticket_cat_a';
                            break;
                         case("Network"):
                           $class = 'ticket_cat_n';
                           break;
                         case(""):
                           $class = 'ticket_cat_blank';
                           break;
                     }

                    $date_required = $row['date_required'];
                    date_default_timezone_set('Asia/Manila');
                    $date1 = new DateTime(date('Y-m-d H:i:s'));
                    $date2 = new DateTime($date_required);
                    $interval = $date1->diff($date2); ?>

                    <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                      <td class="col-sevcat" id="type">
                        <?php if ($date1<$date2) {?>
                        <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                      <?php } else{?>
                       <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                      </td>
                      <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                      <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                      <td class="col-hidedatecreated"> <?php echo $row['date_prepared']?>  </td>
                      <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                      <td class="col-remarks"> <?php echo $row['remarks'] ?>       </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>

            <?php } elseif ($_SESSION['user_type']=='Network Group Manager') {?>
              <table id="datatable" class="striped">
                <thead>
                  <tr>
                    <th class="col-sevcat"></th>
                    <th class="col-ticketno">Ticket No.</th>
                    <th class="col-title">Title</th>
                    <th class="col-hidedatecreated">Date Created</th>
                    <th class="col-resolutiondate">Resolution Date</th>
                    <th class="col-remarks">Remarks</th>
                  </tr>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      $query = "SELECT *, DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Network' AND ticket_t.ticket_status=7";
                      $stat = 'Resolved';
                      include 'templates/review-tickets-sorter.php';
                      $result = mysqli_query($db,$query);?>

                      <?php while($row = mysqli_fetch_assoc($result)){
                        switch($row['ticket_category'])
                         {
                             case("Technicals"):
                                 $class = 'ticket_cat_t';
                                 break;
                             case("Access"):
                                $class = 'ticket_cat_a';
                                break;
                             case("Network"):
                               $class = 'ticket_cat_n';
                               break;
                             case(""):
                               $class = 'ticket_cat_blank';
                               break;
                         }
                        ?>
                        <?php $date_required = $row['date_required'];
                        date_default_timezone_set('Asia/Manila');
                        $date1 = new DateTime(date('Y-m-d H:i:s'));
                        $date2 = new DateTime($date_required);
                        $interval = $date1->diff($date2);
                         ?>

                         <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                           <td class="col-sevcat" id="type">
                             <?php if ($date1<$date2) {?>
                             <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                           <?php } else{?>
                            <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                           </td>
                           <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                           <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                           <td class="col-hidedatecreated"> <?php echo $row['date_prepared']?>  </td>
                           <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                           <td class="col-remarks"> <?php echo $row['remarks'] ?>       </td>
                       </tr>
                     <?php } ?>
                   </tbody>
               </table>


            <?php } elseif ($_SESSION['user_type'] == 'Technician') { ?>
              <table id="datatable" class="striped">
                <thead>
                  <tr>
                    <th class="col-sevcat"></th>
                    <th class="col-ticketno">Ticket No.</th>
                    <th class="col-datecreated">Date Created</th>
                    <th class="col-title">Title</th>
                    <th class="col-datecreated">Remarks</th>
                    <th class="col-resolutiondate">Resolution Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT *, DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status=7 AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";
                  $stat = 'Resolved';
                  include 'templates/review-tickets-sorter.php';

                   $result = mysqli_query($db,$query);
                   while($row = mysqli_fetch_assoc($result)){
                      switch($row['ticket_category'])
                       {
                           case("Technicals"):
                               $class = 'ticket_cat_t';
                               break;
                           case("Access"):
                              $class = 'ticket_cat_a';
                              break;
                           case("Network"):
                             $class = 'ticket_cat_n';
                             break;
                           case(""):
                             $class = 'ticket_cat_blank';
                             break;
                       }?>

                       <?php $date_required = $row['date_required'];
                       date_default_timezone_set('Asia/Manila');
                       $date1 = new DateTime(date('Y-m-d H:i:s'));
                       $date2 = new DateTime($date_required);
                       $interval = $date1->diff($date2);
                        ?>

                     <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                       <td class="col-sevcat" id="type">
                         <?php if ($date1<$date2) {?>
                         <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                       <?php } else{?>
                        <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                       </td>
                       <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                       <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                       <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                       <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
                       <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                     </tr>
                   <?php } ?>
                 </tbody>
              </table>

            <?php } elseif ($_SESSION['user_type'] == 'Network Engineer') { ?>
              <table id="datatable" class="striped">
                <thead>
                   <tr>
                     <th class="col-sevcat"></th>
                     <th class="col-ticketno">Ticket No.</th>
                     <th class="col-datecreated">Date Created</th>
                     <th class="col-title">Title</th>
                     <th class="col-datecreated">Remarks</th>
                     <th class="col-resolutiondate">Resolution Date</th>
                   </tr>
                 </thead>
                <tbody>
                   <?php
                   $query = "SELECT *, DATE_FORMAT(resolution_date,'%d %M %Y %r') as resolution_date  FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status=7 AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";
                   $stat = 'Resolved';
                   include 'templates/review-tickets-sorter.php';

                    $result = mysqli_query($db,$query);
                    while($row = mysqli_fetch_assoc($result)){
                     switch($row['ticket_category'])
                      {
                          // assumes 'type' column is one of CAR | TRUCK | SUV
                          case("Technicals"):
                              $class = 'ticket_cat_t';
                              break;
                          case("Access"):
                             $class = 'ticket_cat_a';
                             break;
                          case("Network"):
                            $class = 'ticket_cat_n';
                            break;
                          case(""):
                            $class = 'ticket_cat_blank';
                            break;
                      }?>
                      <?php $date_required = $row['date_required'];
                      date_default_timezone_set('Asia/Manila');
                      $date1 = new DateTime(date('Y-m-d H:i:s'));
                      $date2 = new DateTime($date_required);
                      $interval = $date1->diff($date2);
                       ?>
                      <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                        <td class="col-sevcat" id="type">
                          <?php if ($date1<$date2) {?>
                          <span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p>
                        <?php } else{?>
                         <i id= "warning" class="material-icons">report</i> <p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p> <?php }?>
                        </td>
                        <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                        <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                        <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                        <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
                        <td class="col-resolutiondate"> <?php echo $row['resolution_date'] ?>  </td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table> <?php }?>
          </div>
        </div>
        <?php include 'templates/ticketforms.php'; ?>
      </div>
      <?php include 'templates/mobile-ticket-buttons.php' ?>
      <?php include 'templates/js_resources.php' ?>
    </body>
  </html>
