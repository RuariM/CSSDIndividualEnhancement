<?php 
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login");
        exit;
    }

    // Check if the user is an admin, redirect to admin panel if they are
    if($_SESSION["isAdmin"] == 1) {
        header("location: admin");
        exit;
    }

    require_once "static/connect.php";

    $results = "";


    //set up form values
    $userID = $_SESSION["id"];
    $sql = "SELECT * FROM items";
    $result = mysqli_query($db, $sql);


    if(!empty($_POST)) {
        // Check if the user is logged in or not
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            //grab form info            
            $userID = $_SESSION["id"];


            $sql = "INSERT INTO orders (userID) VALUES ('".$userID."')";
            
            //foreach($_POST){
                //$sql = 'INSERT INTO'
            //}

            //mysqli_query($db, $sql); can query with this 

            //add order info to database
            if ($db->query($sql) === TRUE) {
                //insert into orders table
                $order_id = $db->insert_id;
                               
                foreach($_POST as $itemID => $quantity)
                { 
                    if(intval($quantity) > 0)
                    { //insert into orderlines
                        $sql = "INSERT INTO orderlines (orderID, quantity, itemID) VALUES ('".$order_id."', '".$quantity."', '".$itemID."')";
                        if($db->query($sql) === TRUE)
                        {
                        //$result = "<p class='result'>Your order request has been submitted. We aim to respond within 24 hours. Check the progress on your dashboard.</p>";
                        }
                        else
                        {
                        
                        }
                    }
                }
            } 
            else {
            $result = "<p class='result'>There was an unexpected error, please try again!</p>";
            }

            $db->close();
        }
        else {
            // If the user is not logged in and tries to get a quote
            // redirect user to the login page
            header("location: login");
            exit;
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/87455b06e8.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="icon" type="image/png" href="img/favicon.png">

        <title>Order | The CSSD Company</title>
    </head>
    <body>
    <div class="navibar">
            <ul>
                <li class="branding"><i class="fas fa-fire login-logo"></i><h2>The CSSD Company</h2></li>
                <li><a class="nav-link" href="dashboard" activeclassname="active">DASHBOARD</a></li>
                <li><a class="nav-link" href="quote" activeclassname="active">GET QUOTE</a></li>
                <li><a class="active"   href="#">ORDER ITEMS</a></li>
                <li><a class="nav-link" href="index#about">ABOUT</a></li>
                <li><a class="nav-link" href="index#contact">CONTACT</a></li>
                <li><a class="nav-link" href="logout">LOGOUT</a></li>
            </ul>
    </div>
    
    <div class="main">
        <h2>Order accessories</h2>
        <p>View accessories for sale here</p>
        <hr>
        <h2>Items</h2>
        <div class="order-form">
            <form action="order" method="post" class="form-group" style="width: 100%">
                <table class="table table-dark table-striped" >
                <thead>
                    <tr>
                        <th scope="col" >Accessory</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $result->fetch_assoc()) {
                        ?>
                    <tr>
                         <th scope="row"> <?php echo $row['name'];?></th>
                         <td>£<?php echo $row['price'];?> </td>
                         <td><input type="number" value = "0" min="0" name=<?php echo $row['itemID']; ?>></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
                </table>
                <div class="orderTotal">
                        <h3 id="order-total">Order Total: <span class="price">£0.00</span></h3>
                        <button type="submit" class="btn btn-success">Submit Order</button>
                </div>
            </form>
        </div>
        <hr>
    </div>

    <script src="order.js">
    </body>
</html>