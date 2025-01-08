<?php
require_once 'Backend/ConnectDB.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUSIFY</title>
    <link   rel="stylesheet" href="frontend/css/global.css">
    <link   rel="stylesheet" href="frontend/css/index.css">

</head>
<body>

<!--===============================================Header Start===============================================================-->
    <header>
        <nav class="navigation">
            <img class="logo" src="Frontend\Supportive Files\logo name.png" alt="Logo">
                <div class="header__quick__links">
                    <a class="navigation__a" href="#">Home</a>
                    <a class="navigation__a" href="#about__us">About</a>
                    <a class="navigation__a" href="#our__services">Services</a>
                    <a class="navigation__a" href="#footer">Contact</a>                
                    <a href="Frontend\PassengerSignIn.php"><button class="btnsignin-popup">Sign In</button></a>
                </div>
        </nav>
    </header>
<!--=================================================Header End===============================================================-->

<!--=================================================About Us===============================================================-->

<!--<script src="HomePage.js"></script>-->
<div class="aboutus">
  <h2 class="home__h2">About Busify</h2>

<div class="about__us__div">        
  <div class="home__about__us">
    <p class="home__p">
      Welcome to <strong>Busify</strong>, your trusted companion for efficient and seamless bus reservations. Our mission is to revolutionize the way you book, track, and travel. With a user-friendly platform, Busify connects you to a network of reliable buses, making your travel planning effortless and stress-free.<br><br>
      At Busify, we value your time and convenience. Whether you're commuting for work, planning a family vacation, or embarking on an adventure, we ensure a smooth reservation process, real-time tracking, and secure payment options. Choose Busify for reliable service, unparalleled comfort, and a journey tailored to your needs. Your satisfaction is our drive.<br><br>
      Join the Busify family today and experience the future of bus reservations!
    </p>
  </div>
  <div>
    <img class="about__bus__img" src="Frontend\Supportive Files\HomeBushalf.png" alt="About Busify">
  </div>
</div>
</div>
<!--=================================================Our Services===============================================================-->

    <section id="our__services"></section>
        <h2 class="home__h2__ii">Our Services</h2>
            <div class="our__services__div">
                <a href="Frontend/PassengerSignIn.php">
                <div id="rating">
                    <img id="rating__img" src="Frontend\Supportive Files\OIP (3).jpg" alt="Rating">
                    <p>Rating</p>
                </div>
                </a>
                <a href="Frontend/PassengerSignIn.php">
                <div id="ticketing">
                    <img id="ticketing__img" src="Frontend\Supportive Files\OIP (2).jpg" alt="Ticketing">
                    <p>Ticket Booking</p>
                </div>
                </a>
                <a href="Frontend/PassengerSignIn.php">
                <div id="tracking">
                    <img id="tracking__img" src="Frontend\Supportive Files\GPS-Tracking-Definition5.jpg" alt="Trackinh">
                    <p>Tracking</p>
                </div>
                </a>
            </div>
    

<!--=================================================Footer Area==============================================================-->
    <footer id="footer">
        <div class="footer">
            <div class="frame">
                <div class="footer__quick__links">
                    <a class="footer__a" href="indec.php">Home</a>
                    <a class="footer__a" href="#about__us">About Us</a>
                    <a class="footer__a" href="#">Privacy Policy</a>
                    <a class="footer__a" href="#">Contact Us</a>

                </div>
          
                <div class="socialmedia__container">
  <a href="#"><img class="socialmedia__logo" src="Frontend\Supportive Files\icons8-facebook-100 (1).png" alt="Facebook"></a>
  <a href="#"><img class="socialmedia__logo" src="Frontend\Supportive Files\icons8-twitter-100.png" alt="Twitter"></a>
  <a href="#"><img class="socialmedia__logo" src="Frontend\Supportive Files\icons8-instagram-100.png" alt="Instagram"></a>
  <a href="#"><img class="socialmedia__logo" src="Frontend\Supportive Files\icons8-linkedin-100.png" alt="LinkedIn"></a>
</div>

                <div class="company__detail">
                    <div>
                        <img class="footer__logo" src="Frontend\Supportive Files\Untitled Project.jpg" width="200px" height="200px" alt="Logo">
                    </div>
                    <div class="Company__Address">
                        <p>Busify Bus Tracking & Booking (Pvt) Ltd.</p>
                        <p>No. 12/3, Sample Road, Sample City.</p>
                        <p>Hotline: 12345</p>
                        <p>info@busfy.com</p>
                    </div>
                    <p>All Rights Reserved &copy; 2025</p>
                </div>
            </div>
        </div>
    </footer>
    
</body>
</html>

