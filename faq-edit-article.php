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
          <!-- <a href="edit-article.php?id=<?php echo $articleID?>">Edit Article</a> -->
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
            <a href="faq-article.php?id=<?php echo $articleID ?>" class="breadcrumb"><?php echo $category?> FAQ #<?php echo $articleID ?></a>
            <a href="#!" class="breadcrumb">Edit Article</a>

          </div>
        </div>
        <div class="article-body" class="row">
            <?php
            $db = mysqli_connect("localhost", "root", "", "eei_db");


            $query = "SELECT * FROM faq_article_t fat LEFT JOIN faq_subcategory_t fst ON fat.subcategory_id = fst.subcategory_id  WHERE article_id = '".$_GET['id']."'";
            $result= mysqli_query($db,$query);
            $row = mysqli_fetch_assoc($result);
            $articlebody = $row['article_body'];?>
            <form id="edit-kb" name="editKb" method="post">
              <div id="edit-header">
              <span class="article-header"><?php echo $row['article_title'] ?></span>

              <span class="fl-right">
                <input class="waves-effect waves-light add-kb" id="btn-submit" name="submit" type="submit" value="Save">
                <input type="hidden" name="article_id" value="<?php echo $_GET['id']; ?>">
              </span>
              <br><p id="edit-subheader"><?php echo $row['category']?> - <?php echo $row['subcategory_name'] ?></p>
              <hr>
          </div>
            <textarea id="kb-content" class="kb" name="article"><?php echo $articlebody ?></textarea>
          </form>
          </div>
        </div>
      </div>
    <?php include 'templates/ticketforms.php'; ?>
    <?php include 'templates/js_resources.php'; ?>
    <script>
    $(document).ready(function() {
        $('#kb-content').richText();
      });

      </script>
  </body>
</html>
