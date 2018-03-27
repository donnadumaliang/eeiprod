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
      <div class="main-content" >
      <?php
          $query2 = "SELECT * FROM faq_article_t WHERE article_id = '".$_GET['id']."'";
          $result2= mysqli_query($db,$query2);
            while($row = mysqli_fetch_assoc($result2)){
              $articleID =$_GET['id'];
              $category = $row['category'];
              $articleTitle = $row['article_title'];
              $articleBody = $row['article_body'];
            }
        ?>
        <div class="col s12 m12 l12 table-header">
          <span class="table-title"><?php echo $category?> FAQ #<?php echo $articleID?></span>
          <?php if($_SESSION['user_type'] == "Administrator"){ ?>
          <span id="actions">
            <a class="button-edit" href="faq-edit-article.php?id=<?php echo $articleID?>">Edit</a>
            <form id="delete-kb" name="confirm" method="post">
              <input class="button-delete" type="submit"  value="Delete">
              <input type="hidden" name="id" value="<?php echo $articleID ?>">
            </form>
            <!-- <a class="button-delete" href="php_processes/faq-delete.php?id=<?php echo $articleID?>">Delete</a> -->
          </span>
          <?php } ?>
          <div class="col s12" id="breadcrumb">
            <?php switch ($category)
            {
              case ("Technicals"):
              $cat = "technicals";
              break;

              case ("Access"):
              $cat = "access";
              break;

              case ("network"):
              $cat = "network";
              break;
            }?>
            <a href="home.php" class="breadcrumb">Knowledge Base</a>
            <a href="faq-list.php?view=<?php echo $cat ?>" class="breadcrumb"><?php echo $category?> FAQ</a>
            <a href="#!" class="breadcrumb"><?php echo $category?> FAQ #<?php echo $articleID ?></a>

          </div>
        </div>
          <div id="knowledge-base-body" class="row">
            <div id="faq">
              <span id="faq"><h5><b><?php echo $articleTitle ?></b></h5></span>
              <p><?php echo $articleBody ?> </p>
            </div>
          </div>
        </div>
      </div>
    <?php include 'templates/ticketforms.php'; ?>
    <?php include 'templates/js_resources.php'; ?>
  </body>
</html>
