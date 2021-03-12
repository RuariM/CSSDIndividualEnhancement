<?php
    // Include the database connection
    require_once "static/connect.php";

    // Only run the code if the form has been submitted
    if(!empty($_POST)) {
        // Get the info from the passed form
        $id    = $_POST["quoteID"];
        $price = (double)$_POST["price"];

        echo $id . " " . $price;

        // Update the quote 
        $sql = "UPDATE quotes SET price='".$price."', status=1 WHERE id='".$id."'";
        
        // If the insert is successful send a success message, otherwise error
        if ($db->query($sql) === TRUE) {
            header("location: admin");
            exit;
        } 
        else {
            header("location: admin");
            exit;
        }
        print_r($_POST);
        // Close the connection to the database
        $db->close();
    }  
?>