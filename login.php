<?php
    // Initialize the session
    session_start();
    
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if($_SESSION["isAdmin"] == 0) {
            // Redirect user to user dashboard
            header("location: dashboard");
            exit;
        }
        else {
            // Redirect user to admin dashboard
            header("location: admin");
            exit;
        }
    }
    
    // Include the database connection
    require_once "static/connect.php";
    
    // Define variables and initialize with empty values
    $username = "";
    $password = "";
    $error = "";
    
    // Processing form data when form is submitted
    if(!empty($_POST)) {
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $error = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $error = "Please enter your password.";
        } else{
            $password = md5(trim($_POST["password"]));
        }
        
        // Validate credentials
        if(empty($error)){
            $sql = "SELECT id, username, password, isAdmin password FROM users WHERE username='".$username."'";

            if ($result = $db -> query($sql)) {
                $row = $result -> fetch_row();

                if($row[2] == $password) {
                    session_start();
                            
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row[0];
                    $_SESSION["username"] = $username;
                    $_SESSION["isAdmin"]  = $row[3];
                    
                    if($row[3] == 0) {
                        // Redirect user to user dashboard
                        header("location: dashboard");
                    }
                    else {
                        // Redirect user to admin dashboard
                        header("location: admin");
                    }
                }
                else {
                    $error = "Password incorrect!";
                }
                
            }
            else {
                $error = "User not found!";
            }

            // Close the connection to the database
            $db->close();
        }
    }
?>

<!DOCTYPE html>
    <head>
        <title>Login | The CSSD Company</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/87455b06e8.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="css/login.css">
        <link rel="icon" type="image/png" href="img/favicon.png">
    </head>

    <body>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row main-content bg-success text-center">
                <div class="col-md-4 text-center company__info">
                    <span class="company__logo"><h2><span class="fas fa-fire login-logo"></span></h2></span>
                    <h4 class="company_title">The CSSD Company</h4>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                    <div class="container-fluid">
                        <div class="row">
                            <h2 class="login-title">Log In</h2>
                        </div>
                        <div class="row">
                            <form action="login" method="post" class="form-group" style="width: 100%">
                                <div class="row">
                                    <input type="text" name="username" id="username" class="form__input" placeholder="Enter Username...">
                                </div>
                                <div class="row">
                                    <!-- <span class="fa fa-lock"></span> -->
                                    <input type="password" name="password" id="password" class="form__input" placeholder="Enter Password...">
                                </div>
                                <div class="row">
                                    <input type="submit" value="Submit" class="btn">
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <p class="login-error"><?php echo $error ?></p>
                        </div>
                        <div class="row">
                            <p class="login-back">Want to go back? <a href="index">Click here!</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="container-fluid text-center footer">
            <p>&#169; 2021 The CSSD Company</p>
        </div>
    </body>
</html>