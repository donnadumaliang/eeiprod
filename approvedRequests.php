<?php
  include "templates/dbconfig.php";
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: index.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.eei.com.ph/img/favicon.ico" />
  <title>EEI Service Desk</title>
  <?php include 'templates/css_resources.php' ?>
</head>
  <body>
    <?php include 'templates/navheader.php'; ?>
    <?php include 'templates/sidenav.php'; ?>

    <!-- ****************************************************** -->

    <!--body-->
    <div class="col s12 m12 l12" id="content">
      <div class="main-content">
        <div class="col s12 m12 l12 table-header">
          <span class="table-title">Approved Requests</span>
          <!-- Badge Counter -->
          <div class="count">
          <?php
            $id = $_SESSION['user_id'];
            $query = "SELECT COUNT(*) as count FROM ticket_t LEFT JOIN user_access_ticket_t USING (ticket_id)
                      WHERE (user_access_ticket_t.approver = $id AND user_access_ticket_t.isApproved = true)";
            $result = mysqli_query($db,$query);
            while($row = mysqli_fetch_assoc($result)) { ?>
              <span class="badge main-count"> <?php echo $row['count'] . " tickets" ?></span>
            <?php } ?>
          </div>
          <div class="col s12" id="breadcrumb">
            <a href="#!" class="breadcrumb">Tickets for Review</a>
            <a href="#!" class="breadcrumb">Approved Tickets</a>
          </div>
        </div>
            <div class="material-table">
              <div class="actions">
                <div class="sorter">
                  <a href="#!" class="waves-effect btn-sort">Remove Filter <i id="removefilter" class="material-icons">remove_circle</i></a>
                  <!-- Dropdown Trigger for New Ticket -->
                  <a class="dropdown-button btn-sort" data-activates="dropdown3" data-beloworigin="true">Category<i id="sort" class="material-icons">arrow_drop_down</i></a>
                  <!-- Dropdown Structure -->
                  <ul id="dropdown3" class="dropdown-content collection">
                      <li><a href="?view=technicals" class="technicals">Technicals</a></li>
                      <li><a href="?view=access" class="accesstickets">Access</a></li>
                      <li><a href="?view=network" class="network">Network</a></li>
                  </ul>
                  <!-- Dropdown Trigger for New Ticket -->
                    <a class="dropdown-button btn-sort" data-activates="dropdown4" data-beloworigin="true">Severity<i id="sort" class="material-icons">arrow_drop_down</i></a>
                  <!-- Dropdown Structure -->
                  <ul id="dropdown4" class="dropdown-content collection">
                      <li><a href="?view=sev1">SEV1</a></li>
                      <li><a href="?view=sev2">SEV2</a></li>
                      <li><a href="?view=sev3">SEV3</a></li>
                      <li><a href="?view=sev4">SEV4</a></li>
                      <li><a href="?view=sev5">SEV5</a></li>
                  </ul>
                  <a class="btn-search search-toggle"><span id="search"><i class="material-icons search">search</i></span>Search Here</a>
                </div>
              </div>

              <table id="datatable" class="striped">
                  <thead>
                    <tr>
                      <th class="col-sevcat"></th>
                      <th class="col-hideticketno">Ticket No.</th>
                      <th class="col-status">Status</th>
                      <th class="col-title">Title</th>
                      <th class="col-deptproj">Department/Project</th>
                      <th class="col-accessrequest">Access Requested</th>
                      <th class="col-datecreated">Date Created</th>
                    </tr>
                  </thead>
                  <?php
                  $id = $_SESSION['user_id'];
                  $query = "SELECT * FROM ticket_t LEFT JOIN user_access_ticket_t USING (ticket_id)
                            LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE (user_access_ticket_t.approver = $id AND user_access_ticket_t.isApproved = true)";

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

                     <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                       <td class="col-sevcat" id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                       <td class="col-hideticketno"> <?php echo $row['ticket_number']?>  </td>
                       <td class="col-status"> <?php echo $row['ticket_status']?>  </td>
                       <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                       <td class="col-hidedeptproj"> <?php echo $row['dept_proj'] ?>       </td>
                       <td class="col-hideaccessrequest"> <?php echo $row['access_request'] ?>       </td>
                       <td class="col-datecreated"> <?php echo $row['date_prepared']?>  </td>
                     </tr>
                      <?php
                    }?>
            </tbody>
          </table>
        </div>
      </div>

      <?php include 'templates/ticketforms.php'; ?>

    </div> <!-- End of main container of col 10 -->
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php' ?>

    </body>
</html>
