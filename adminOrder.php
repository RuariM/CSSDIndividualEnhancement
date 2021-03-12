<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login");
        exit;
    }

    // Include the database connection
    require_once "static/connect.php";

    // Initialise needed variables
    if(!empty($_POST["orderID"]))
    {
        $id = $_POST['orderID'];
    }
    
    $total = 0;
    $status = 0;

    if(!empty($_POST) && !empty($_POST["lineID"])){
        
        $lineID = $_POST["lineID"];
        
        $sql = "DELETE FROM orderlines WHERE lineID='".$lineID."'";
        
        // If the delete is successful send a success message, otherwise error
        if ($db->query($sql) === TRUE) {
            $result123 = "<p class='result'>Item removed from order.</p>";
        } 
        else {
            $result123 = "<p class='result'>There was an unexpected error, please try again!</p>";
            print_r($_POST);
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

        <title>Admin | The CSSD Company</title>
    </head>
    <body>
    <div class="navibar">
            <ul>
                <li class="branding"><i class="fas fa-fire login-logo"></i><h2>The CSSD Company</h2></li>
                <li><a class="active"   href="admin">DASHBOARD</a></li>
                <li><a class="nav-link" href="index" activeclassname="active">HOME</a></li>
                <li><a class="nav-link" href="logout">LOGOUT</a></li>
            </ul>
    </div>
        <div class="main">
            <?php
                $sql  = "SELECT status, date, address, location FROM orders WHERE id='".$id."'";
                $result = mysqli_query($db, $sql);
                $row = $result->fetch_assoc();
                $status = $row['status'];
            ?>
            <h2>ORDER #<?php echo $id?> 
                <?php if($row['status'] == 0) { ?>
                    <button class="btn btn-warning">Pending Review</button>
                <?php } else if($row['status'] == 1) { ?>
                    <button class="btn btn-success">Order Accepted</button>
                <?php } ?>  
            </h2>
            <hr>
            <div class="quote-container">

                <div class="row" style="padding-top: 15px">
                    <div class="col-md-4"><h3>Date</h3> <p><?php echo $row['date']; ?></p></div>
                    <div class="col-md-4"><h3>Address</h3> <p><?php echo $row['address']; ?></p></div>
                    <div class="col-md-4"><h3>Location</h3> <p><?php echo $row['location']; ?></p></div>
                </div>
                <hr>
                <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Remove Item</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT quantity, itemID, lineID FROM orderlines WHERE orderID='".$id."'";
                        $lineResult = mysqli_query($db, $sql);       

                        while($row = $lineResult->fetch_assoc()) {  
                            $sql = "SELECT name, price FROM items WHERE itemID='".$row['itemID']."' LIMIT 1";
                            $itemResult = mysqli_query($db, $sql);
                            $line = $itemResult->fetch_assoc();
                    ?>
                    <tr>
                        <th scope="row"><?php echo $line['name']; ?></th>
                        <td>£<?php echo $line['price']; ?></td>
                        <td>£<?php echo $line['price'] * $row['quantity']; $total += ($line['price'] * $row['quantity'])?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <form action="adminOrder" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="lineID" name="lineID" value="<?php echo $row['lineID']; ?>">
                                <input type="hidden" id="orderID" name="orderID" value="<?php echo $id; ?>">
                                <td><button class="btn btn-danger">Remove</button></td>
                        </form>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
                </hr>
                <hr>
                <h2>Total Price <span style="color: #4CAF50;">£<?php echo $total; ?></span></h2>
                <form action="processOrder" method="post" class="form-group" style="width: 100%">
                    <input type="hidden" id="orderID" name="orderID" value="<?php echo $id; ?>">
                    <?php if($status == 0) {
                            echo '<button type="submit" class="btn btn-success price-btn">Sumbit Price</button>';
                    }
                        else{
                            echo '<hr><hr>';
                    }?>
                </form>
            </div>
                
            <section>
                <div class="content-section">
                    <footer>
                        <hr>
                        <a href="#" class="float-right" style="color:#B00020;"><i class="fas fa-fire"></i> &#169; 2021 The CSSD Company <i class="fas fa-fire"></i></a>
                    </footer>
                </div>
            </section>
            </div>
        </div>
    </body>


</html>