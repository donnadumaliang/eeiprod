<?php
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
        <div class="col s12 m12 l12" id="content">
          <div class="main-content">
            <div class="preloader-background">
              <div class="activity">
                <h6>Sending e-mail to approver...</h6>
                <p>This may take a few seconds</p>
              </div>
              <div class="progress">
               <div class="indeterminate">
               </div>
             </div>
            </div>
            <div class="col s12 m12 l12 table-header">
              <?php
              $db = mysqli_connect("localhost", "root", "", "eei_db");


                $query2 = "SELECT * FROM ticket_t t INNER JOIN user_t r  on (t.user_id=r.user_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE t.ticket_id = '".$_GET['id']."'";
                  $result2= mysqli_query($db,$query2);
                    while($row = mysqli_fetch_assoc($result2)){
                      $id = $_SESSION['user_id'];
                      $ticketID =$_GET['id'];?>

                      <span class="table-title"><a class="back" href="javascript:history.back()"><i class="material-icons" id="back">keyboard_arrow_left</i></a>Ticket #<?php echo $row['ticket_number'] ?></span>


                <!-- Div for All Action Buttons -->
                <span class="row" id="ticket-actions">
                  <?php if($row['ticket_status'] != 8 AND $row['user_id'] == $_SESSION['user_id']){?>
                    <form>
                    <input id="attach" type="submit" class="modal-trigger" href="#attachfile" value="Attach File" />
                    </form
                  <?php }?>

                  <!-- Confirm Resolution for Requestor  -->
                  <?php if ($row['user_id']== $_SESSION['user_id']){
                    if ($row['ticket_status']==7 and $row['user_id'] == $_SESSION['user_id']) { ?>
                       <form id="confirm" name="confirm" method="post">
                        <a href="#modal-reject" class="modal-trigger"><input id="reject" type="submit"  value="Reject"></input></a>
                         <input id="confirm" type="submit"  value="Confirm">
                         <input  id="confirm" name ="ticketID" type="hidden" value="<?php echo $ticketID?>">
                       </form>
                       <div id="modal-reject" class="modal">
                       <form method='post' name="reject-resolution" id="reject-resolution">
                         <div class="modal-content">
                           <h5>Reject Ticket</h5>
                             <div class="input-field " id="request-form-row6">
                               <input placeholder=" " type="text" name="reason">
                                 <label for="title">Reason:</label>
                             </div>
                             <input  id="confirm" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">

                             </div>
                           <div class="modal-footer">
                             <a  class="btn modal-action modal-close">Close</a>
                             <button class="btn" id="return" type="submit" name="submit">Reject</button>
                           </div>
                       </form>
                       </div>
                   <?php }} ?>

                  <!-- Cancel Button for Admin -->
                   <?php if ($_SESSION['user_type']=="Administrator" AND $row['ticket_status'] == 5) {?>
                     <form id="cancel" name="cancel" method="post">
                       <input id="cancel" type="submit" value="Cancel">
                       <input  id="cancel" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                     </form>
                   <?php }?>

                   <!-- Return Button for Ticket Agents -->
                   <?php if (($row['ticket_status'] < 7) AND ($_SESSION['user_type']=="Technician" OR $_SESSION['user_type']=="Network Engineer") AND (($id != $row['checker'] AND $row['isChecked'] != NULL) OR ($id != $row['approver'] AND $row['isApproved'] != NULL))) {?>
                       <input id="return" type="submit" class="modal-trigger" href="#returnsupervisor" value="Return to Supervisor" />
                   <?php  }?>

                   <!-- Return Button for Group Managers -->
                   <?php if (($row['ticket_status'] < 7) AND ($_SESSION['user_type']=="Access Group Manager" OR $_SESSION['user_type']=="Technicals Group Manager" OR $_SESSION['user_type']=="Network Group Manager") AND ($row['ticket_type'] == "Service" OR ($id != $row['checker'] AND $row['ticket_type'] =="User Access" AND $row['isChecked'] != NULL) OR ($row['ticket_type'] =="User Access" AND $id != $row['approver'] AND $row['isApproved'] != NULL))) { ?>
                       <input id="return" type="submit" class="modal-trigger" href="#returnadmin" value="Return Ticket" />
                   <?php  }?>


                  <!-- Approve, Check and Reject Button for Approver/Checker  -->
                  <div class="approve-reject">
                     <?php if ($row['approver']==$id  && $row['isApproved'] != 1) { ?>
                         <form id="approve" name="approve" method="post">
                           <input id="approve" type="submit" value="Approve">
                           <input  id="approve" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                         </form>

                         <form id="reject" name="reject" method="post">
                           <a href="#modal-reject-ticket" class="modal-trigger"><input id="reject" type="submit"  value="Reject"></input></a>
                           <input  id="reject" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                         </form>
                      <?php }
                       elseif ($row['checker']==$_SESSION['user_id'] && $row['isChecked']!=1) { ?>
                        <form id="check" name="check" method="post">
                          <input id="check" type="submit" value="Check">
                          <input id="check" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                        </form>
                        <form id="reject" name="reject" method="post">
                          <a href="#modal-reject-ticket" class="modal-trigger"><input id="reject" type="submit"  value="Reject"></input></a>
                          <input  id="reject" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                        </form>
                    <?php }} ?>
                      <div id="modal-reject-ticket" class="modal">
                      <form method='post' name="reject-ticket" id="reject-ticket">
                        <div class="modal-content">
                          <h5>Reject Ticket</h5>
                            <div class="input-field " id="request-form-row6">
                              <input placeholder=" " type="text" name="reason">
                                <label for="title">Reason:</label>
                            </div>
                            <input  id="confirm" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">

                            </div>
                          <div class="modal-footer">
                            <a  class="btn modal-action modal-close">Close</a>
                            <button class="btn" id="return" type="submit" name="submit">Reject</button>
                          </div>
                      </form>
                      </div>
                   </div>

                  <!-- RETURN TICKET MODAL -->
                  <div id="returnsupervisor" class="modal">
                    <div class="modal-content">
                      <h5>Return Ticket to Supervisor</h5>
                        <form id="return-supervisor" name="return-ticket" method="post">
                          <label for="return_reason">Reason for Returning</label>
                          <input type="text" name="return_reason" required/><br><br>
                    </div>
                    <div class="modal-footer">
                      <input class="modal-action modal-close" id="cancel" name="submit" type="submit" value="Cancel">
                      <input id="return" name="submit" type="submit" value="Return Ticket">
                      <input value = "<?php echo $_GET['id']?>" name="id" type="hidden">
                    </div>
                    </form>
                  </div>

                  <!-- RETURN TICKET MODAL -->
                  <div id="returnadmin" class="modal">
                    <div class="modal-content">
                      <h5>Return Ticket to IT Service Desk Agent</h5>
                        <form id="return-admin" name="return-ticket" method="post">
                          <label for="return_reason">Reason for Returning</label>
                          <input type="text" name="return_reason" required/><br><br>
                    </div>
                    <div class="modal-footer">
                      <input class="modal-action modal-close" id="cancel" name="submit" type="submit" value="Cancel">
                      <input id="return" name="submit" type="submit" value="Return Ticket">
                      <input value = "<?php echo $_GET['id']?>" name="id" type="hidden">
                    </div>
                    </form>
                  </div>

                  <!-- ATTACH FILE MODAL -->
                   <div id="attachfile" class="modal">
                     <div class="modal-content">
                       <h5>Attach File to Ticket</h5>
                       <form method='post' name="attach" id="attach" enctype="multipart/form-data">
                       <label for="description_entered">Description of File:</label>
                       <input type="text" name="description_entered"/><br><br>
                       <!-- <input type="file" id="file" name="file"/> -->
                       <div class="file-field input-field">
                       <div class="btn-attach">
                         <span>SELECT File</span>
                         <input type="file" id="file" name="file"/>
                       </div>
                       <div class="file-path-wrapper">
                         <input class="file-path validate" type="text">
                       </div>
                      </div>
                      <!-- PHP PROCESS OF ATTACH -->
                      <?php
                        include "templates/dbconfig.php";
                        if(isset($_POST['submit'])){
                        $name= $_FILES['file']['name'];
                        $desc = $_POST['description_entered'];
                        $tmp_name= $_FILES['file']['tmp_name'];
                        $file = 'uploads/' .$_FILES['file']['name'];
                        $upload = move_uploaded_file($tmp_name, $file);
                        $uploader = $_SESSION['user_id'];
                        if($upload){
                          $add = $db->prepare("INSERT INTO attachment_t VALUES('',?,'$uploader','$ticketID','$desc')");
                          $add->bindParam(1,$name);
                          if($add->execute()){
                          }
                        } ?>
                        <script>window.location='details.php?id=<?php echo $ticketID?>'</script><?php };?>
                      </div>
                      <div class="modal-footer">
                       <input class="btn-upload" type="submit" name="submit" value="Upload"/>
                       <input class="btn-cancel modal-action modal-close" type="submit" name="submit"  value="Cancel" />
                       </form>
                     </div>
                   </div>
               </span>
            </div>
            <!-- End div for table header div -->

            <div class="col s12 m12 l12">
              <div class="row" id="ticket-details">
                <div class="col s12 m12 l7">
                  <div class="card-panel">
                    <span class="black-text">
                      <?php
                        $db = mysqli_connect("localhost", "root", "", "eei_db");

                        $query = "SELECT t.ticket_type, t.ticket_title, s.request_details, t.auto_close_date,r.email_address as email, DATE_FORMAT(date_prepared, '%W %b %e %Y %r') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor FROM ticket_t t INNER JOIN user_t r  on (t.user_id=r.user_id) left join service_ticket_t s on (s.ticket_id=t.ticket_id) WHERE s.ticket_id = '".$_GET['id']."'";

                        $query2 = "SELECT *, r.email_address as email, DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN user_t r  on (t.user_id=r.user_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE u.ticket_id = '".$_GET['id']."'";

                        $result = mysqli_query($db,$query);
                        $result2 = mysqli_query($db,$query2);

                        while($row = mysqli_fetch_assoc($result)){
                            $email = $row['email'];
                           echo "<h5><b>" . $row['ticket_title'] . "</h5></b>" .
                                "<p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket tooltipped\" data-position=\"right\" data-delay=\"50\" data-tooltip=\"$email\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                                "<p id=\"details\">" . $row['request_details'] . "</p>";

                              $dt = new DateTime(date('Y-m-d H:i:s'));
                              $curDate = $dt->format('Y-m-d H:i:s');
                              if ($row['auto_close_date']<=$curDate && $row['ticket_status'] = 7 && !($row['auto_close_date']== NULL)) {
                                $closeTicket = "UPDATE ticket_t SET ticket_status = '8' WHERE ticket_id='".$_GET['id']."'";
                                if (!mysqli_query($db, $closeTicket))
                                {
                                  die('Error' . mysqli_error($db));
                                }
                              }
                            };   ?>
                         <!-- need this to stop warning if service ticket-->

                          <table id="access-details">
                            <tbody id="details">
                              <?php
                              while($row = mysqli_fetch_assoc($result2)){
                              $email = $row['email'];
                               echo "<h5><b>" . $row['ticket_title'] . "</h5></b>" .
                               "<p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket tooltipped\" data-position=\"right\" data-delay=\"50\" data-tooltip=\"$email\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                                   "<tr><td>" . "R.C. Number:" . "</td><td>"  .  $row['rc_no'] . "</td>" .
                                    "<tr><td>" . "Company:" . "</td><td>"  .  $row['company'] . "</td>" .
                                    "<tr><td>" . "Department/Project:" . "</td><td>"  .  $row['dept_proj'] . "</td>" ; } ?>
                            <?php
                            $query0 = "SELECT ticket_type FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";
                            $row0=mysqli_fetch_array(mysqli_query($db, $query0),MYSQLI_ASSOC);
                            if($row0['ticket_type'] != "Service") {?>
                             <table id="access-details2">
                               <tbody id="details">
                                 <th>Name</th>
                                 <th>Application Type</th>
                                 <th>Application</th>
                                 <?php
                                 $query1 = "SELECT * FROM request_details_t WHERE ticket_id = '".$_GET['id']."'";
                                 $result = mysqli_query($db,$query1);
                                 while($row = mysqli_fetch_assoc($result)){
                                    echo  "<tr><td>". $row['name'] . "</td>" .
                                       "<td>". $row['request_type'] . "</td>" .
                                       "<td>". $row['application_name'] ."</td> </tr>";
                                 }?>
                               </tbody>
                             </table>
                           <?php } ?>
                           </tbody>
                         </table>
                 </div>
                <br>
                   <div id="container">
                     <h6>Activity Logs</h6>
                      <div id="comment_logs" class="alog">
                        <?php
                        $db = mysqli_connect("localhost", "root", "", "eei_db");

                        $result = mysqli_query($db, "SELECT a.activity_log_details, DATE_FORMAT(a.timestamp, '%b %e %Y %r') as timestamp, a.logger, a.activity_log_id, CONCAT(r.first_name, ' ', r.last_name) AS user, t.ticket_id FROM activity_log_t a LEFT JOIN ticket_t t ON a.ticket_id = t.ticket_id LEFT JOIN user_t r ON r.user_id = a.logger WHERE t.ticket_id = '".$_GET['id']."' ORDER BY a.activity_log_id DESC");
                        $row_cnt = mysqli_num_rows($result);
                        if($row_cnt > 0){
                          while($row=mysqli_fetch_array($result)){
                              echo "<div class='card panel comments_content'>";
                              echo "<div id=\"logs\">" .
                              "<div class=\"user\">" . $row['user'] . "</div>" .
                              "<div class=\"date_posted\">" . $row['timestamp'] . "</div>" .
                              "<div class=\"details\">" .  $row['activity_log_details'] . "</div>" .
                              "</div></div>";
                          }}
                          else { echo "There are no activity logs for this ticket.";};
                        ?>
                      </div>
                      <div class="comment_input">
                          <div class="row">
                            <form id="activity_log" method="POST">
                              <div class="row">
                               <div class="input-field col s12">
                                <input type="text" id="activity_log" name="comments" class="materialize-textarea" required>
                                <label for="activity_log">Log activity here</label>
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");


                                  $query2 = "SELECT COUNT(*) as count, ticket_id FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";

                                  $result2= mysqli_query($db,$query2);

                                  while($row = mysqli_fetch_assoc($result2)){
                                    // $logger = $_SESSION['user_id'];

                                    $ticketID = $row['ticket_id'];
                                  }
                                 ?>
                                 <div class="tprop"><input id="submit" class="waves-effect waves-light save" type="submit" name="submit" onclick="php_processes/activitylog_process.php'" value="Post" />
                                 <input id="post" name = "ticketID" type="hidden" value="<?php echo $ticketID?>"></div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                    </div>


       </div>

                <div class="col s12 m12 l5">
                  <?php if($_SESSION['user_type'] != 'Requestor'){
                    $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $tagent = mysqli_query($db, "SELECT * FROM ticket_t WHERE ticket_id = $ticketID");

                    if ($result = mysqli_fetch_array($tagent)){
                      if($result['ticket_agent_id'] == NULL){
                    ?>
                  <?php if($_SESSION['user_type'] == 'Technicals Group Manager' AND $result['ticket_status'] == 5){ ?>
                    <div class="card-panel" id="ticket-properties">
                    <form id="assignee" name="properties" method="post">
                      <span id="panelheader"> Assign to Ticket Agent</h6></span>
                      <div class="tprop">
                        <input class="waves-effect waves-light save" id="submit" name="submit" type="submit" value="Save">
                        <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                        <?php
                        $db = mysqli_connect("localhost", "root", "", "eei_db");

                        $query6 = "SELECT ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";
                        $result= mysqli_query($db,$query6);
                        while($row = mysqli_fetch_assoc($result)){
                          // $logger = $_SESSION['user_id'];
                          $ticketID = $row['ticket_number'];
                        }
                          ?>
                      </div>
                      <div id="properties" class="row " id="request-form-row">
                        <div class="col s12 m12 l12 properties-box" id="properties-box">
                          <div class="input-field ticket-properties" id="request-form">

                              <select name = "assignee" required >
                              <option value="">Select</option>
                                <?php
                                  $result = mysqli_query($db, "SELECT user_id, CONCAT(first_name, ' ', last_name) AS technician FROM user_t WHERE user_type = 'Technician'");

                                  while ($row = mysqli_fetch_array($result))
                                    {?>

                                        <option value='<?php echo $row['user_id']?>'> <?php echo $row['technician'] ?></option>;
                                        <?php
                                    } ?>
                                    </select>
                              <label for="title">Select Technician:</label>
                          </div>
                      </div>
                    </div>
                  </div>
                  </form>
                <?php } ?>
              <?php if($_SESSION['user_type'] == 'Network Group Manager'){ ?>
                <div class="card-panel" id="ticket-properties">
                <form id="assignee" name="properties" method="post">
                  <span id="panelheader"> Assign to Ticket Agent</h6></span>
                  <div class="tprop">
                    <input class="waves-effect waves-light save" id="submit" name="submit" type="submit" value="Save">
                    <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");


                    $query6 = "SELECT ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";

                    $result= mysqli_query($db,$query6);

                    while($row = mysqli_fetch_assoc($result)){
                      // $logger = $_SESSION['user_id'];

                      $ticketID = $row['ticket_number'];
                    }

                      ?>

                      <input id="post" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">


                  </div>

                  <div id="properties" class="row " id="request-form-row">
                    <div class="col s12 m12 l12 properties-box" id="properties-box">
                      <div class="input-field ticket-properties" id="request-form">
                        <?php
                          $db = mysqli_connect("localhost", "root", "", "eei_db");

                          ?>

                          <select name = "assignee" required >
                          <option value="">Select</option>
                            <?php
                              $result = mysqli_query($db, "SELECT user_id, CONCAT(first_name, ' ', last_name) AS nengineer FROM user_t WHERE user_type = 'Network Engineer'");

                              while ($row = mysqli_fetch_array($result))
                                {?>
                                    <option value='<?php echo $row['user_id']?>'> <?php echo $row['nengineer'] ?></option>;
                                    <?php
                                } ?>

                                </select>
                          <label for="title">Select Network Engineer:</label>
                      </div>
                  </div>
                </div>
              </div>
            </form>
          <?php }}

        else { ?>

          <div id="reassign">
            <?php if($_SESSION['user_type'] == 'Technicals Group Manager' OR $_SESSION['user_type'] == 'Technician'){ ?>
              <div class="card-panel" id="ticket-properties">
              <form id="assignee" name="properties" method="post">
                <span id="panelheader"> Assign to Ticket Agent</h6></span>
                <div class="tprop">
                  <input class="waves-effect waves-light save" id="request-form-row" name="submit" type="submit" value="Save">
                  <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>

                  <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");


                  $query6 = "SELECT ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";

                  $result= mysqli_query($db,$query6);

                  while($row = mysqli_fetch_assoc($result)){
                    // $logger = $_SESSION['user_id'];

                    $ticketID = $row['ticket_number'];
                  }

                    ?>

                    <input id="post" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                </div>
                <div id="properties" class="row " id="request-form-row">
                  <div class="col s12 m12 l12 properties-box" id="properties-box">
                    <div class="input-field ticket-properties" id="request-form">

                        <select name = "assignee" required >
                        <option value="">Select</option>
                          <?php
                            $result = mysqli_query($db, "SELECT user_id, CONCAT(first_name, ' ', last_name) AS technician FROM user_t WHERE user_type = 'Technician'");

                            while ($row = mysqli_fetch_array($result))
                              {?>

                                  <option value='<?php echo $row['user_id']?>'> <?php echo $row['technician'] ?></option>;
                                  <?php
                              } ?>
                              </select>
                        <label for="title">Select Technician:</label>
                    </div>
                </div>
              </div>
            </div>
            </form>
          <?php } ?>
        <?php if($_SESSION['user_type'] == 'Network Group Manager' OR $_SESSION['user_type'] == 'Network Engineer'){ ?>
          <div class="card-panel" id="ticket-properties">
          <form id="assignee" name="properties" method="post">
            <div class="tprop-header"><h6>Assign to Ticket Agent</h6></div>
            <div class="tprop">
              <input class="waves-effect waves-light save" id="request-form-row" name="submit" type="submit" value="Save">
              <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
              <?php
              $db = mysqli_connect("localhost", "root", "", "eei_db");


              $query6 = "SELECT ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";

              $result= mysqli_query($db,$query6);

              while($row = mysqli_fetch_assoc($result)){
                $ticketID = $row['ticket_number'];
              } ?>

                <input id="post" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
            </div>

            <div id="properties" class="row " id="request-form-row">
              <div class="col s12 m12 l12 properties-box" id="properties-box">
                <div class="input-field ticket-properties" id="request-form">
                  <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");

                    ?>

                    <select name = "assignee" required >
                    <option value="">Select</option>
                      <?php
                        $result = mysqli_query($db, "SELECT user_id, CONCAT(first_name, ' ', last_name) AS nengineer FROM user_t WHERE user_type = 'Network Engineer'");

                        while ($row = mysqli_fetch_array($result))
                          {?>
                              <option value='<?php echo $row['user_id']?>'> <?php echo $row['nengineer'] ?></option>;
                              <?php
                          } ?>

                          </select>
                    <label for="title">Select Network Engineer:</label>
                </div>
            </div>
          </div>
        </div>
      </form>
    <?php }?>
          </div>
        <?php }}}?>
                  <?php if($_SESSION['user_type'] == 'Administrator'){
                    $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $sevcat = mysqli_query($db, "SELECT severity_level, ticket_category FROM ticket_t WHERE ticket_id = '".$_GET['id']."'");

                    if ($result = mysqli_fetch_array($sevcat)){
                      if($result['severity_level'] === NULL){
                    ?>
                      <div class="card-panel" id="ticket-properties">
                        <span class="black-text">
                             <form id="properties" name="properties" method="post">
                               <span id="panelheader">Assign Ticket Properties</span>
                               <div id="card-header">
                               <input class="waves-effect waves-light save" id="submit" name="submit" type="submit" value="Save">
                               <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                             </div>
                        </span>
                               <div id="properties" class="row " id="request-form-row">
                                 <div class="col s12 m12 l12 properties-box" id="properties-box">
                                   <div class="col s12 m6 l6" id="assign">
                                     <div class="input-field ticket-properties" id="request-form">
                                       <?php
                                         $db = mysqli_connect("localhost", "root", "", "eei_db");
?>

                                         <select name = "category" required>
                                         <option disabled selected>Select</option>
                                         <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                         $row = mysqli_fetch_array($get_user_type);
                                         $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                         foreach($enumList as $value){?>
                                         <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                             <?php } ?>
                                         </select>
                                         <label for="title">Category</label>
                                     </div>
                                   </div>
                                   <div class="col s12 m6 l6" id="assign">
                                     <div class="input-field ticket-properties" id="request-form">
                                       <?php
                                         $db = mysqli_connect("localhost", "root", "", "eei_db");
?>
                                         <select name='severity'>
                                           <option disabled selected>Select</option>
                                         <?php
                                          $get_sevlvl = "SELECT * FROM sla_t";
                                          $result = mysqli_query($db, $get_sevlvl);
                                           while ($row = mysqli_fetch_assoc($result)) {
                                              ?>
                                              <option value="<?php echo $row['id']?>"> <?php echo $row['severity_level']?> </option>
                                           <?php }; ?>
                                          </select>
                                         <label for="title">Severity</label>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                           </form>
                        </span>
                     </div>
                   <?php }}} ?>

                  <div class="card-panel" id="right-card">
                    <span class="black-text">
                      <span id="panelheader">Ticket Properties</span>

                      <?php if($_SESSION['user_type'] != 'Requestor'){
                      $db = mysqli_connect("localhost", "root", "", "eei_db");

                      $sevcat = mysqli_query($db, "SELECT ticket_status, severity_level, ticket_category FROM ticket_t WHERE ticket_id = '".$_GET['id']."'");

                      if ($result = mysqli_fetch_array($sevcat)){
                        if($result['severity_level'] != NULL AND $result['ticket_status'] != 8){?>
                                                <!-- Modal Trigger -->
                      <a class="waves-effect waves-light modal-trigger" href="#modal1"><i id="edit" class="small material-icons">edit</i></a>
                    <?php }}} ?>
                      <!-- Modal Structure -->
                      <div id="modal1" class="modal modal-fixed-footer">
                        <div class="modal-content">
                          <h6>Edit Ticket Properties</h6>
                          <form id="edit-properties" name="edit-properties" method="post">
                            <div class="col s12 m12 l12 properties-box" id="properties-box">
                              <div class="input-field ticket-properties" id="request-form-row6">
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");
?>

                                  <?php $retrieve = mysqli_query($db, "SELECT * FROM ticket_t LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level WHERE ticket_id = '".$_GET['id']."'");
                                  $row = mysqli_fetch_array($retrieve);?>

                                  <select name = "status" required>
                                  <option value ="<?php echo $row['status_id']?>" selected ><?php echo $row['ticket_status']?></option>
                                  <?php
                                  if($_SESSION['user_type'] == 'Access Group Manager' || $_SESSION['user_type'] == 'Network Group Manager'){
                                    $get_stat = "SELECT * FROM ticket_status_t WHERE status_id >= 7 ";
                                  } elseif($_SESSION['user_type'] == 'Technicals Group Manager'){
                                    $get_stat = "SELECT * FROM ticket_status_t WHERE status_id = 7 ";
                                  } elseif ($_SESSION['user_type'] == 'Administrator'){
                                    $get_stat = "SELECT * FROM ticket_status_t WHERE status_id = 7 OR status_id = 9 ";
                                  } elseif($_SESSION['user_type'] == 'Technician' || $_SESSION['user_type'] == 'Network Engineer'){
                                    $get_stat = "SELECT * FROM ticket_status_t WHERE status_id = 7";
                                  }
                                    $result = mysqli_query($db, $get_stat);
                                    while ($row2 = mysqli_fetch_assoc($result)) {
                                      if ($row['status_id']!=$row2['status_id']) {?>
                                          <option value='<?php echo $row2['status_id']?>'> <?php echo $row2['ticket_status']?></option>
                                    <?php  } ?>

                                    <?php } ?>
                                    </select>

                                  <label for="title">Ticket Status</label>
                              </div>
                              <!-- FOR REQUIRED ACTIVITY LOG -->
                              <div class="input-field ticket-properties al" id="request-form-row6" style="display:none;">
                                <input type="text" id="al" name="al" placeholder="Required Field">
                                <label for="al" class="red-text">Activity Log</label>
                              </div>
                              <div class="input-field ticket-properties" id="request-form-row6">
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");
?>

                                  <?php $retrieve = mysqli_query($db, "SELECT ticket_status, ticket_category, severity_level FROM ticket_t WHERE ticket_id = '".$_GET['id']."'");
                                  $row = mysqli_fetch_array($retrieve);?>

                                  <select name = "category" required>
                                  <option value = "<?php echo $row['ticket_category']?>"  selected><?php echo $row['ticket_category']?></option>
                                  <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                  $row2 = mysqli_fetch_array($get_user_type);
                                  $enumList = explode(",", str_replace("'", "", substr($row2['column_type'], 5, (strlen($row2['column_type'])-6))));
                                  foreach($enumList as $value){
                                    if ($value != $row['ticket_category']) {?>
                                      <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                  <?php  }?>

                                      <?php } ?>
                                  </select>
                                  <label for="title">Ticket Category</label>
                              </div>
                              <div class="input-field ticket-properties" id="request-form-row6">
                                  <?php
                                    $db = mysqli_connect("localhost", "root", "", "eei_db");
?>

                                    <?php $retrieve = mysqli_query($db, "SELECT * FROM ticket_t LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level WHERE ticket_id = '".$_GET['id']."'");
                                    $row = mysqli_fetch_array($retrieve);?>

                                    <?php
                                      $db = mysqli_connect("localhost", "root", "", "eei_db");



                                      ?>
                                      <select name='severity'>
                                        <option value = "<?php echo $row['id']?>"  selected><?php echo $row['severity_level']?></option>
                                      <?php
                                       $get_sevlvl = "SELECT * FROM sla_t";
                                       $result = mysqli_query($db, $get_sevlvl);
                                        while ($row2 = mysqli_fetch_assoc($result)) {
                                          if ($row['id']!=$row2['id']) {?>
                                               <option class="<?php echo $class ?>" value='<?php echo $row2['id']?>'> <?php echo $row2['severity_level']?> </option>
                                        <?php  }  ?>

                                        <?php }; ?>
                                       </select>
                                      <label for="title">Severity Level</label>
                                    </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                          <input class="modal-action btn-flat" id="request-form-row" name="submit" type="submit" value="Save">
                          <input value = "<?php echo $_GET['id']?>" name="id" type="hidden">
                        </div>
                      </form>
                      </div>
                      <table id="ticket-details">
                        <tbody>
                            <?php
                            $db = mysqli_connect("localhost", "root", "", "eei_db");


                              $query = "SELECT *, DATE_FORMAT(t.resolution_date,'%d %M %Y %r') as date_resolution, sev.description, DATE_FORMAT(t.date_required, '%d %M %Y %r') as date_required FROM ticket_t t LEFT JOIN sla_t sev ON t.severity_level = sev.id LEFT JOIN ticket_status_t stat ON stat.status_id = t.ticket_status WHERE ticket_id = '".$_GET['id']."'";
                              $result = mysqli_query($db,$query);

                              while($row = mysqli_fetch_assoc($result)){
                                switch($row['severity_level'])
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

                                  case(""):
                                      $class = 'blanksev';
                                      break;
                                }


                                echo "<tr><td class=\"first\">" . "Category" . "</td><td>"  . $row['ticket_category']  . "</td>" .
                                     "<tr><td class=\"first\">" . "Status" .  "</td><td><span class=\"badge new stat\">" . $row['ticket_status'] . "</span></td>" .
                                     "<tr><td class=\"first\">" . "Severity" . "</td><td class=\"$class\" id=\"sev\">"  . $row['severity_level']  . " - " . $row['description'] . "</td>" .
                                     "<tr><td class=\"first\">" . "Due on" . "</td><td class=\"deet\">" .  $row['date_required'] . "</td>" .
                                     "<tr><td class=\"first\">" . "Resolution Date" . "</td><td class=\"deet\">" .  $row['date_resolution'] . "</td>";

                             }
                            ?>
                          </tbody>
                        </table>
                  </div>
                  <div class="card-panel" id="right-card">
                    <span class="black-text">
                          <span id="panelheader">Ticket Details</span>
                          <table id="ticket-details">
                            <tbody>
                                <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");


                                $query = "SELECT CONCAT(r.first_name, ' ', r.last_name) As requestor , r.email_address AS email FROM ticket_t t INNER JOIN user_t r  on (t.user_id=r.user_id) WHERE t.ticket_id = '".$_GET['id']."'";
                                $result = mysqli_query($db,$query);

                                  while($row = mysqli_fetch_assoc($result)){

                                  echo "<tr><td class=\"first\">" . "Requestor" . "</td><td class=\"user\">"  . $row['requestor']  . "</td>" .
                                         "<tr><td class=\"first\">" . "</td><td class=\"details\">" . $row['email'] . "</td></tr>" .
                                         "<tr><td><br></td></tr>";
                                  }

                              $query3 = "SELECT CONCAT(r.first_name, ' ' , r.last_name) AS checker, r.email_address AS email FROM user_t r LEFT JOIN user_access_ticket_t u ON r.user_id = u.checker WHERE u.ticket_id = '".$_GET['id']."'";
                              $result3 = mysqli_query($db,$query3);

                                while($row3 = mysqli_fetch_assoc($result3)){

                                echo "<tr><td class=\"first\">" . "Checker" . "</td><td class=\"user\">"  . $row3['checker']  . "</td>" .
                                       "<tr><td class=\"first\">" . "</td><td class=\"details\">" . $row3['email'] . "</td></tr>" .
                                       "<tr><td><br></td></tr>";
                                }

                                $query2 = "SELECT CONCAT(r.first_name, ' ' , r.last_name) AS approver, r.email_address AS email FROM user_t r LEFT JOIN user_access_ticket_t u ON r.user_id = u.approver WHERE u.ticket_id = '".$_GET['id']."'";
                                $result2 = mysqli_query($db,$query2);

                                   while($row2 = mysqli_fetch_assoc($result2)){

                                   echo "<br><tr><td class=\"first\">" . "Approver" . "</td><td class=\"user\">"  . $row2['approver']  . "</td>" .
                                          "<tr><td class=\"first\">" . "</td><td class=\"details\">" . $row2['email'] . "</td></tr>" .
                                          "<tr><td><br></td></tr>";
                                   }

                                $query4 = "SELECT CONCAT(r.first_name, ' ',r.last_name) AS tagent, r.email_address AS email FROM user_t r LEFT JOIN ticket_t t ON r.user_id =t.ticket_agent_id WHERE t.ticket_id = '".$_GET['id']."'";
                                $result4 = mysqli_query($db,$query4);

                                  while($row4 = mysqli_fetch_assoc($result4)){

                                  echo "<tr><td class=\"first\">" . "Ticket Agent" . "</td><td class=\"user\">"  . $row4['tagent']  . "</td>" .
                                         "<tr><td class=\"first\">" . "</td><td class=\"details\">"  . $row4['email'] . "</td></tr>" .
                                         "<tr><td><br></td></tr>";
                                  }
                                ?>
                              </tbody>
                            </table>
                </div>
                <div class="card-panel" id="right-card">
                 <span class="black-text">
                       <span id="panelheader">File Attachments<br></span>
                       <table id="ticket-details">
                         <tbody>

                           <?php
                           $db = mysqli_connect("localhost", "root", "", "eei_db");

                           $ticketID = $_GET['id'];

                           $query = "SELECT * FROM attachment_t WHERE ticket_id = $ticketID";
                           $result = mysqli_query($db,$query);
                             while($row = mysqli_fetch_assoc($result)){?>
                             <a target="_blank" href="<?php echo 'uploads/' . $row['file']?>"><?php echo $row['file']?></a><br>
                           <?php } ?>
                           </tbody>
                         </table>
             </div>

              </div>
            </div>
          </div><!-- end div of row -->
        </div><!-- end div of main body -->

        <!-- ****************************************************** -->

        <!-- HIDDEN FORMS -->
        <?php include 'templates/ticketforms.php'; ?>

      </div> <!-- End of main container of col 10 -->
    </div> <!-- End of wrapper of col l10 -->
  </div>
  <!-- END OF COL l10 -->

  <?php include 'templates/js_resources.php' ?>

  </body>
</html>
