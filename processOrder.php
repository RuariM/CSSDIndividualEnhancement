<?php 

    require_once "static/connect.php";

    if(!empty($_POST) && !empty($_POST["orderID"])){
        $id = $_POST["orderID"];
        $sql = "UPDATE orders SET status=1 WHERE id='".$id."'";
        
        print_r($sql);

        if ($db->query($sql) === TRUE) {
            header("location: admin");
            exit;
        }

        // Close the connection to the database
        $db->close();
    }
?>