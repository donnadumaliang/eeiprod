<?php
  session_start();
  if(!isset($_SESSION['user_id'])){
    header('location: index.php');
  }
  include 'templates/dbconfig.php';
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
      <?php include 'templates/ticketforms.php'; ?>
        <div class="main-content" id="help-support">
          <h4>Welcome to EEI's Online Service Desk System!</h4>
          <hr>
          <br>
          <div class="row">
            <div class="col s12 m3 l3" style="text-align:center;margin-top:10px;">
              <img src="img/system-icon.png">
            </div>
            <div class="col s12 m12 l9">
              <h5>What is an Online Service Desk?</h5>
              <p>An online service desk system serves as the main point of contact between all users outside of the IT department and the IT Service Team. It is a platform where you can report your IT-related concerns by submitting a ticket which you can monitor until its resolution.</p>
            </div>

          </div>
          <br><br>
          <div class="row">
            <div class="col s6 m6 l4">
              <h5>Severity Levels</h5>
              <div class="col l3">
                <table>
                  <tr>
                    <td class="sev1" id="sev">SEV1</td>
                  </tr>
                  <tr>
                    <td class="sev2" id="sev">SEV2</td>
                  </tr>
                  <tr>
                    <td class="sev3" id="sev">SEV3</td>
                  </tr>
                  <tr>
                    <td class="sev4" id="sev">SEV4</td>
                  </tr>
                  <tr>
                    <td class="sev5" id="sev">SEV5</td>
                  </tr>
                </table>
              </div>
              <div class="col l9">
                <table>
                  <tr>
                    <td>Important</td>
                  </tr>
                  <tr>
                    <td>Critical</td>
                  </tr>
                  <tr>
                    <td>Normal</td>
                  </tr>
                  <tr>
                    <td>Low</td>
                  </tr>
                  <tr>
                    <td>Very Low</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col s6 m6 l4">
              <h5>Ticket Categories</h5>
              <div class="col s12 m12 l10 pull-l2">
                  <br>
                      <div class="row">
                        <div class="col l3"><span class="ticket_cat_t" style="width:40px; height:40px; font-size:22px;padding-top:7px;margin-right:10px">T</span></div>
                        <div class="col l7" style="margin-top: 8px;font-size:14.5px">Technicals</div>
                      </div>

                      <div class="row">
                        <div class="col l3"><span class="ticket_cat_a" style="width:40px; height:40px; font-size:22px;padding-top:7px;margin-right:10px">A</span></div>
                        <div class="col l7" style="margin-top: 8px;font-size:14.5px;">Access</div>
                      </div>

                      <div class="row">
                        <div class="col l3"><span class="ticket_cat_n" style="width:40px; height:40px; font-size:22px;padding-top:7px;margin-right:10px">N</span></div>
                        <div class="col l7" style="margin-top: 8px;font-size:14.5px;">Network</div>
                      </div>

               </div>


            </div>

            <div class="col s12 m12 l4">
              <h5>User Manuals</h5>
              <?php
              if ($_SESSION['user_type'] == "Administrator"){?>
                <div class="row">
                  <div class="col s12 m12 l12">
                     <div class="card horizontal">
                       <div class="card-stacked">
                         <div class="card-content">
                           <img src="img/admin.png">
                           <p>Administrator</p>
                         </div>
                         <div class="card-action">
                           <a href="<?php echo 'resources/ADMINISTRATOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              <?php }
              else if ($_SESSION['user_type'] == "Access Group Manager"){?>
                <div class="row">
                  <div class="col s12 m12 l12">
                     <div class="card horizontal">
                       <div class="card-stacked">
                         <div class="card-content">
                           <img src="img/manager.png">
                           <p>Access Manager</p>
                         </div>
                         <div class="card-action">
                           <a href="<?php echo 'resources/ACCESS-GROUP-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              <?php }
              else if ($_SESSION['user_type'] == "Technicals Group Manager"){?>
                <div class="row">
                  <div class="col s12 m12 l12">
                     <div class="card horizontal">
                       <div class="card-stacked">
                         <div class="card-content">
                           <img src="img/manager.png">
                           <p>Technicals Manager</p>
                         </div>
                         <div class="card-action">
                           <a href="<?php echo 'resources/TECHNICALS-GROUP-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              <?php }
              else if ($_SESSION['user_type'] == "Network Group Manager"){?>
                <div class="row">
                  <div class="col s12 m12 l12">
                     <div class="card horizontal">
                       <div class="card-stacked">
                         <div class="card-content">
                           <img src="img/manager.png">
                           <p>Network Manager</p>
                         </div>
                         <div class="card-action">
                           <a href="<?php echo 'resources/NETWORK-GROUP-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              <?php }
              elseif (($_SESSION['user_type'] == 'Technician') || ($_SESSION['user_type'] == 'Network Engineer')) {?>
                <div class="row">
                  <div class="col s12 m12 l12">
                     <div class="card horizontal">
                       <div class="card-stacked">
                         <div class="card-content">
                           <img src="img/admin.png">
                           <p>Technician/Network Engineer</p>
                         </div>
                         <div class="card-action">
                           <a href="<?php echo 'resources/TECHNICALS&NETWORK-ENGINEERS-MANAGER_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              <?php }
              else {?>
                <div class="row">
                  <div class="col s12 m12 l12">
                      <div class="card horizontal">
                        <div class="card-stacked">
                          <div class="card-content">
                            <img src="img/user.png">
                            <p>Requestor</p>
                          </div>
                          <div class="card-action">
                            <a href="<?php echo 'resources/REQUESTOR_EEI Service Desk User Manual_v1.0.pdf'?>">Download User Manual</a><br>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

              <?php } ?>
            </div>

          </div>

        </div>
    </div>
    <?php include 'templates/js_resources.php'; ?>

  </body>

</html>
