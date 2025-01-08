<?php
require_once '../Backend/ConnectDB.php';

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $user_exist_query = "SELECT * FROM passenger_signup WHERE email = '$email'";
    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "
            <script>
                alert('User already exists.');
                window.location.href='PassengerSignIn.php';
            </script>
            ";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $confirmhashedPassword = password_hash($cpassword, PASSWORD_DEFAULT);

            $query = "INSERT INTO passenger_signup (fname, lname, phone, email, password, cpassword) VALUES ('$fname', '$lname', '$phone', '$email', '$hashedPassword', '$confirmhashedPassword')";
            if ($result = mysqli_query($conn, $query)) {
                echo "
                <script>
                    alert('User created successfully.');
                    window.location.href='Search&Track.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Cannot Run Query.');
                    window.location.href='PassengerSignUp.php';
                </script>
                ";
            }
        }
    } else {
        echo "
        <script>
            alert('Cannot Run Query.');
            window.location.href='PassengerSignUp.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busify Passenger</title>
    <link   rel="stylesheet" href="../frontend/css/global.css">
    <link   rel="stylesheet" href="../frontend/css/signup.css">
    
</head>
<body>

<!--===============================================Header Start===============================================================-->
<header>
        <nav class="navigation">
            <img class="logo" src="../Frontend\Supportive Files\logo name.png" alt="Logo">
                <div class="header__quick__links">
                    <a class="navigation__a" href="#">Home</a>
                    <a class="navigation__a" href="#our__services">Services</a>
                    <a class="navigation__a" href="#footer">Contact</a>                
                    <a href="../Frontend\PassengerSignIn.php"><button class="btnsignin-popup">Login</button></a>
                </div>
        </nav>
</header>
<!--=================================================Header End===============================================================-->
    <div class="driver__signin__page">
        <div>
            <img class="bus__img" src="Supportive Files\HomeBus.png" alt="Bus">
        </div>
        <div class="driver__signin__details">
        <form id="form" action="" method="POST" onsubmit="return validateInputs();">
                <div class="names">
                    <div class="input__fields">
                        <label for="fname">First Name</label>
                        <input class="input" type="text" id="fname" name="fname" placeholder="Your name.." required>
                        <div class="error"></div>
                    </div>
                    <div class="input__fields">
                        <label for="lname">Last Name</label>
                        <input class="input" type="text" id="lname" name="lname" placeholder="Your last name.." required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="input__fields">
                    <label for="phone">Phone Number</label>
                    <input class="input" type="tel" id="phone" name="phone" placeholder="Your phone number.." required>
                    <div class="error"></div>
                </div>                

                <div class="password__details">              
                    <div class="input__fields">
                        <label for="email">Email</label>
                        <input class="input" type="text" id="email" name="email" placeholder="Your email.." required>
                        <div class="error"></div>
                    </div>
                    <div class="input__fields">
                        <label for="password">Password</label>
                        <input class="input" type="password" id="password" name="password" placeholder="Your password.." required>
                        <div id="error_password" class="error"></div>
                    </div>
                    <div class="input__fields">
                        <label for="cpassword">Confirm Password</label>
                        <input class="input" type="password" id="cpassword" name="cpassword" placeholder="Confirm password.." required>
                        <div class="error"></div><br>
                        <div class="error" id="form-errors"></div>
                    </div> 
                </div>
                    <div class="google__signin">
                     
                        <div>
                            <button class="submit__button" type="submit" name="submit">Sign Up</button>
                        </div>
                        <div class="password__details">
                            <p>Are You Don't Have An Account? <a href="PassengerSignIn.php">Login</a></p>
                        </div>
                    </div>          
            </form>
        </div>        
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
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-facebook-100 (1).png" alt="Facebook"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-twitter-100.png" alt="Twitter"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-instagram-100.png" alt="Instagram"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-linkedin-100.png" alt="LinkedIn"></a>
</div>

                <div class="company__detail">
                    <div>
                        <img class="footer__logo" src="../Frontend\Supportive Files\Untitled Project.jpg" width="200px" height="200px" alt="Logo">
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

