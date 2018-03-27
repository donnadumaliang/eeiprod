<?php
$db = mysqli_connect("localhost", "root", "", "eei_db");
{

//if category button for sorting is selected
  switch ((isset($_GET['view']) ? $_GET['view'] : ''))
  {
      case ("technicals"):
        $query = "SELECT * FROM faq_article_t LEFT JOIN faq_subcategory_t ON faq_article_t.subcategory_id = faq_subcategory_t.subcategory_id WHERE faq_article_t.subcategory_id='" . $row2['subcategory_id'] ."'";
        $result = mysqli_query($db, $query);
        break;

      case ("access"):
        $query = "SELECT * FROM faq_article_t LEFT JOIN faq_subcategory_t ON faq_article_t.subcategory_id = faq_subcategory_t.subcategory_id WHERE faq_article_t.subcategory_id='" . $row2['subcategory_id'] ."'";
        $result = mysqli_query($db, $query);
        $catname = "Access";
        break;

      case ("network"):
        $query = "SELECT * FROM faq_article_t LEFT JOIN faq_subcategory_t ON faq_article_t.subcategory_id = faq_subcategory_t.subcategory_id WHERE faq_article_t.subcategory_id='" . $row2['subcategory_id'] ."'";
        $result = mysqli_query($db, $query);
        $catname = "Network";
        break;
  }


}; ?>
