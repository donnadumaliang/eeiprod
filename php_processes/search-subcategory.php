<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// $mysqli = new mysqli("localhost", "root", "", "eei_db");

$mysqli = new mysqli("localhost", "id5061714_eei_db_username", "usr@EEI1", "id5061714_eei_db");

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if(isset($_REQUEST['term'])){
    // Prepare a select statement
    $sql = "SELECT * FROM faq_subcategory_t WHERE subcategory_name LIKE ?";

    if($stmt = $mysqli->prepare($sql)){
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
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    echo "<p>" . $row["subcategory_name"]. "</p>";
                }
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
$mysqli->close();
?>
