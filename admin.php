<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login");
        exit;
    }

    // Check if the user is an admin, redirect to homepage if they aren't
    if($_SESSION["isAdmin"] == 0) {
        header("location: index");
        exit;
    }

    // Include the database connection
    require_once "static/connect.php";
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
                <li><a class="active"   href="#">DASHBOARD</a></li>
                <li><a class="nav-link" href="index" activeclassname="active">HOME</a></li>
                <li><a class="nav-link" href="logout">LOGOUT</a></li>
            </ul>
        </div>

        <div class="main">
            <h2>Admin Dashboard</h2>
            <p>View all requets, and manage contact requests.</p>

            <hr>
            <h2>Open Quotes</h2>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Utility</th>
                        <th scope="col">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $sql = "SELECT id, date, status, utilityType FROM quotes WHERE complete=0";
                        $result = mysqli_query($db, $sql);       
                
                        while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['id']; ?></th>
                            <td><?php echo $row['date']; ?></td>
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
                            <form action="adminQuote" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="quoteID" name="quoteID" value="<?php echo $row['id']; ?>">
                                <td><button class="btn btn-info">View Quote</button></td>
                            </form>
                        </tr>                  
                    <?php
                        }
                    ?>  
                </tbody>
            </table>  

            <h2>Purchase Orders</h2>

            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT id, date, status  FROM orders WHERE userID=1 ORDER BY id ASC";
                        $result = mysqli_query($db, $sql);       
                        
                        while($row = $result->fetch_assoc()) {     
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php if($row['status'] == 0) { ?>
                                    <button class="btn btn-warning">Pending Review</button>
                                <?php } else if($row['status'] == 1) { ?>
                                    <button class="btn btn-info">Order Accepted</button>
                                <?php }?>
                        </td>
                        <form action="adminOrder" method="post" class="form-group" style="width: 100%">
                                <input type="hidden" id="orderID" name="orderID" value="<?php echo $row['id']; ?>">
                                <td><button class="btn btn-info">View Order</button></td>
                        </form>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
            <hr>
            <h2>Contact Messages</h2>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Need</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM contact";
                        $result = mysqli_query($db, $sql);       
                
                        while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['firstname'] . " " . $row['lastname']; ?></th>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['need']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                        </tr>                  
                    <?php
                        }
                    ?>  
                </tbody>
            </table>      

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