<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: index.php');
  }
?>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.eei.com.ph/img/favicon.ico" />
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
        <span class="table-title">My Tickets</span>
        <div class="count">
          <!-- Badge Counter -->
          <?php
            $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t LEFT JOIN user_t r ON t.user_id = r.user_id LEFT JOIN sla_t sev ON sev.id = t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE t.user_id = '".$_SESSION['user_id']."'";
            $result = mysqli_query($db,$query); ?>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
              <span class="badge main-count"> <?php echo $row['count'] . " tickets" ?></span>
            <?php } ?>
        </div>
        <div class="col s12" id="breadcrumb">
          <a href="#!" class="breadcrumb">My Tickets</a>
          <a href="#!" class="breadcrumb">All My Tickets</a>
        </div>
      </div>
      <div class="material-table" id="my-tickets">

        <div class="actions">

            <!-- Button for Removing Filter -->
            <a href="my-tickets.php" class="waves-effect btn-sort">Clear <i id="removefilter" class="material-icons">remove_circle</i></a>

            <!-- Dropdown Trigger for Category Sorter -->
            <a class="dropdown-button btn-sort" data-activates="categories" data-beloworigin="true">Category<i id="sort" class="material-icons">arrow_drop_down</i></a>
            <!-- Dropdown Structure -->
            <ul id="categories" class="dropdown-content collection">
              <li><a href="?view=technicals" class="technicals">Technicals</a></li>
              <li><a href="?view=access" class="accesstickets">Access</a></li>
              <li><a href="?view=network" class="network">Network</a></li>
            </ul>

            <!-- Dropdown Trigger for Severity Sorter -->
            <a class="dropdown-button btn-sort" data-activates="sevlevels" data-beloworigin="true">Severity<i id="sort" class="material-icons">arrow_drop_down</i></a>
            <!-- Dropdown Structure -->
            <ul id="sevlevels" class="dropdown-content collection">
              <li><a href="?view=sev1">SEV1</a></li>
              <li><a href="?view=sev2">SEV2</a></li>
              <li><a href="?view=sev3">SEV3</a></li>
              <li><a href="?view=sev4">SEV4</a></li>
              <li><a href="?view=sev5">SEV5</a></li>
            </ul>
            <a class="btn-search search-toggle"><span id="search"><i class="material-icons search">search</i></span>Search Here</a>
            <a class="btn-mobile-search search-toggle"><i class="material-icons search">search</i></a>

        </div>
        <table id="datatable" class="striped">
          <thead>
            <tr>
              <th class="col-sevcat"></th>
              <th class="col-ticketno">Ticket #</th>
              <th class="col-status">Status</th>
              <th class="col-title">Title</th>
              <th class="col-hidedatecreated">Date Created</th>
              <th class="col-remarks">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <!-- SORTER -->
            <?php
              $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.user_id = '".$_SESSION['user_id']."'";
              //no sorter yet
              include 'templates/my-tickets-sorter.php';

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
                  } ?>
                  <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                      <td class="col-sevcat" id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:27px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                      <td class="col-ticketno"> <?php echo $row['ticket_number']?>  </td>
                      <td class="col-status"><?php echo $row['ticket_status']?>  </td>
                      <td class="col-title"> <?php echo $row['ticket_title']?>   </td>
                      <td class="col-hidedatecreated"> <?php echo $row['date_prepared']?>  </td>
                      <td class="col-remarks"> <?php echo $row['remarks'] ?>       </td>
                  </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- HIDDEN FORMS -->
    <?php include 'templates/ticketforms.php'; ?>
  </div>
  <?php include 'templates/mobile-ticket-buttons.php' ?>
  <?php include 'templates/js_resources.php' ?>
</body>
</html>
