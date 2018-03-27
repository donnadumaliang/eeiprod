
<?php if($_SESSION['user_type'] != 'Requestor'){ ?>
  <div class="col s12 m12 l12 table-header">
  <div class="row">
    <span class="table-title">Knowledge Base</span>
    <?php if($_SESSION['user_type'] == 'Administrator') {?>
    <a id="addfaq" href="faq-add.php" class="waves-effect waves-light btn-small"><i id="kb" class="tiny material-icons left">book</i>Add New Article</a>
    <a id="addfaq" href="#modal-new-subcategory" class="waves-effect waves-light btn-small modal-trigger"><i id="kb" class="tiny material-icons left">library_books</i>Add Article Subcategory</a>

    <?php } ?>

  </div>
</div>
<?php } else {}?>

<div id="knowledge-base">

  <h4>Hi <b><?php echo $_SESSION['first_name'] ?></b>, how can we help you today?</h4>
  <!-- <div class="input-field search_text">
          <input placeholder="Search Here" name="search_text" id="search_text" class="faq" type="search" required>
          <i id="search"class="material-icons">search</i>
          <label class="label-icon" for="search"></label>
  </div> -->
  <div class="input-field search-box2" id="request-form">
    <input placeholder="Search Here" name="search_text" id="search_text" class="faq" type="text" autocomplete="off" required>
    <i id="search"class="material-icons">search</i>
    <label class="label-icon" for="search"></label>
    <div id="result">


    </div>
    <div id="modal-new-subcategory" class="modal">
  <form method='post' name="subcategory" id="subcategory">
    <div class="modal-content">
      <h5>Add Subcategory</h5>

        <div id="add-subcategory" class="file-field input-field">
            <input placeholder=" " class="title" name="subcategory_name" type="text" required>
            <label for="title">Subcategory Name</label>
            <div class="input-field ticket-properties" id="request-form-row6">
              <?php
                $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                <select name = "category" required>
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
          </div>
        </div>
      <div class="modal-footer">
        <button class="btn" id="" type="submit" name="submit">Create</button>
        <a href="knowledgebase.php" class="btn modal-action modal-close">Close</a>
      </div>
  </form>
  </div>
  </div>
  <br>
    <div class="row">
      <h5>Browse Help Topics</h5>
        <div class="col s12 m4 l4">
          <div class="card">
            <div class="card-image">
              <i class="large material-icons">storage</i>
            </div>
            <div class="card-content">
              <span class="card-title">Technicals</span>

              <p id="kb">Hardware, Mouse, Keyboard, Monitor, Printers, Scanners, Tablets, etc.</p>
            </div>
            <div class="card-action">
              <a href="faq-list.php?view=technicals">View Technical FAQs</a>
              <?php include 'faq-sorter.php'; ?>
            </div>
          </div>
        </div>
        <div class="col s12 m4 l4">
          <div class="card">
            <div class="card-image">
              <i class="large material-icons">vpn_lock</i>
            </div>
            <div class="card-content">
              <span class="card-title">Access</span>
              <p id="kb">Hardware access, application access, password change</p>
            </div>
            <div class="card-action">
              <a href="faq-list.php?view=access">View Access FAQs</a>
              <?php include 'faq-sorter.php'; ?>
            </div>
          </div>
        </div>
        <div class="col s12 m4 l4">
          <div class="card">
            <div class="card-image">
              <i class="large material-icons">network_check</i>
            </div>
            <div class="card-content">
              <span class="card-title">Network</span>
              <p id="kb">Network/Internet Access, Network Equipment - routers, cables etc.</p>
            </div>
            <div class="card-action">
              <a href="faq-list.php?view=network">View Network FAQs</a>
              <?php include 'faq-sorter.php'; ?>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
