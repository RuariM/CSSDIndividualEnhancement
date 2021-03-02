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

    // Initialise needed variables
    $id        = 0;
    $rooms     = 0;
    $residents = 0;
    $location  = "";
    $notes     = "";
    $date      = "";
    $status    = 0;    
    $price     = 0;

    if(!empty($_POST) && !empty($_POST["lineID"])){
    
        
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
                $id = $_POST['quoteID'];

                $sql = "SELECT * FROM quotes WHERE id='".$id."'";

                if ($result = $db -> query($sql)) {
                    $row = $result -> fetch_row();
                    $id        = $row[0];
                    $rooms     = $row[2];
                    $residents = $row[3];
                    $location  = $row[4];
                    $notes     = $row[5];
                    $date      = $row[6];
                    $price     = $row[7];
                    $status    = $row[8];
                    $utilityType = $row[10];

                    if($price == 0) {
                        $price = number_format(((float)((($rooms * 4.39) * $residents) + strlen($location)/2) * 100) / 100, 2, '.', '');
                    }
                }
                else {
                    echo "ERROR: QUOTE NOT FOUND!";
                }
            ?>
            <h2>QUOTE #<?php echo $_POST['quoteID']?> 
                <?php if($status == 0) { ?>
                    <button class="btn btn-warning">Pending Review</button>
                <?php } else if($status == 1) { ?>
                    <button class="btn btn-info">Quote Given</button>
                <?php } else { ?>
                    <button class="btn btn-success">Quote Accepted</button>
                <?php } ?>
            </h2>
            <hr>
             <div class="quote-container">

                <div class="row" style="padding-top: 15px">
                    <div class="col-md-4"><h3>Rooms</h3> <p><?php echo $rooms; ?></p></div>
                    <div class="col-md-4"><h3>Residents</h3> <p><?php echo $residents; ?></p></div>
                    <div class="col-md-4"><h3>Location</h3> <p><?php echo $location; ?></p></div>
                </div>
                <hr>
                    <h2>Utility Type: <span style="color: #007bff;"><?php echo $utilityType; ?></span> </h2>
                </hr>
                <hr>
                <h2>Estimated Price <span style="color: #4CAF50;">£<?php echo $price; ?></span></h2>
                <hr>
                <h3>Notes:</h3>
                <p><?php echo $notes; ?></p>
                <hr>
                <p>Enter price for quote (monthly cost):</p>
                <form action="processQuote" method="post" class="form-group" style="width: 100%">
                    <input type="hidden" id="quoteID" name="quoteID" value="<?php echo $id; ?>">
                    <input type="text" class="form-control price-input" placeholder="Enter price..." name="price" value="<?php echo $price; ?>">
                    <button type="submit" class="btn btn-success price-btn">Sumbit Price</button>
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
    
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>