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
        <div class="row col s12 m12 l12 table-header">
          <span class="table-title">Reviewed Pending Tickets</span>
          <!-- Badge Counter -->
          <div class="count">
          <?php
            if($_SESSION['user_type'] == "Administrator"){
              $query = "SELECT COUNT(*) as count FROM ticket_t WHERE ticket_status=5";
            }

            $result = mysqli_query($db,$query);
            while($row = mysqli_fetch_assoc($result)) { ?>
              <span class="badge main-count"> <?php echo $row['count'] . " tickets" ?></span>
            <?php } ?>
          </div>
          <div id="breadcrumb">
            <a href="#!" class="breadcrumb">Tickets for Review</a>
            <a href="#!" class="breadcrumb">Pending Tickets Reviewed</a>
          </div>



        </div>
        <div class="material-table" id="my-tickets">
          <div class="actions">
              <?php include 'templates/filter-buttons.php' ?>
          </div>
              <!-- MAIN TABLE -->
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
                     $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status=5";
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
                        ?>
                         <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                           <td class="col-sevcat" id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                           <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                           <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                           <td class="col-datecreated"> <?php echo $row['date_prepared']?>  </td>
                           <td class="col-remarks"> <?php echo $row['remarks'] ?>       </td>
                         </tr>
                       <?php } ?>
                       </tbody>
                </table>
                 </tbody>
                </table>

              <?php } ?>
            </div>
          </div>
          <?php include 'templates/ticketforms.php'; ?>
        </div>
        <?php include 'templates/mobile-ticket-buttons.php' ?>
        <?php include 'templates/js_resources.php' ?>
      </body>
    </html>
