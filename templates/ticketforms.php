<!-- SERVICE REQUEST FORM -->
<script type="text/javascript" src="js/jquery3.1.0.min.js"></script>

<?php
   $db = mysqli_connect("localhost", "root", "", "eei_db");
   function fill_unit_select_box()
   {
    $output = '';
    $db = mysqli_connect("localhost", "root", "", "eei_db");
    $get_types = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'request_details_t' AND COLUMN_NAME = 'request_type'");
    $row2 = mysqli_fetch_array($get_types);
    $enumList = explode(",", str_replace("'", "", substr($row2['column_type'], 5, (strlen($row2['column_type'])-6))));
    foreach($enumList as $row)
    {
     $output .= '<option value="'.$row.'">'.$row.'</option>';
    }
    return $output;

   }

   ?>
<script>
$(document).ready(function(){
 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  html += '<td><input type="text" name="app_name[]" class="form-control item_name" required/></td>';
  html += '<td><input type="text" name="access_request[]" class="form-control item_quantity" required /></td>';
  html += '<td><select name="type[]" id="status" class ="dselect" required><option value="">Select Unit</option><?php echo fill_unit_select_box(); ?></select></td>';
  html += '<td><input type="text" name="name[]" class="form-control item_quantity" required /></td>';
  html += '<td><button type="button" name="remove" class="remove"><i class="small material-icons">clear</i></button></td></tr>';
  $('#dynamic_field').append(html);
  //need for select
  $('select').material_select();
 });

 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });

 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  $('.item_name').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Item Name at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });

  $('.item_quantity').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Item Quantity at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });

  $('.item_unit').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });

});
</script>
<form id="service" action="php_processes/service_ticket_process.php" name="service" method="post" enctype="multipart/form-data">
  <div id="service" class="servicet">
    <div class="col s12 m12 l12 table-header">
      <span class="table-title">New Service Request</span>
      <div class="col s12" id="breadcrumb">
        <a href="javascript:history.back()" class="breadcrumb back">New Ticket</a>
        <a href="#!" class="breadcrumb">New Service Request</a>
      </div>
    </div>
    <div class="ticketform-body">
      <div class="row">
        <div class="col s12 m12 l6" id="form">
          <div class="row" id="request-form-row4">
            <div class="col s12">
              <div class="input-field" id="request-form">
                <input type="text"  id="date_prepared" name="date_prepared" disabled>
                <label for="date_prepared">Date Prepared (YYYY/MM/DD)</label>
              </div>
            </div>
          </div>
          <div class="row" id="request-form-row3">
            <div class="col s12">
              <div class="input-field" id="request-form">
                <input placeholder=" " class="title" name="title" type="text" data-length="40" class="validate" required>
                <label for="title">Request Title</label>
              </div>
            </div>
          </div>
            <div class="col s12 m12 l6">
              <div class="row" id="request-form-row4">
                <div class="col s12">
                  <div class="input-field" id="request-form">
                   <input class="tooltipped" data-position="left" data-delay="50" data-tooltip="Device Code" placeholder="Device Code" name="asset_no" type="text" id="asset_no" required>
                   <label for="rc_no">Asset No.</label>
                 </div>
                </div>
              </div>
            </div>
            <div class="col s12 m12 l6">
              <div class="row" id="request-form-row4">
                <div class="col s12">
                  <div class="input-field" id="request-form">
                    <input class="tooltipped" data-position="left" data-delay="50" data-tooltip="10-digit Project Code" placeholder="Project Number" name="rc_no" type="text" id="rc_no" >
                    <label for="rc_no">R.C. Number</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12 m12 l6" id="form">
            <div class="row" id="request-form-row4">
              <div class="col s12 l12">
                <div class="input-field" id="request-form">
                <input placeholder=" " class="title" name="department" type="text" data-length="40" class="validate" required>
                <label for="title">Deparment/Project</label>
              </div>
              </div>
            </div>
            <div class="row" id="request-form-row2">
              <div class="input-field">
                <textarea id="textarea1" placeholder=" " class="materialize-textarea" name="request_details" required></textarea>
                <label for="textarea1" required>Details</label>
              </div>
            </div>
            <!-- ATTACH FILE -->
            <div id="request-form-row3" class="file-field input-field">
              <div class="btn-attach">
                <span>SELECT File</span>
                <input type="file" id="file" name="file"/>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
        </div>
      </div>
        <div class="row" style="float: right; margin-right:20px;">
          <input class="waves-effect waves-light" id="btn-submit" name="submit" type="submit" value="Submit">
          <input class="waves-effect waves-light" id="btn-cancel" name="submit" type="button" value="Cancel">
        </div>
      </div>
     </div>
</form> <!-- End of Service Request Form -->

<!-- USER ACCESS FORM  -->
<form id="access" name="access" method="post">
  <div id="access" class="accesst">
    <div class="col s12 m12 l12 table-header">
      <span class="table-title">New User Access Request</span>
      <div class="col s12" id="breadcrumb">
        <a href="javascript:history.back()" class="breadcrumb back">New Ticket</a>
        <a href="#!" class="breadcrumb">New User Access Request</a>
      </div>
    </div>
    <div class="ticketform-body">
      <!-- Preloader and it's background. -->
      <div class="preloader-background">
      <div class="activity">
          <h6>Sending e-mail to reviewer..</h6>
        <p align="center">This may take a few seconds</p>
      </div>
      <div class="progress">
       <div class="indeterminate">
       </div>
     </div>
    </div>
    <!-- End of preloader -->
        <div class="row">
          <!-- Start of LEFT column -->
          <h6 id="ticket-forms">Requestor Details</h6>
          <div class="col s12 m12 l6" id="form">
            <div class="col s12 m12 l6">
              <div class="row" id="request-form-row4">
                <div class="col s12">
                  <!-- <i class="tiny material-icons" id="form">event</i>Date Prepared: -->
                  <div class="input-field" id="request-form">
                    <input type="text"  id="date_prepared2" name="date_prepared2" disabled>
                    <label for="date_prepared2">Date Prepared (YYYY/MM/DD)</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12 m12 l6">
              <div class="row" id="request-form-row4">
                <div class="col s12">
                  <div class="input-field" id="request-form">
                    <input class="tooltipped" data-position="left" data-delay="50" data-tooltip="10-digit Project Code" placeholder="Project Number" name="rc_no" type="text" id="rc_no" required>
                    <label for="rc_no">R.C. Number</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="request-form-row2">
              <div class="col s12">
                <div class="input-field" id="request-form">
                  <input placeholder=" " name="company" type="text" required>
                  <label for="company">Company</label>
                </div>
              </div>
            </div>
            <div class="row" id="request-form-row2">
              <div class="col s12">
                <div class="input-field" id="request-form">
                  <input placeholder=" " name="dp" type="text" required>
                  <label for="Department/Project">Department/Project</label>
                </div>
              </div>
            </div>
          </div> <!-- End of LEFT column -->


          <!-- Start of RIGHT column -->
          <div class="col s12 m12 l6" id="form">
            <br>
            <div class="row" id="request-form-row7">
              <div class="col s12 l12">
                <div class="input-field" id="request-form">
                  <input placeholder=" " class="title" name="title" type="text" data-length="40" required>
                  <label for="title">Request Title</label>
                </div>
              </div>
            </div>
            <div class="row" id="request-form-row7">
              <div class="col s12 l12">
                <div class="input-field" id="request-form-row9">
                  <input placeholder="dd/mm/yy" class="title" id="expdate" name="expdate" type="date">
                  <label for="expdate" style="font-size:12px">Expiry Date</label>
                </div>
              </div>
            </div>
          </div>
          <br>
        </div>
          <h6 id="ticket-forms">Reviewed By:</h6>
          <div class="row col l12">
              <div class="col s12 m12 l6" id="form">
                <div class="row" id="request-form-row4">
                    <div class="input-field search-box" id="request-form" tabindex="-1">
                      <input class="tooltipped" data-position="top" data-delay="50" data-tooltip="Assistant PM (if applicable)" placeholder=" " name="checker" autocomplete="off" type="text" validate>
                      <div class="result"></div>
                        <label for="approver">Checker *<i>optional</i></label>
                    </div>
                </div>
              </div>
              <div class="col s12 m12 l6" id="form">
                <div class="row" id="request-form-row4">
                  <div class="input-field search-box" id="request-form" tabindex="-1">
                    <input class="tooltipped" data-position="top" data-delay="50" data-tooltip="Direct Supervisor, PM or PIC" placeholder="Department's or Group's PM or Person-In-Charge" name="approver" autocomplete="off" type="text" required>
                    <div class="result"></div>
                    <label for="approver">Approver *<i>required</i></label>
                  </div>
                </div>
              </div>
          </div>

        <div class="col s12 m12 l12" id="form">
          <span id="rdetails"><h6>Request Details</h6>
          </span>
            <table id="dynamic_field">
              <thead>
                <tr>
                <div class="col s12 m12 l3">
                  <th>Application Name</th>
                </div>
                <div class="col s12 m12 l3">
                  <th>Access Request</th>
                </div>
                <div class="col s12 m12 l3">
                  <th>Request Type</th>
                </div>
                <div class="col s12 m12 l3">
                  <th>Full Name of User</th>
                </div>
                <div class="col s12 m12 l2">
                  <th><button type="button" class="add"><i class="tiny material-icons">add</i>Add Row</button></th>
                </div>
              </tr>
              </thead>
              <tr>
              <td><input required type="text" name="app_name[]" class="form-control item_name" /></td>
              <td><input required type="text" name="access_request[]" class="form-control item_quantity" /></td>
              <td><select required name="type[]" id="status" class ="dselect" required><option value="">Select Unit</option><?php echo fill_unit_select_box(); ?></select></td>
              <td><input required type="text" name="name[]" class="form-control item_quantity" /></td>
              <td><button type="button" name="remove" class="remove"><i class="small material-icons">clear</i></button></td></tr>
             </table>

          </div>  <!-- End of RIGHT column -->
          <br><br>
          <div class="row" style="float: right; margin-right:20px;">
            <input class="waves-effect waves-light" id="btn-submit" name="submit" type="submit" value="Submit">
            <input class="waves-effect waves-light btn-cancel" id="btn-cancel" name="submit" type="submit" value="Cancel">
          </div>

</div>
        </div> <!-- End of row -->
</form> <!-- End of User Access Request Form -->
<!-- END OF HIDDEN FORMS  -->
