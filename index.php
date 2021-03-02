<?php
    // Initialize the session
    // Only needed for keeping if is logged in or not
    session_start();

   // Include the database connection
   require_once "static/connect.php";

   $result = "";

   // Only run the code if the form has been submitted
   if(!empty($_POST)) {
      // Get the information passed from the contact form
      $firstname = $_POST["name"];
      $lastname  = $_POST["surname"];
      $email     = $_POST["email"];
      $need      = $_POST["need"];
      $message   = $_POST["message"];

      // Insert the contact form data into the database
      $sql = "INSERT INTO contact (firstname, lastname, email, need, message) VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$need."', '".$message."')";
        
      // If the insert is successful send a success message, otherwise error
      if ($db->query($sql) === TRUE) {
            $result = "<p class='result'>We have recieved your message! We aim to reply within 24 hours.</p>";
      } 
      else {
         $result = "<p class='result'>There was an unexpected error, please try again!</p>";
      }
   }    

   // Close the connection to the database
   $db->close();
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/87455b06e8.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/homepage.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    
    <title>The CSSD Company</title>
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
                        <li class="nav-item"><a class="nav-link" href="#about">ABOUT</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">CONTACT</a></li>

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

        <section id="intro">
           <div class="jumbotron jumbotron-fluid" id="jumbo">
              <div class="jumbotron-cell">
                 <div class="jumbotron-body">
                    <div class="jumbotron-header">
                        <h1>The CSSD Company<br>Clean Energy Provider Since 2005</h1>
                        <a href="quote"><button class="hire-btn">GET QUOTE</button></a>
                        <a href="#about"><button class="hire-btn transparent-btn">LEARN MORE</button></a>
                    </div>
                 </div>
              </div>
           </div>
        </section>

        <section id="introduction">
         <div class="content-section">
            <div class="row">
               <div class="col-md-3">
                  <div class="card">
                     <span class="svg-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="trophy" viewBox="0 0 512 545.5"><path d="M112 96c20.432 0 34.443 9.337 42 16h204c7.555-6.663 21.56-16 42-16 15.083 0 30.654 5.685 43 16.5s21 27.46 21 47.5c0 16.994-7.14 31.528-16 43s-19.62 20.576-29.5 29.5C398.74 250.35 384 265.032 384 288c0 2.425 2.392 8.33 5.5 13s6 7.5 6 7.5l-23 22.5s-5.108-5.153-10-12.5c-4.311-6.477-8.906-14.99-10-26-1.953 5.507-3.92 11.184-6 16.5-11.1 28.352-23.64 53.894-38 73-5.23 6.958-10.972 13.176-17 18.5 33.533 1.856 60.5 29.53 60.5 63.5v16H160v-16c0-33.637 26.426-61.153 59.5-63.5-5.94-5.323-11.29-11.523-16.5-18.5-14.305-19.16-26.972-44.61-38-73-1.937-4.986-3.678-10.343-5.5-15.5-1.273 10.537-5.815 18.715-10 25-4.892 7.347-10 12.5-10 12.5l-23-22.5s2.892-2.83 6-7.5 5.5-10.575 5.5-13c0-22.968-14.74-37.65-34.5-55.5-9.88-8.924-20.64-18.028-29.5-29.5s-16-26.006-16-43c0-20.04 8.654-36.685 21-47.5S96.917 96 112 96zm0 32c-6.95 0-15.354 3.115-21.5 8.5S80 148.84 80 160c0 8.687 2.86 15.552 9 23.5s15.38 16.36 25.5 25.5c9.348 8.442 19.993 17.985 28.5 29.5-8.924-36.36-14.548-73.38-15-106-3.553-2.116-8.42-4.5-16-4.5zm288 0c-7.59 0-12.45 2.384-16 4.5-.467 33.078-6.308 70.397-15.5 107 8.62-11.907 19.416-21.844 29-30.5 10.12-9.14 19.36-17.552 25.5-25.5s9-14.813 9-23.5c0-11.16-4.354-18.115-10.5-23.5S406.95 128 400 128zm-238 16c2.438 47.307 14.357 105.51 33 153.5 10.315 26.556 22.414 49.48 34 65s21.802 21.5 26.5 21.5c4.73 0 15.37-6.026 27-21.5s23.62-38.488 34-65c18.77-47.94 31.053-105.953 33.5-153.5H162zm78 48h32v80h-32v-80zm-16 240c-11.48 0-19.36 7.09-25 16h114c-5.64-8.91-13.52-16-25-16h-64z"></path></svg>
                     </span>
                     <div class="card-body">
                        <h5 class="card-title">GREAT PRICES</h5>
                        <p class="card-text">We offer fair & competitive pricing for everyone. Renewable should be cheap.</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="card">
                     <span class="svg-icon">
                     <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="certificate" viewBox="0 0 512 545.5"><path d="M256 80c9.983 0 19.968 3.405 28.5 9.5L311 108l30 4h.5c21.032 2.554 37.638 19.561 40.5 40.5.053.387.457.61.5 1h-.5l6 30 18.5 26.5c12.19 17.064 11.676 39.618.5 57.5v.5l-.5.5L388 295l-4 30 50 76 16.5 24.5H374l-18.5 43L344 496l-16.5-25-50.5-76c-13.095 6.064-28.457 5.585-42 0l-50.5 76-16.5 25-11.5-27.5-18.5-43H61.5L78 401l51.5-78.5-5-27.5-19-26.5c-12.19-17.064-11.676-40.118-.5-58v-.5l.5-.5 18.5-24 4-31v-.5l.5-.5c4.534-20.402 20.598-36.466 41-41l.5-.5h.5l30.5-4 26.5-18.5c8.532-6.095 18.517-9.5 28.5-9.5zm0 32.5c-3.666 0-7.332 1.095-10 3L217.5 136l-3.5 2.5-4 .5-33.5 4.5c-.247.055-.257.438-.5.5-7.79 2.005-13.995 8.21-16 16-.063.243-.445.253-.5.5L155 194l-.5 4.5-2.5 3-20 26c-4.824 7.72-4.31 17.165-.5 22.5l20.5 28.5 2.5 3 .5 4 6.5 36.5v1c.246 2.212 1.006 4.255 2 6 2.224 3.903 6.053 6.45 11 7h.5l35 5 4.5.5 3 2.5 26 20c7.72 4.824 17.165 4.31 22.5.5l28.5-20.5 3-2.5 4-.5 36.5-6.5h1c4.002-.444 7.192-2.272 9.5-5v-.5l1-.5c1.337-1.955 2.207-4.365 2.5-7v-.5l5-35 .5-4 2.5-3.5 20-28c4.824-7.72 4.31-16.665.5-22L360 200l-2.5-3-.5-3.5-6.5-35.5v-1c-.796-7.16-5.84-12.204-13-13h-.5l-35-5-4-.5-3.5-2.5-28.5-20.5c-2.668-1.905-6.334-3-10-3zM366.5 356c-6.544 5.165-14.402 8.824-23 10-.387.053-.61.457-1 .5v-.5l-31.5 5.5-7.5 5.5 34 52 11-25.5 4-10H391zm-221 .5l-24.5 37h38.5l4 10 11 25.5 34-51.5-7-5.5-30.5-4c-.157-.018-.343.02-.5 0-9.517-1.155-18.16-5.4-25-11.5z"></path></svg>
                     </span>
                     <div class="card-body">
                        <h5 class="card-title">AWARD WINNING</h5>
                        <p class="card-text">We've won over 10 customer consumer energy awards in the past 3 years!</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="card">
                     <span class="svg-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="cubes" viewBox="0 0 512 545.5"><path d="M256 96l6 2.5 96 38.5 10 4v107.5l86.5 37.5 9.5 4.5v129l-8 5-96 53.5-7.5 4-7.5-3.5-89-44.5-89 44.5-7.5 3.5-7.5-4-96-53.5-8-5v-129l9.5-4.5 86.5-37.5V141l10-4 96-38.5zm0 35l-52.5 20.5L256 172l52.5-20.5zm-80 44v74l64 28.5v-78zm160 0l-64 24.5v78l64-28.5v-74zM160 277l-58 25 58 29 58-28.5zm192 0l-40 17.5-18 8 58 28.5 58-29zM80 326.5V401l64 36v-78.5zm352 0l-64 32V437l64-36v-74.5zm-192 1l-64 31V438l64-32v-78.5zm32 0V406l64 32v-79.5z"></path></svg>
                     </span>
                     <div class="card-body">
                        <h5 class="card-title">SAFETY ASSURED</h5>
                        <p class="card-text">We fully comply with all UK and EU laws! Know your services are safe with us.</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="card">
                     <span class="svg-icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="connectdevelop" viewBox="0 0 512 545.5"><path d="M146.5 99h219l4.5 8 100 174.5 4.5 8-4.5 8L370 472l-4.5 8h-219l-4.5-8L42 297.5l-4.5-8 4.5-8L142 107zm39 32l25 26 73-26h-98zm146 0L223 169.5l35 36.5zm-167 1.5l-.5 1V174l30.5-11zm184.5 3l-79.5 82 57 59L391 208zm-201 26L135 184l13-4.5v-18zm58.5 14L164 191v62l23.5 25 59.5-60.5zm-58.5 21l-25.5 9-1 2L148 236v-39.5zM113 222l-38.5 67.5 38 66L148 319v-59.5zm285 2l-60.5 64 38.5 39.5zm-140 5l-59.5 61 57.5 61 59.5-63zm152.5 13.5l-20.5 99 11 11.5 36.5-63.5zm-246.5 34v26l12.5-13zm162.5 23L267 363l8.5 9H367l5.5-25.5zm-139 2L164 325v47h72l9-9zm-39.5 40L120.5 370l1.5 2h26v-30.5zm238 19l-2.5 11.5h6.5l2.5-4.5zM131 388l17 29.5V388h-17zm33 0v57.5l1 2 56-59.5h-57zm79 0l-56.5 60h138l-56-60H243zm47.5 0l56 60 7-12 10-48h-73zm89.5 0l-.5 2.5 1.5-2.5h-1z"></path></svg>
                     </span>
                     <div class="card-body">
                        <h5 class="card-title">SAVE THE PLANET</h5>
                        <p class="card-text">Start using renewable energy to lower your carbon footprint.</p>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-6">
                  <div class="ven-text">
                     <h5 class="font-weight-bold">From just £10.39 a month!</h5>
                     <h1>Renewable Energy</h1>
                     <p>Save money, and save the planet with 100% renewable energy.</p>
                     <p>We are the cheapest on the market for any energy you require. Let us do the work.</p>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="ven-img">
                     <img src="img/poster.jpg">
                  </div>
               </div>
            </div>
         </div>
      </section>

        <section id="reasons">
           <div class="content-section">
              <h1>What we're great at...</h1>
              <p>We specialise in all things renewable energy! We want to save the planet, and you should too!</p>
              <div class="row">
                 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-2">
                    <div class="card">
                       <img class="card-img-top" alt="Questing" src="img/reasons/solar.jpg">
                       <div class="card-body">
                          <h5 class="card-title">SOLAR POWER</h5>
                          <p class="card-text">We have 5 solar farms all across the UK, providing 100,000 kw/h</p>
                          <a href="quote"><button class="hire-btn">GET QUOTE</button></a>
                       </div>
                    </div>
                 </div>
                 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-2">
                    <div class="card">
                       <img class="card-img-top" alt="Runecrafting" src="img/reasons/hydro.jpg">
                       <div class="card-body">
                          <h5 class="card-title">HYDROELECTRICITY</h5>
                          <p class="card-text">Our Hydro-electric facilities have provided hundreds of jobs.</p>
                          <a href="quote"><button class="hire-btn">GET QUOTE</button></a>
                       </div>
                    </div>
                 </div>
                 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-2">
                    <div class="card">
                       <img class="card-img-top" alt="Agility" src="img/reasons/support.jpg">
                       <div class="card-body">
                          <h5 class="card-title">CUSTOMER SUPPORT</h5>
                          <p class="card-text">Our customer support teams have won awards 3 year in a row.</p>
                          <a href="quote"><button class="hire-btn">GET QUOTE</button></a>
                       </div>
                    </div>
                 </div>
                 <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-2">
                    <div class="card">
                       <img class="card-img-top" alt="Hunter" src="img/reasons/cheap.jpg">
                       <div class="card-body">
                          <h5 class="card-title">CHEAPEST AROUND</h5>
                          <p class="card-text">We're the cheapest renewable, and energy company that you'll find!</p>
                          <a href="quote"><button class="hire-btn">GET QUOTE</button></a>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </section>

        <section id="about">
         <div class="content-section">
            <div class="row">
               <div class="col-md-5">
                  <div class="main-img">
                     <img src="img/about.jpg">
                  </div>
               </div>

               <div class="col-md-7">
                  <h1>Why Choose The CSSD Company?</h1>
                  <p style="text-align: center;">We strive to be the #1 renewable energy supplier on the market. Based in Sheffield, allowing us to give you the best pricing.</p>

                  <div class="row">
                     <div class="col-md-6">
                        <span class="svg-icon">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="certificate" viewBox="0 0 512 545.5"><path d="M256 80c9.983 0 19.968 3.405 28.5 9.5L311 108l30 4h.5c21.032 2.554 37.638 19.561 40.5 40.5.053.387.457.61.5 1h-.5l6 30 18.5 26.5c12.19 17.064 11.676 39.618.5 57.5v.5l-.5.5L388 295l-4 30 50 76 16.5 24.5H374l-18.5 43L344 496l-16.5-25-50.5-76c-13.095 6.064-28.457 5.585-42 0l-50.5 76-16.5 25-11.5-27.5-18.5-43H61.5L78 401l51.5-78.5-5-27.5-19-26.5c-12.19-17.064-11.676-40.118-.5-58v-.5l.5-.5 18.5-24 4-31v-.5l.5-.5c4.534-20.402 20.598-36.466 41-41l.5-.5h.5l30.5-4 26.5-18.5c8.532-6.095 18.517-9.5 28.5-9.5zm0 32.5c-3.666 0-7.332 1.095-10 3L217.5 136l-3.5 2.5-4 .5-33.5 4.5c-.247.055-.257.438-.5.5-7.79 2.005-13.995 8.21-16 16-.063.243-.445.253-.5.5L155 194l-.5 4.5-2.5 3-20 26c-4.824 7.72-4.31 17.165-.5 22.5l20.5 28.5 2.5 3 .5 4 6.5 36.5v1c.246 2.212 1.006 4.255 2 6 2.224 3.903 6.053 6.45 11 7h.5l35 5 4.5.5 3 2.5 26 20c7.72 4.824 17.165 4.31 22.5.5l28.5-20.5 3-2.5 4-.5 36.5-6.5h1c4.002-.444 7.192-2.272 9.5-5v-.5l1-.5c1.337-1.955 2.207-4.365 2.5-7v-.5l5-35 .5-4 2.5-3.5 20-28c4.824-7.72 4.31-16.665.5-22L360 200l-2.5-3-.5-3.5-6.5-35.5v-1c-.796-7.16-5.84-12.204-13-13h-.5l-35-5-4-.5-3.5-2.5-28.5-20.5c-2.668-1.905-6.334-3-10-3zM366.5 356c-6.544 5.165-14.402 8.824-23 10-.387.053-.61.457-1 .5v-.5l-31.5 5.5-7.5 5.5 34 52 11-25.5 4-10H391zm-221 .5l-24.5 37h38.5l4 10 11 25.5 34-51.5-7-5.5-30.5-4c-.157-.018-.343.02-.5 0-9.517-1.155-18.16-5.4-25-11.5z"></path></svg>
                        </span>
                        <h4 class="font-weight-bold">CHEAP</h4>
                        <p>We believe renewable energy should be cheap. So it is, simple as that.</p>
                     </div>
                     <div class="col-md-6">
                        <span class="svg-icon">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="trophy" viewBox="0 0 512 545.5"><path d="M112 96c20.432 0 34.443 9.337 42 16h204c7.555-6.663 21.56-16 42-16 15.083 0 30.654 5.685 43 16.5s21 27.46 21 47.5c0 16.994-7.14 31.528-16 43s-19.62 20.576-29.5 29.5C398.74 250.35 384 265.032 384 288c0 2.425 2.392 8.33 5.5 13s6 7.5 6 7.5l-23 22.5s-5.108-5.153-10-12.5c-4.311-6.477-8.906-14.99-10-26-1.953 5.507-3.92 11.184-6 16.5-11.1 28.352-23.64 53.894-38 73-5.23 6.958-10.972 13.176-17 18.5 33.533 1.856 60.5 29.53 60.5 63.5v16H160v-16c0-33.637 26.426-61.153 59.5-63.5-5.94-5.323-11.29-11.523-16.5-18.5-14.305-19.16-26.972-44.61-38-73-1.937-4.986-3.678-10.343-5.5-15.5-1.273 10.537-5.815 18.715-10 25-4.892 7.347-10 12.5-10 12.5l-23-22.5s2.892-2.83 6-7.5 5.5-10.575 5.5-13c0-22.968-14.74-37.65-34.5-55.5-9.88-8.924-20.64-18.028-29.5-29.5s-16-26.006-16-43c0-20.04 8.654-36.685 21-47.5S96.917 96 112 96zm0 32c-6.95 0-15.354 3.115-21.5 8.5S80 148.84 80 160c0 8.687 2.86 15.552 9 23.5s15.38 16.36 25.5 25.5c9.348 8.442 19.993 17.985 28.5 29.5-8.924-36.36-14.548-73.38-15-106-3.553-2.116-8.42-4.5-16-4.5zm288 0c-7.59 0-12.45 2.384-16 4.5-.467 33.078-6.308 70.397-15.5 107 8.62-11.907 19.416-21.844 29-30.5 10.12-9.14 19.36-17.552 25.5-25.5s9-14.813 9-23.5c0-11.16-4.354-18.115-10.5-23.5S406.95 128 400 128zm-238 16c2.438 47.307 14.357 105.51 33 153.5 10.315 26.556 22.414 49.48 34 65s21.802 21.5 26.5 21.5c4.73 0 15.37-6.026 27-21.5s23.62-38.488 34-65c18.77-47.94 31.053-105.953 33.5-153.5H162zm78 48h32v80h-32v-80zm-16 240c-11.48 0-19.36 7.09-25 16h114c-5.64-8.91-13.52-16-25-16h-64z"></path></svg>
                        </span>
                        <h4 class="font-weight-bold">SUSTAINABLE</h4>
                        <p>All our energy comes from: Solar, Hydro, and Wind powered farms.</p>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <span class="svg-icon">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="comments" viewBox="0 0 512 545.5"><path d="M32 112h320v256H197.5L122 428.5l-26 21V368H32V112zm32 32v192h64v46.5l54-43 4.5-3.5H320V144H64zm320 32h96v256h-64v81.5L314.5 432h-149l40-32h120l58.5 46.5V400h64V208h-64v-32z"></path></svg>
                        </span>
                        <h4 class="font-weight-bold">QUALITY</h4>
                        <p>Ever worried about power outages or surges? Not here. We've been online 100% of the time 24/7.</p>
                     </div>
                     <div class="col-md-6">
                        <span class="svg-icon">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="codepen" viewBox="0 0 512 545.5"><path d="M256 77.5l9 6L457 212l7 4.5v143l-7 4.5-192 128.5-9 6-9-6L55 364l-7-4.5v-143l7-4.5L247 83.5zm-16 49l-147 99 64.5 43.5 82.5-55.5v-87zm32 0v87l82.5 55.5 64.5-43.5zm-16 115L186.5 288l69.5 46.5 69.5-46.5zM80 255v66l49-33zm352 0l-49 33 49 33v-66zm-274 52l-65 43.5 147 99v-87zm196 0l-82 55.5v87l147-99z"></path></svg>
                        </span>
                        <h4 class="font-weight-bold">GLOBAL IMPACT</h4>
                        <p>We’ve served more than 10,000,000 customers around Europe! And it's growing faster every year!</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section> 
      
      <section id="hire">
         <div class="content-section">
            <div class="row">
               <div class="col-md-6">
                  <h1 style="line-height: 52px;">Get a Quote In Seconds!</h1>
               </div>
               <div class="col-md-6">
                  <a href="quote"><button class="hire-btn">GET QUOTE!</button></a>
               </div>
            </div>
         </div>
      </section>

      <section id="testimonials">
         <div class="content-section">
            <h1>Client Testimonials</h1>
            <p>Don’t take our word for it – here’s what our clients say:</p>

            <!--Grid row-->
            <div class="row text-center">
               <!--Grid column-->
               <div class="col-md-4 mb-md-0 mb-5">
                  <div class="testimonial">
                  <!--Avatar-->
                  <div class="avatar mx-auto">
                     <img src="img/customers/1.png" class="rounded-circle z-depth-1 img-fluid">
                  </div>
                  <!--Content-->
                  <h5 class="font-weight-bold dark-grey-text mt-4">Cooper Gill</h5>
                  <p class="font-weight-normal dark-grey-text">
                     <i class="fas fa-quote-left pr-2" style="color: rgb(3, 169, 244);"></i>Found them, saved money, great service. What more is there to say? ✌️</p>
                  </div>
               </div>
               <!--Grid column-->

               <!--Grid column-->
               <div class="col-md-4 mb-md-0 mb-5">
                  <div class="testimonial">
                  <!--Avatar-->
                  <div class="avatar mx-auto">
                     <img src="img/customers/2.png" class="rounded-circle z-depth-1 img-fluid">
                  </div>
                  <!--Content-->
                  <h5 class="font-weight-bold dark-grey-text mt-4">Harry Smith</h5>
                  <p class="font-weight-normal dark-grey-text">
                     <i class="fas fa-quote-left pr-2" style="color: rgb(3, 169, 244);"></i>Massive vouch. Been with the company since 2000, and they've not let me down. Customer support is always friendly and they're only there to help. I couldn't say a bad thing about them, because they've been a part of my life for so long.</p>
                  </div>
               </div>
               <!--Grid column-->

               <!--Grid column-->
               <div class="col-md-4">
                  <div class="testimonial">
                  <!--Avatar-->
                  <div class="avatar mx-auto">
                     <img src="img/customers/3.png" class="rounded-circle z-depth-1 img-fluid">
                  </div>
                  <!--Content-->
                  <h5 class="font-weight-bold dark-grey-text mt-4">Lisa Power</h5>
                  <p class="font-weight-normal dark-grey-text">
                     <i class="fas fa-quote-left pr-2" style="color: rgb(3, 169, 244);"></i>I found out that I was paying too much for my non-renewable energy, so I decided to switch to The CSSD Company and never looked back! Renewable energy is the only thing we should be focusing on! Not only did I save money, I'm saving the planet too.</p>
                  </div>
               </div>
               <!--Grid column-->
            </div>
            <!--Grid row-->
         </div>
      </section> 
      
      <section id="contact">
         <div class="content-section">
            <h1>Contact Us</h1>
            <p>Drop us a message if you have any questions!</p>

            <form id="contact-form" method="post" action="#" role="form">
               <div class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="form_name">Firstname</label>
                           <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname" required="required" data-error="Firstname is required.">
                           <div class="help-block with-errors"></div>
                        </div>
                  </div>
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="form_lastname">Lastname</label>
                           <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname" required="required" data-error="Lastname is required.">
                           <div class="help-block with-errors"></div>
                        </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="form_email">Email</label>
                           <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email" required="required" data-error="Valid email is required.">
                           <div class="help-block with-errors"></div>
                        </div>
                  </div>
                  <div class="col-md-6">
                        <div class="form-group">
                           <label for="form_need">Please specify your need</label>
                           <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                              <option value="General Enquiry">General Enquiry</option>
                              <option value="Request quotation">Request quotation</option>
                              <option value="Request order status">Request order status</option>
                              <option value="Request copy of an invoice">Request copy of an invoice</option>
                              <option value="Other">Other</option>
                           </select>
                           <div class="help-block with-errors"></div>
                        </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                        <div class="form-group">
                           <label for="form_message">Message</label>
                           <textarea id="form_message" name="message" class="form-control" placeholder="Start typing your message..." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                           <div class="help-block with-errors"></div>
                        </div>
                  </div>
                  <div class="col-md-12">
                        <input type="submit" class="btn btn-send" style="background: #f79007; padding: 10px; font-weight: 700;" value="Send message">
                  </div>
                  <?php echo $result; ?>
               </div>
            </form>
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
          if($(this).scrollTop() > 550) { 
              $('.navbar').addClass('solid');
          } else {
              $('.navbar').removeClass('solid');
          }
        });
      });
    </script>
  </body>
</html>