<div id="details-actions" class="fixed-action-btn horizontal click-to-toggle">

<a>
  <i class="small material-icons">more</i>
</a>
<ul id="detail-acts">
  <input id="attach" type="submit" class="modal-trigger" href="#attachfile" value="Attach" />
  <!-- Confirm Resolution for Requestor  -->
  <?php if ($_SESSION['user_type']=="Requestor"){
     if ($row['ticket_status']==7 and $row['user_id']== $_SESSION['user_id']) { ?>
       <form id="confirm" name="confirm" method="post">
         <input id="confirm" type="submit"  value="Confirm">
         <input  id="confirm" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
       </form>
   <?php }} ?>

  <!-- Cancel Button for Admin -->
   <?php if ($_SESSION['user_type']=="Administrator") {?>
     <form id="cancel" name="cancel" method="post">
       <input id="cancel" type="submit" value="Cancel">
       <input  id="cancel" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
     </form>
   <?php }?>

   <!-- Return Button for Ticket Agents -->
   <?php if ($_SESSION['user_type']=="Technician" OR $_SESSION['user_type']=="Network Engineer") {?>
       <input id="return" type="submit" class="modal-trigger" href="#returnsupervisor" value="Return" />
   <?php  }?>

   <!-- Return Button for Ticket Agents -->
   <?php if ($_SESSION['user_type']=="Access Group Manager" OR $_SESSION['user_type']=="Network Group Manager" OR $_SESSION['user_type']=="Technicals Group Manager") {?>
       <input id="return" type="submit" class="modal-trigger" href="#returnadmin" value="Return" />
   <?php  }?>
  <!-- Approve, Check and Reject Button for Approver/Checker  -->
  <div class="approve-reject">
     <?php if ($row['approver']==$id  && $row['isApproved']!=1) { ?>
         <form id="approve" name="approve" method="post">
           <input id="approve" type="submit" onclick="php_processes/approve-process.php'" value="Approve">
           <input  id="approve" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
         </form>

         <form id="reject" name="reject" method="post">
           <input id="reject" type="submit" onclick="php_processes/reject-process.php'" value="Reject">
           <input  id="reject" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
         </form>
      <?php }
       elseif ($row['checker']==$_SESSION['user_id'] && $row['isChecked']!=1) { ?>
        <form id="check" name="check" method="post">
          <input id="check" type="submit" onclick="php_processes/check-process.php'" value="Check" />
          <input id="check" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
        </form>

        <form id="reject" name="reject" method="post">
          <input id="reject" type="submit" onclick="php_processes/reject-process.php'" value="Reject">
          <input  id="reject" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
        </form>
    <?php } ?>
   </div>
</ul>
</div>
