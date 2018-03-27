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
          <span id="faq-title"><i class="material-icons">library_add</i><span class="table-title">Create Knowledge Base Article</span></span>
          <div class="col s12" id="breadcrumb">
            <?php if($_SESSION['user_type'] != 'Administrator'){ ?>
            <a href="home.php" class="breadcrumb">Knowledge Base</a>
          <?php } else { ?>
            <a href="knowledgebase.php" class="breadcrumb">Knowledge Base</a>
          <?php }?>
            <a href="#!" class="breadcrumb">Create Knowledge Base Article</a>
          </div>
        </div>
        <div id="addKb-form">
          <form id="add-kb" name="addKb" method="post">
          <div class="row">
            <div class="col s12 m12 l4">
              <div class="faq-left">
              <div class="input-field">
                <input placeholder=" " class="title" name="title" type="text" class="validate" required>
                <label for="title">Article Title</label>
              </div>
              <br>
              <div class="input-field ticket-properties" id="request-form">
                <?php
                  ?>
                  <select name = "category" required>
                  <option disabled selected>Select</option>
                  <?php $getcategory = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'faq_article_t' AND COLUMN_NAME = 'category'");
                  $row = mysqli_fetch_array($getcategory);
                  $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                  foreach($enumList as $value){?>
                  <option value='<?php echo $value?>'> <?php echo $value?> </option>
                      <?php } ?>
                  </select>
                  <label for="category">Category</label>
              </div>
              <br>
              <div class="input-field ticket-properties" id="request-form">
            <?php
              ?>

              <select name = "subcategory" required>
              <option disabled selected>Select</option>
              <?php $result = mysqli_query($db, "SELECT * FROM faq_subcategory_t");
              while ($row = mysqli_fetch_assoc($result)) {
                 ?>
                 <option value='<?php echo $row['subcategory_id']?>'> <?php echo $row['subcategory_name']?> </option>
              <?php } ?>
              </select>
              <label for="category">Subcategory</label>
          </div>
              <br>
            </div>
            <input class="waves-effect waves-light add-kb" id="btn-submit" name="submit" type="submit" value="Submit Article">

          </div>
            <div class="col s12 m12 l8">
              <label for="title">Article Body</label>
              <textarea id="kb-content" class = "kb" name="article" required></textarea>
            </div>
          </div>
        </form>
      </div>
        <?php include 'templates/ticketforms.php'; ?>
        <?php include 'templates/js_resources.php' ?>

      </div>

    </div>
    <script>
    $(document).ready(function() {
        $('#kb-content').richText();
      });

      </script>
    <?php include 'templates/mobile-ticket-buttons.php' ?>
    <?php include 'templates/js_resources.php'; ?>
  </body>
</html>
