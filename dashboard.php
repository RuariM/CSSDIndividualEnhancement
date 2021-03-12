<?php
    // Initialize the session
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

    // Include the database connection
    require_once "static/connect.php";

    $quoteResult = "";

    // Only run the code if the form has been submitted
    if(!empty($_POST) && !empty($_POST["quoteID"])) {
        // Get the information passed from the cancellation click
        $quoteID = $_POST["quoteID"];

        // delete the row in the quotes database
        $sql = "DELETE FROM quotes WHERE id='".$quoteID."'";
        
        // If the delete is successful send a success message, otherwise error
        if ($db->query($sql) === TRUE) {
            $quoteResult = "<p class='result'>Your quote request has been successfully cancelled.</p>";
        } 
        else {
            $quoteResult = "<p class='result'>There was an unexpected error, please try again!</p>";
        }
    }  
    $orderResult = "";
    if(!empty($_POST) && !empty($_POST["orderID"])){
        // Get the information passed from the cancellation click
        $orderID = $_POST["orderID"];
        
        // delete the row in the quotes database
        $sql = "DELETE FROM orders WHERE id='".$orderID."'";
        
        // If the delete is successful send a success message, otherwise error
        if ($db->query($sql) === TRUE) {
            $orderResult = "<p class='result'>Your order request has been successfully cancelled.</p>";
        } 
        else {
            $orderResult = "<p class='result'>There was an unexpected error, please try again!</p>";
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

        <title>Dashboard | The CSSD Company</title>
    </head>

    <body>
        <div class="navibar">
            <ul>
                <li class="branding"><i class="fas fa-fire login-logo"></i><h2>The CSSD Company</h2></li>
                <li><a class="active"   href="#">DASHBOARD</a></li>
                <li><a class="nav-link" href="quote" activeclassname="active">GET QUOTE</a></li>
                <li><a class="nav-link" href="order" activeclassname="active">ORDER ITEMS</a></li>
                <li><a class="nav-link" href="index#about">ABOUT</a></li>
                <li><a class="nav-link" href="index#contact">CONTACT</a></li>
                <li><a class="nav-link" href="logout">LOGOUT</a></li>
            </ul>
        </div>

        <div class="main">
            <h2>Customer Dashboard</h2>
            <p>View your quote requests and purchase orders here.</p>
            <hr>
            <h2>Quotes</h2>

            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Utility</th>
                        <th scope="col">Cancel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $userID = $_SESSION["id"];
                        $sql = "SELECT id, date, price, status, utilityType FROM quotes WHERE userID='".$userID."' ORDER BY id ASC";
                        $result = mysqli_query($db, $sql);       
                        
                        while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['id']; ?></th>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php if($row['price'] == 0) { echo "Price Pending."; } else { echo "£" . $row['price']; } ?></td>
                            <td><?php if($row['status'] == 0) { ?>
                                    <button class="btn btn-warning">Pending Review</button>
                                <?php } else if($row['status'] == 1) { ?>
                                    <button class="btn btn-info">Quote Given</button>
                                <?php } else { ?>
                                    <button class="btn btn-success">Quote Accepted</button>
                                <?php } ?>
                            </td>
                            <td>
                            <?php if($row['utilityType'] == 'Gas') { ?>
                                    <button class="btn btn-primary"><?php echo $row['utilityType']?></button>
                                <?php } 
                                else if($row['utilityType'] == 'Energy') { ?>
                                    <button class="btn btn-success"><?php echo $row['utilityType']?></button>
                                <?php } ?>
                            </td>
                            <form action="dashboard" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="quoteID" name="quoteID" value="<?php echo $row['id']; ?>">
                                <td><button class="btn btn-danger">Cancel</button></td>
                            </form>
                        </tr>                  
                    <?php
                        }
                    ?>  
                </tbody>
            </table>      

            <?php echo $quoteResult; ?>
            
            <h2>Purchase Orders</h2>

            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">View</th>
                        <th scope="col">Cancel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $userID = $_SESSION["id"];
                        $sql = "SELECT id, date, total, status  FROM orders WHERE userID='".$userID."' ORDER BY id ASC";
                        $result = mysqli_query($db, $sql);       
                        
                        while($row = $result->fetch_assoc()) {     
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['date']; ?></td>
                        <td>£<?php echo $row['total']; ?></td>
                        <td><?php if($row['status'] == 0) { ?>
                                    <button class="btn btn-warning">Pending Review</button>
                                <?php } else if($row['status'] == 1) { ?>
                                    <button class="btn btn-info">Order Accepted</button>
                                <?php }?>
                        </td>
                        <form action="customerOrder" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="orderID" name="orderID" value="<?php echo $row['id']; ?>">
                                <td><button class="btn btn-info">View Order</button></td>
                        </form>
                        <?php if($row['status'] == 0){ echo '<form action="dashboard" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="orderID" name="orderID" value="' . $row['id'] . '">
                                <td><button class="btn btn-danger">Cancel</button></td>
                        </form>'
                        ;} else if($row['status'] == 1){
                            echo '<td><button class="btn btn-success">Completed</button></td>';
                        }?>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 

            <?php echo $orderResult; ?>

            <p>You can cancel any request at any time by pressing the cancel button next to your request.</p>
            <p>If you have recieved a price, cancelling the request will mean you will have to wait again if you choose to submit another</p>

            <section>
                <div class="content-section">
                    <footer>
                        <hr>
                        <a href="#" class="float-right" style="color:#B00020;"><i class="fas fa-fire"></i> &#169; 2021 The CSSD Company <i class="fas fa-fire"></i></a>
                    </footer>
                </div>
            </section>
        </div>
    
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>