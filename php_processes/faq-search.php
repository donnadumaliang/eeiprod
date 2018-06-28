<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$db = mysqli_connect("localhost", "root", "", "eei_db");
// $mysqli = new mysqli("localhost", "id5061714_eei_db_username", "usr@EEI1", "id5061714_eei_db");

// Check connection
if($db === false){
    die("ERROR: Could not connect. " . $db->connect_error);
}

if(isset($_REQUEST['term'])){
    // Prepare a select statement
    $sql = "SELECT * FROM faq_article_t WHERE article_title LIKE ?";
    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_term);

        // Set parameters
        $param_term = '%' . $_REQUEST['term'] . '%';

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();

            // Check number of rows in the result set
            if($result->num_rows > 0){
                // Fetch result rows as an associative array
                while($row = $result->fetch_array(MYSQLI_ASSOC)){ ?>
                    <a id="article" href="faq-article.php?id=<?php echo $row['article_id']?>"><?php echo $row["article_title"]?></a><br>
                <?php }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$db->close();
?>
