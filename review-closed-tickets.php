<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: index.php');
  }
?>
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
          <span class="table-title">Review Closed Tickets</span>
          <div class="count">
            <!-- Badge Counter -->
            <?php
            if ($_SESSION['user_type'] == "Administrator"){
              $query = "SELECT COUNT(*) as count FROM ticket_t WHERE ticket_t.ticket_status=8";
            }
            else if ($_SESSION['user_type'] == "Access Group Manager"){
              $id = $_SESSION['user_id'];
              $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 8 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
            }
            else if ($_SESSION['user_type'] == "Technicals Group Manager"){
              $id = $_SESSION['user_id'];
              $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 8 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
            }
            else if ($_SESSION['user_type'] == "Network Group Manager"){
              $id = $_SESSION['user_id'];
              $query = "SELECT COUNT(*) as count FROM ticket_t t LEFT JOIN service_ticket_t st USING (ticket_id) LEFT JOIN user_access_ticket_t uat USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.ticket_status = 8 AND (t.it_group_manager_id = '$id' OR uat.checker='$id' OR uat.approver = '$id')";
            }
            else if ($_SESSION['user_type'] == "Technician"){
              $query = "SELECT COUNT(*) as count FROM ticket_t t WHERE t.ticket_status=8 AND t.ticket_agent_id = '".$_SESSION['user_id']."'";
            }
            else if ($_SESSION['user_type'] == "Network Engineer"){
              $query = "SELECT COUNT(*) as count FROM ticket_t t WHERE t.ticket_status=8 AND t.ticket_agent_id = '".$_SESSION['user_id']."'";
            }

              $result = mysqli_query($db,$query);
              while($row = mysqli_fetch_assoc($result)) { ?>
                <span class="badge main-count"> <?php echo $row['count'] . " tickets" ?></span>
              <?php } ?>
          </div>
          <div class="col s12" id="breadcrumb">
            <a href="#!" class="breadcrumb">Tickets for Review</a>
            <a href="#!" class="breadcrumb">Closed Tickets Reviewed</a>
          </div>
        </div>
        <div class="material-table" id="my-tickets">
          <div class="actions">
              <?php include 'templates/filter-buttons.php' ?>
          </div>          <!-- MAIN TABLE -->
          <?php if ($_SESSION['user_type']=='Administrator') {?>
            <table id="datatable" class="striped">
                <thead>
                    <tr>
                      <th class="col-sevcat"></th>
                      <th class="col-ticketno">Ticket No.</th>
                      <th class="col-title">Title</th>
                      <th class="col-datecreated">Date Created</th>
                      <th class="col-remarks">Remarks</th>
                    </tr>
                  </thead>
                <tbody>
                  <?php
                 $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status=8";
                 $stat = 'Closed';
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
                       <td class="col-datecreated"> <?php echo $row['date_prepared']?>  </td>
                       <td class="col-remarks"> <?php echo $row['remarks'] ?>       </td>
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
                  <th class="col-remarks">Remarks</th>
                </tr>
              </thead>
              <tbody>
                <?php $query = "SELECT * FROM ticket_t LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Access' AND ticket_t.ticket_status  = 8";
                $stat = 'Pending';
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
                     <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                     <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                     <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
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
                  <th class="col-hidedatecreated">Date Created</th>
                  <th class="col-title">Title</th>
                  <th class="col-remarks">Remarks</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Technicals' AND ticket_t.ticket_status= 8";
                $stat = 'Pending';
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
                    <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                    <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                    <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
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
                  <th class="col-hidedatecreated">Date Created</th>
                  <th class="col-title">Title</th>
                  <th class="col-remarks">Remarks</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category='Network' AND ticket_t.ticket_status  = 8";
                    $stat = 'Pending';
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
                        <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                        <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                        <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
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
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status = 8 AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";
                $stat = 'Closed';
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
                       <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                       <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                       <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
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
                 </tr>
               </thead>
              <tbody>
                 <?php
                 $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status  = 8 AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";
                 $stat = 'Closed';
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
                      <td class="col-hidedatecreated"> <?php echo $row['date_prepared'] ?>  </td>
                      <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                      <td class="col-remarks"> <?php echo $row['remarks']?>  </td>
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
