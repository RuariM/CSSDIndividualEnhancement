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
    $output = "";

    //set up form values
    $userID = $_SESSION["id"];
    $sql = "SELECT * FROM items";
    $result = mysqli_query($db, $sql);


    if(!empty($_POST)) {
        // Check if the user is logged in or not
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            //grab form info            
            $userID = $_SESSION["id"];

            $count = 0;
            //check if any items have been selected
            foreach(array_slice($_POST, 0, count($_POST) - 2) as $itemID => $quantity)
            {
                if($quantity > 0)
                {
                    $count++;
                }
            }
            $address = $_POST['address'];
            $total = $_POST['total'];
            $location = $_POST['location'];
            if($count > 0 && strlen($address) > 0)
            {
            $sql = "INSERT INTO orders (userID, address, total, location) VALUES ('".$userID."','".$address."','".$total."','".$location."')";
            //add order info to database
                if ($db->query($sql) === TRUE) {
                //get order id used to insert
                $order_id = $db->insert_id;
                    //only loop over items
                    foreach(array_slice($_POST, 0, count($_POST) - 2) as $itemID => $quantity)
                    { 
                        if(intval($quantity) > 0)
                        { //insert into orderlines
                            $sql = "INSERT INTO orderlines (orderID, quantity, itemID) VALUES ('".$order_id."', '".$quantity."', '".$itemID."')";
                            if($db->query($sql) === TRUE)
                            {
                                $output = "<p class='result'>Your order request has been submitted. We aim to respond within 24 hours. Check the progress on your dashboard.</p>";
                            }
                            else
                            {
                                $output = "<p class='result'>Your order request has failed!</p>";
                            }
                        }
                    }
                } 
                else {
                $output = "<p class='result'>There was an unexpected error, please try again!</p>";
                }
            }
            elseif($count == 0 || strlen($address) == 0)
            {
                $output = "<p class='result'>Please select some items or add your address!</p>";
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
                         <td>£<span class="price"><?php echo $row['price'];?></span></td>
                         <td><input class="quantity" type="number" value = "0" min="0" name=<?php echo $row['itemID']; ?>></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
                </table>
                <div class="quote-notes">
                                <p>Enter address:</p>
                                <textarea id="address" name="address" rows="4" cols="40" placeholder="Enter postage address"></textarea>
                            </div>
                            <hr>
                <div class="location-select">
                                <label for="location">Choose your location:</label>
                                <select id="location" name="location">
                                    <optgroup label="England">
                                        <option>Bedfordshire</option>
                                        <option>Berkshire</option>
                                        <option>Bristol</option>
                                        <option>Buckinghamshire</option>
                                        <option>Cambridgeshire</option>
                                        <option>Cheshire</option>
                                        <option>City of London</option>
                                        <option>Cornwall</option>
                                        <option>Cumbria</option>
                                        <option>Derbyshire</option>
                                        <option>Devon</option>
                                        <option>Dorset</option>
                                        <option>Durham</option>
                                        <option>East Riding of Yorkshire</option>
                                        <option>East Sussex</option>
                                        <option>Essex</option>
                                        <option>Gloucestershire</option>
                                        <option>Greater London</option>
                                        <option>Greater Manchester</option>
                                        <option>Hampshire</option>
                                        <option>Herefordshire</option>
                                        <option>Hertfordshire</option>
                                        <option>Isle of Wight</option>
                                        <option>Kent</option>
                                        <option>Lancashire</option>
                                        <option>Leicestershire</option>
                                        <option>Lincolnshire</option>
                                        <option>Merseyside</option>
                                        <option>Norfolk</option>
                                        <option>North Yorkshire</option>
                                        <option>Northamptonshire</option>
                                        <option>Northumberland</option>
                                        <option>Nottinghamshire</option>
                                        <option>Oxfordshire</option>
                                        <option>Rutland</option>
                                        <option>Shropshire</option>
                                        <option>Somerset</option>
                                        <option>South Yorkshire</option>
                                        <option>Staffordshire</option>
                                        <option>Suffolk</option>
                                        <option>Surrey</option>
                                        <option>Tyne and Wear</option>
                                        <option>Warwickshire</option>
                                        <option>West Midlands</option>
                                        <option>West Sussex</option>
                                        <option>West Yorkshire</option>
                                        <option>Wiltshire</option>
                                        <option>Worcestershire</option>
                                    </optgroup>
                                    <optgroup label="Wales">
                                        <option>Anglesey</option>
                                        <option>Brecknockshire</option>
                                        <option>Caernarfonshire</option>
                                        <option>Carmarthenshire</option>
                                        <option>Cardiganshire</option>
                                        <option>Denbighshire</option>
                                        <option>Flintshire</option>
                                        <option>Glamorgan</option>
                                        <option>Merioneth</option>
                                        <option>Monmouthshire</option>
                                        <option>Montgomeryshire</option>
                                        <option>Pembrokeshire</option>
                                        <option>Radnorshire</option>
                                    </optgroup>
                                    <optgroup label="Scotland">
                                        <option>Aberdeenshire</option>
                                        <option>Angus</option>
                                        <option>Argyllshire</option>
                                        <option>Ayrshire</option>
                                        <option>Banffshire</option>
                                        <option>Berwickshire</option>
                                        <option>Buteshire</option>
                                        <option>Cromartyshire</option>
                                        <option>Caithness</option>
                                        <option>Clackmannanshire</option>
                                        <option>Dumfriesshire</option>
                                        <option>Dunbartonshire</option>
                                        <option>East Lothian</option>
                                        <option>Fife</option>
                                        <option>Inverness-shire</option>
                                        <option>Kincardineshire</option>
                                        <option>Kinross</option>
                                        <option>Kirkcudbrightshire</option>
                                        <option>Lanarkshire</option>
                                        <option>Midlothian</option>
                                        <option>Morayshire</option>
                                        <option>Nairnshire</option>
                                        <option>Orkney</option>
                                        <option>Peeblesshire</option>
                                        <option>Perthshire</option>
                                        <option>Renfrewshire</option>
                                        <option>Ross-shire</option>
                                        <option>Roxburghshire</option>
                                        <option>Selkirkshire</option>
                                        <option>Shetland</option>
                                        <option>Stirlingshire</option>
                                        <option>Sutherland</option>
                                        <option>West Lothian</option>
                                        <option>Wigtownshire</option>
                                    </optgroup>
                                    <optgroup label="Northern Ireland">
                                        <option>Antrim</option>
                                        <option>Armagh</option>
                                        <option>Down</option>
                                        <option>Fermanagh</option>
                                        <option>Londonderry</option>
                                        <option>Tyrone</option>
                                    </optgroup>
                                </select>
                            </div>
                            <hr>
                <div class="orderTotal">
                        <h3 id="order-total">Order Total: <span class="total">£0.00</span></h3>
                        <button type="submit" class="btn btn-success">Submit Order</button>
                        <?php echo $output; ?>
                </div>
                
            </form>
        </div>
        <hr>
    </div>

    <script src="js/order.js"></script>

    </body>
</html>