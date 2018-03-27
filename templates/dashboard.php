<div class="col s12 m12 l12 table-header">
  <span class="table-title"><?php echo date('F')?> Performance Dashboard</span>
    <a id="addfaq" href="#modal-export" class="modal-trigger btn"><i class="material-icons">file_download</i>&nbsp;&nbsp;Export to Excel</a>
</div>

<div id="modal-export" class="modal">
<form method='post' action = "php_processes/export.php"name="export" id="export">
  <div class="modal-content">
    <h5>Choose Export Details</h5>
      <div class="input-field " id="request-form">
        <input type="date" name="startdate" required>
        <label for="title">Start Date</label>
      </div>
      <div class="input-field " id="request-form">
        <input type="date" name="enddate" required>
        <label for="title">End Date</label>
      </div>
      </div>
    <div class="modal-footer">
      <input class="modal-action modal-close" id="cancel" name="submit" type="submit" value="Cancel">
      <input id="return" name="submit" type="submit" value="Create">
      <!-- <button class="btn modal-close" id="" type="submit" name="submit">Create</button> -->
      <!-- <a href="home.php" class="btn modal-action modal-close">Close</a> -->
    </div>
</form>
</div>

<div id="dashboard-main">
  <div class="row">
    <div class="col s12 m12 l12">
      <div class="row" id="kb">
        <h6 id="dashboard">SLA Ticket Summary</h6>
          <div class="col s12 m12 l8">
            <div class="row" id="sev">
              <?php
              $query = "SELECT s.severity_level, count(t.ticket_id) as count, s.description FROM ticket_t t RIGHT JOIN sla_t s ON (t.severity_level=s.id) group by s.id";
              $result = mysqli_query($db,$query);
              while($row = mysqli_fetch_assoc($result)){
                $sev = $row['severity_level'];
                switch($sev)
                {
                    case("SEV1"):
                        $class = 'sev1';
                        break;

                   case("SEV2"):
                       $class = 'sev2';
                       break;

                   case("SEV3"):
                       $class = 'sev3';
                       break;

                   case("SEV4"):
                       $class = 'sev4';
                       break;

                   case("SEV5"):
                       $class = 'sev5';
                       break;

                  case("Unassigned"):
                      $class = 'Unassigned';
                      $sev = 'NULL';
                      break;
                }
                $total = "SELECT COUNT(*) as notclosed, (SELECT COUNT(*) FROM ticket_t k LEFT JOIN sla_t s ON s.id = k.severity_level WHERE s.severity_level= '$sev' AND MONTH(date_prepared)=MONTH(CURRENT_DATE())) as sevtotal FROM ticket_t t LEFT JOIN sla_t s ON s.id=t.severity_level WHERE MONTH(date_prepared)=MONTH(CURRENT_DATE()) AND s.severity_level = '$sev' AND t.ticket_status >= 5 AND t.ticket_status < 8";
                $result2 = mysqli_query($db,$total);
                while($row2 = mysqli_fetch_assoc($result2)){
                ?>
                  <div class="col s6 m6 l4">
                    <div class="card horizontal">
                      <div class="card-stacked">
                        <div class="card-content">
                          <div class="col s7 m5">
                            <p class='<?php echo $class?>' id="sev"><?php echo $row['severity_level']?></p>
                            <p id='sevlevel' class='no-margin'> <?php echo $row['description']  ?> </p>
                          </div>
                          <div class="col s5 m7 right-align">
                           <?php echo "<span id='sup'><sup>" .  $row2['notclosed'] . "</sup><span id='over'>/</span></span><span id='sub'><sub>" . $row2['sevtotal'] . " </sub></span>" .
                           "<p class='no-margin' id='fraction-label'>tickets open</p>"; ?>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }}; ?>

                <div class="col s6 m6 l4">
                  <div class="card horizontal">
                    <div class="card-stacked">
                      <div class="card-content">
                        <div class="col s7 m5">
                          <p class='unassigned' id="sev">Unassigned</p>
                          <p id='sevlevel' class='no-margin'>For review </p>
                        </div>
                        <?php $totalunassigned = "SELECT COUNT(*) as unassigned, (SELECT COUNT(*) FROM ticket_t t WHERE t.ticket_status >= 5 and t.ticket_status <=8) as totaltickets FROM ticket_t t WHERE t.severity_level IS NULL AND t.ticket_status >= 5 and t.ticket_status <=8";
                        $result2 = mysqli_query($db,$totalunassigned);
                        while($row2 = mysqli_fetch_assoc($result2)){ ?>

                        <div class="col s5 m7 right-align">
                         <?php echo "<span id='sup'><sup>" .  $row2['unassigned'] . "</sup><span id='over'>/</span></span><span id='sub'><sub>" . $row2['totaltickets'] . " </sub></span>" .
                         "<p class='no-margin' id='fraction-label'>Unassigned Left</p>"; }?>
                         </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="chart">
              <div class="col s12 m12 l11" id="chart">
                <h6 id="dashboard">Ticket Count Per Month</h6>
                <canvas id="mycanvas"></canvas>
              </div>
            </div>
          </div>
          <div class="col s12 m12 l4">
            <div class="col s12 m12 l12">
              <div class="card horizontal gradient-45deg-green-teal tooltipped" data-position="left" data-delay="50" data-tooltip="Percentage of tickets resolved/closed within SLA">
                <div class="card-stacked">
                <div class="card-content">
                  <div class="col s7 m7 left-align">
                    <i class="material-icons background-round mt-5">show_chart</i>
                  </div>
                  <div class="col s5 m5 right-align white-text">
                    <?php
                    //percentage of tickets resolved following their severity level

                    $query = "SELECT ROUND((SELECT COUNT(*) FROM ticket_t t WHERE t.date_required > t.resolution_date AND (t.ticket_status = 7 OR t.ticket_status = 8) AND MONTH(t.date_prepared)=MONTH(CURRENT_DATE()))/(SELECT COUNT(*) FROM ticket_t t WHERE t.ticket_status = 7 OR t.ticket_status = 8 AND MONTH(t.date_prepared)=MONTH(CURRENT_DATE())),2)*100 as sla_percentage";

                    $result = mysqli_query($db,$query);
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<h5 id='dashboard'>" .  $row['sla_percentage'] . "%</h5>" .
                         "<p class='dashboard no-margin'>SLA Performance</p>";
                     }; ?>
                 </div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col s12 m12 l4">
            <div class="col s12 m12 l12">
              <div class="card horizontal gradient-45deg-amber-amber">
                <div class="card-stacked">
                <div class="card-content">
                  <div class="col s7 m7 left-align">
                    <i class="material-icons background-round mt-5">report</i>
                  </div>
                  <div class="col s5 m5 right-align white-text">
                    <?php
                      $query = "SELECT COUNT(*) as count FROM ticket_t WHERE date_required < now() AND MONTH(date_prepared)=MONTH(CURRENT_DATE())";
                      $result = mysqli_query($db,$query);

                      while($row = mysqli_fetch_assoc($result)){
                         echo "<h4 id='dashboard'>" . $row['count'] . "</h4>" .
                         "<p class='dashboard no-margin'>" . "Overdue" . "</p>";
                     };
                    ?>
                 </div>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12 m12 l4">
            <div class="col s6 m6 l6">
              <div class="card horizontal gradient-45deg-light-blue-cyan">
                <div class="card-stacked">
                <div class="card-content">
                  <div class="col s7 m7 left-align">
                    <i class="material-icons background-round mt-5">lock_open</i>
                  </div>
                  <div class="col s5 m5 right-align white-text">
                    <?php
                      $query = "SELECT COUNT(*) AS count FROM ticket_t WHERE MONTH(date_prepared)=MONTH(CURRENT_DATE()) AND ticket_status < 8 and ticket_status >= 5";
                      $result = mysqli_query($db,$query);

                      while($row = mysqli_fetch_assoc($result)){
                         echo "<h4 id ='dashboard'>" . $row['count'] . "</h4>" .
                         "<p class='dashboard no-margin'>" . "Open" . "</p>";
                     };
                    ?>
                 </div>
                </div>
              </div>
              </div>
            </div>
            <div class="card horizontal gradient-45deg-light-blue-cyan">
              <div class="card-stacked">
              <div class="card-content">
                <div class="col s7 m7 left-align">
                  <i class="material-icons background-round mt-5">lock_outline</i>
                </div>
                <div class="col s5 m5 right-align white-text">
                  <?php
                    $query = "SELECT COUNT(*) AS count FROM ticket_t WHERE MONTH(date_prepared)=MONTH(CURRENT_DATE()) AND ticket_status = 8";
                    $result = mysqli_query($db,$query);

                    while($row = mysqli_fetch_assoc($result)){
                       echo "<h4 id='dashboard'>" . $row['count'] . "</h4>" .
                       "<p class='dashboard no-margin'>" . "Closed" . "</p>";
                   };
                  ?>
                </div></div>
              </div>
            </div>
            <div class="margin-top-dashboard">
            <ul id="projects-collection" class="collection z-depth-1">
              <li class="collection-item avatar">
                <i class="material-icons cyan circle">insert_chart</i>
                <h6 class="collection-header m-0">Ticket Category</h6>
                <p>Total Count for <?php echo date('F')?></p>
              </li>
            <?php
            $db = mysqli_connect("localhost", "root", "", "eei_db");

              $query = "SELECT ticket_category, count(ticket_id) as count FROM ticket_t WHERE ticket_category IS NOT NULL group by ticket_category UNION SELECT 'N/A', count(ticket_id) FROM ticket_t WHERE ticket_category IS NULL AND MONTH(date_prepared)=MONTH(CURRENT_DATE())";
              $result = mysqli_query($db,$query);

              while($row = mysqli_fetch_assoc($result)){
                switch($row['ticket_category'])
                {
                    case("Technicals"):
                      $icon = 'storage';
                      $class = 'tech';
                      break;

                    case("Access"):
                      $icon = 'vpn_lock';
                      $class = 'accesst';
                      break;

                    case("Network"):
                      $icon = 'network_check';
                      $class = 'network';
                      break;

                    case("N/A"):
                      $icon = '';
                      $class = 'unassigned';
                      break;
                }
             ?>
              <div class="col s12 m12 l12" id="<?php echo $class ?>">
                <li class="collection-item" id="<?php echo $class ?>">
                  <div class="row" style="margin-bottom:0px">
                    <div class="col s3">
                      <p class='<?php echo $class?> no-margin' id="sev"><i class="material-icons"><?php echo $icon?></i></p>
                    </div>
                    <div class="col s5">
                      <p class='no-margin'> <?php echo $row['ticket_category'] ?> </p>
                    </div>
                    <div class="col s3">
                      <p class='no-margin'><?php echo  $row['count'] ?> tickets </p>
                    </div>
                  </div>
                </li>
              </div>
            <?php } ?>
          </ul>
          </div>
      </div>
    </div>
  </div>
</div>
