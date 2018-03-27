<?php
  session_start();
  if(!isset($_SESSION['user_id'])){
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
      <div class="col s12 m12 l12 table-header">
        <span class="table-title">Manage Users</span>
        <div class="count">
          <!-- Badge Counter -->
          <?php
            $query = "SELECT COUNT(*) AS count FROM user_t";
            $result = mysqli_query($db,$query); ?>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
              <span class="badge main-count"> <?php echo $row['count'] . " users" ?></span>
            <?php }
          ?>
        </div>
        <div class="col s12" id="breadcrumb">
          <a href="#!" class="breadcrumb">Manage Users</a>
          <a href="#!" class="breadcrumb">All Users</a>
        </div>
      </div>
      <div class="material-table" id="manage">
          <div class="actions">
            <div class="sorter">
              <!-- Button for Removing Filter -->
              <a href="#" class="waves-effect btn-newuser requestor">Add New User</a>
              <a href="#modal-batch-upload" class="modal-trigger waves-effect btn-newuser batch">Batch Upload</a>
              <a class="dropdown-button btn-sort" data-activates="dropdownIsActive" data-beloworigin="true">Account Status<i id="sort" class="material-icons">arrow_drop_down</i></a>
              <ul id="dropdownIsActive" class="dropdown-content collection">
                <li><a href="?view=all">All</a></li>
                <li><a href="?view=active">Active</a></li>
                <li><a href="?view=deactivated">Deactivated</a></li>
              </ul>
            </div>

          </div>
          <table id="datatable" class="manageUsers">
            <thead>
              <tr>
                <th>Requestor Name</th>
                <th class="col-hideuserid">User ID</th>
                <th>Email Address</th>
                <th>User Type</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php

              $query = "SELECT * FROM user_t";
              switch ((isset($_GET['view']) ? $_GET['view'] : ''))
              {
                  case ("active"):
                    $query = "SELECT * FROM user_t WHERE isActive='1'";
                    break;

                  case ("deactivated"):
                  $query = "SELECT * FROM user_t WHERE isActive='0'";
                    break;

                  case ("all"):
                  $query = "SELECT * FROM user_t";
                    break;
              }
              $result = mysqli_query($db,$query);
              while ($row = mysqli_fetch_assoc($result)){
                  switch($row['isActive'])
                  {
                      case("1"):
                          $class = 'active';
                          break;

                     case("0"):
                         $class = 'deactivated';
                         break;
                  }
              ?>
                <tr class='clickable-row' data-href="profile.php?id=<?php echo $row['user_id']?>">
                      <td class = 'user-row'> <?php echo $row['first_name'] . ' ' . $row['last_name']?>  </td>
                      <td class = 'user-row col-hideuserid'> <?php echo $row['userid']?>   </td>
                      <td class = 'user-row'> <?php echo $row['email_address']?>  </td>
                      <td class = 'user-row'> <?php echo $row['user_type']?> </td>
                      <td class = 'user-row <?php echo $class ?>'></td>
                    </tr>
                  <?php }?>
            </tbody>
          </table>
        </div>
    </div>

    <!-- New User Form -->
    <form id="new-requestor" name="requestor" method="post">
      <div id="requestor" class="requestort">
        <span class="table-title" id="form">Add New User</span>
        <!-- Preloader and it's background. -->
        <div class="preloader-background">
          <div class="activity">
            <h6>Sending e-mail to user</h6>
            <span>This may take a few seconds</span>
          </div>
          <div class="progress">
           <div class="indeterminate">
           </div>
         </div>
        </div>
        <!-- End of preloader -->
          <div class="row">
              <div class="col s12">
                <div class="row">
                    <div class="col s12 l6" id="form">
                      <h6>User Details</h6>
                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " class="userid" name="userid" type="text" required>
                            <label for="title">User ID</label>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " class="fname" name="fname" type="text" required>
                            <label for="title">First Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " class="lname" name="lname" type="text" required>
                            <label for="title">Last Name</label>
                          </div>
                        </div>
                      </div>

                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " class="email" name="email" type="text" required>
                            <label for="title">Email Address</label>
                          </div>
                        </div>
                      </div>

                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <?php
                              $db = mysqli_connect("localhost", "root", "", "eei_db");
?>

                              <select name = "type" required>
                              <option value= "">Select</option>
                              <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'user_t' AND COLUMN_NAME = 'user_type'");
                              $row = mysqli_fetch_array($get_user_type);
                              $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                              foreach($enumList as $value){?>
                              <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                  <?php } ?>
                              </select>
                          <label for="title">User Type</label>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="request-form-controls">
                        <input class="waves-effect waves-light" id="btn-cancel" name="submit" type="submit" value="Cancel">
                        <input class="waves-effect waves-light" id="btn-submit" name="submit" type="submit" value="Submit">
                      </div>
                    </div>

                </div>
              </div>
          </div>
        </div>
    </form>
    <!-- Modal for Batch Upload -->
    <div id="modal-batch-upload" class="modal">
      <div class="modal-content">
        <h5>Batch Upload New Users</h5>
        <form method='post' name="batch" action = "php_processes/batch-upload.php" id="batch-upload" enctype="multipart/form-data">
          <div class="file-field input-field">
            <br>
            <div class="btn-attach">
              <span>SELECT File</span>
              <input type="file" id="file" name="file"/>
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        <div class="modal-footer">
          <button class="btn" type="submit" name="submit">Upload</button>
          <a href="manageUsers.php" class="btn modal-action modal-close">Close</a>
          </form>
        </div>
      </div>
    </div>
    <!-- HIDDEN FORMS -->
    <?php include 'templates/ticketforms.php'; ?>
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php'; ?>
  </div>
</body>
</html>
