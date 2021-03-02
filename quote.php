<?php
    // Initialize the session
    session_start();

    $result = "";
    
    // Include the database connection
    require_once "static/connect.php";

    // Only run the code if the form has been submitted
    if(!empty($_POST)) {
        // Check if the user is logged in or not
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            // Get all the information passed from the form
            
            //add utility type var
            $rooms     = $_POST["rooms"];
            $residents = $_POST["residents"];
            $utility  = $_POST["utility"];
            $location  = $_POST["location"];
            $notes     = $_POST["notes"];

            // Get the user's id from the login session
            $userID = $_SESSION["id"];

            // Insert the data into the quotes database 
            $sql = "INSERT INTO quotes (userID, rooms, residents, location, notes, utilityType) VALUES ('".$userID."', '".$rooms."', '".$residents."', '".$location."', '".$notes."', '".$utility."')";
            
            // If the insert is successful send a success message, otherwise error
            if ($db->query($sql) === TRUE) {
                $result = "<p class='result'>Your quote request has been submitted. We aim to respond within 24 hours. Check the progress on your dashboard.</p>";
            } 
            else {
            $result = "<p class='result'>There was an unexpected error, please try again!</p>";
            }

            // Close the connection to the database
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

        <link rel="stylesheet" href="css/homepage.css">
        <link rel="stylesheet" href="css/quote.css">
        <link rel="icon" type="image/png" href="img/favicon.png">

        <title>Quote | The CSSD Company</title>
    </head>

    <body>
        <div class="container" id="layout">
            <section id="navbar">
                <div class="content-section">
                <nav class="navbar navbar-expand-lg fixed-top">
                    <a class="navbar-brand" href="/" activeclassname="active">The CSSD Company</a>
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav">
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="quote" activeclassname="active">GET QUOTE</a></li>
                            <li class="nav-item"><a class="nav-link" href="index#about">ABOUT</a></li>
                            <li class="nav-item"><a class="nav-link" href="index#contact">CONTACT</a></li>

                            <!-- Display login or dashboard depening on if the user is logged in or not. -->
                            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                                <li class="nav-item"><a class="nav-link" href="dashboard">DASHBOARD</a></li>
                                <li class="nav-item"><a class="nav-link" href="logout">LOGOUT</a></li>
                            <?php } else { ?>
                                <li class="nav-item"><a class="nav-link" href="login">LOG IN</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
                </div>
            </section>

            <section id="quote">
                <div class="quote-container">
                    <h1>Get a Quick Quote</h1>
                    <p>Fill out the form to get an estimate to the monthly cost.</p>
                    <hr>
                    <div class="quote-form">
                        <form action="quote" method="post" class="form-group" style="width: 100%"> 
                            <div class="roomsSlider">
                                <input type="range" min="1" max="50" value="5" class="slider" id="rooms" name="rooms" />
                                <p>Number of Rooms: <span id="roomNumber"></span></p>
                            </div>
                            <hr>
                            <div class="peopleSlider">
                                <input type="range" min="1" max="20" value="2" class="slider" id="residents" name="residents" />
                                <p>Number of Residents: <span id="residentsNumber"></span></p>
                            </div>
                            <hr>
                            <div class="utility-select">
                                <label for="utility">Choose a utility type:</label>
                                <select id="utility" name="utility">
                                        <option>Energy</option>
                                        <option>Gas</option>
                                </select>
                            </div>
                            </hr>
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
                            <div class="quote-notes">
                                <p>Enter notes about your home:</p>
                                <textarea id="notes" name="notes" rows="4" cols="60" placeholder="Enter any notes about your home here. Be as descriptive as possible so we can give you an accurate quote."></textarea>
                            </div>
                            <hr>
                            <div class="estimate">
                                <h3 id="estimate-amount">Your Estimate: <span class="price">£49.90</span> Per Month</h3>
                                <button type="submit" class="btn btn-success">Submit Quote</button>
                                <?php echo $result; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section>
                <div class="content-section">
                    <footer>
                        <hr>
                        <a href="#" class="float-right"><i class="fas fa-fire"></i> &#169; 2021 The CSSD Company <i class="fas fa-fire"></i></a>
                    </footer>
                </div>
            </section>            
        </div>

        <script src="js/quote.js"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                // Transition effect for navbar 
                $(window).scroll(function() {
                // checks if window is scrolled more than 500px, adds/removes solid class
                if($(this).scrollTop() > 10) { 
                    $('.navbar').addClass('solid');
                } else {
                    $('.navbar').removeClass('solid');
                }
                });
            });
        </script>        
    </body>
</html>