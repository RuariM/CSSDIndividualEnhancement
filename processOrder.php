<?php 
    require_once "static/connect.php";

    if(!empty($_POST) && !empty($_POST["orderID"])){
        $id = $_POST["orderID"];
        $sql = "UPDATE orders SET status=1 WHERE id='".$id."'";
        
        #print_r($sql);
        
        if ($db->query($sql) === TRUE) {
            header("location: admin");
            exit;
        }
        if(!empty($_POST) && !empty($_POST["lineID"])){
        
            $lineID = $_POST["lineID"];
            print_r($_POST); 
            $sql = "DELETE FROM orderlines WHERE id='".$lineID."'";
            
            // If the delete is successful send a success message, otherwise error
            if ($db->query($sql) === TRUE) {
                $result123 = "<p class='result'>Item removed from order.</p>";
            } 
            else {
                $result123 = "<p class='result'>There was an unexpected error, please try again!</p>";
            }
        }
        // Close the connection to the database
        $db->close();
    }
?>