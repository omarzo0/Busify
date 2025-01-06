<?php
require_once '../Backend/ConnectDB.php'; // Include the database connection file

if (isset($_POST["submit"])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT email, bus_number, cpassword FROM driver_signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedpassword = $row['cpassword'];
            // Verify the password
            if (password_verify($password, $hashedpassword )) {
                $_SESSION['login'] = true;
                $_SESSION['bus_number'] = $row['bus_number'];

                // Redirect to driver dashboard
                header("Location: driver.php");
                exit;
            } else {
                echo "<script>alert('Password is incorrect!');</script>";
            }
        } else {
            echo "<script>alert('Email is incorrect or not registered!');</script>";
        }

        // Close the statement and connection
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all fields!');</script>";
    }
}

$conn->close(); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link  type="text/css" rel="stylesheet" href="template.css">
    <link  type="text/css" rel="stylesheet" href="SignUpSignIn.css">
</head>
<body>

<!--===============================================Header Start===============================================================-->
<header>
    <nav class="navigation">
        <img class="logo" src="Supportive Files\logo name.png" alt="Logo">
            <div class="header__quick__links">
                <a class="navigation__a" href="../index.php">Home</a>
                <a class="navigation__a" href="../index.php">About</a>
                <a class="navigation__a" href="../index.php">Services</a>
                <a class="navigation__a" href="#footer">Contact</a>                
                <!--<button class="btnsignin-popup">Sign In</button>-->
                <a href="DriverSignUp.php"><button class="btnsignup-popup">Sign Up</button></a>
                <!--<img class="profile__img" src="Supportive Files\R (4).jpg" alt="profile">-->
            </div>
    </nav>
</header>
<!--=================================================Header End===============================================================-->
    <div class="driver__signin__page">
        <div>
            <img class="bus__img" src="Supportive Files\HomeBus.png" alt="Bus">
        </div>
        <div class="driver__signin__details">
            <form id="form" action="DriverSignIn.php" method="POST" onsubmit="return validateInputs();">
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
                    <div class="other__opt">
                        <div class="forgot__password">
                            <a href="#"><p>Forgot Password</p></a>
                        </div>
                        <div class="remember__me">
                            <p>Remember Me</p>
                            <input class="input" type="checkbox" id="remember" name="remember">
                        </div>
                    </div>                  
                    <div>
                        <button class="submit__button" type="submit" name="submit">Sign In</button>
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
                    <a class="footer__a" href="../index.php">Home</a>
                    <a class="footer__a" href="../index.php">About Us</a>
                    <a class="footer__a" href="#">Privacy Policy</a>
                    <a class="footer__a" href="PassengerSignIn.php">Sign in as a Passenger</a>
                </div>
                <div class="footer__quick__links">
                    <a class="footer__a" href="#">FAQ</a>
                    <a class="footer__a" href="#">Contact Us</a>
                    <a class="footer__a" href="#">Terms</a>
                    <a class="footer__a" href="DriverSignUp.php">Sign up as a Driver</a>
                    <a class="footer__a" href="PassengerSignUp.php">Sign up as a Passenger</a>
                </div>
                <div>
                    <p class="footer__a">Follow Us On</p>
                    <a href="#"><img class="socialmedia__logo" src="Supportive Files\icons8-facebook-100 (1).png" alt="Facebook"></a>
                    <a href="#"><img class="socialmedia__logo" src="Supportive Files\icons8-twitter-100.png" alt="Twitter"></a>
                    <a href="#"><img class="socialmedia__logo" src="Supportive Files\icons8-instagram-100.png" alt="Instagram"></a>
                    <a href="#"><img class="socialmedia__logo" src="Supportive Files\icons8-linkedin-100.png" alt="LinkedIn"></a>
                </div>
                <div class="company__detail">
                    <div>
                        <img class="footer__logo" src="Supportive Files\Untitled Project.jpg" width="200px" height="200px" alt="Logo">
                    </div>
                    <div class="Company__Address">
                        <p>Busfy Bus Tracking & Booking (Pvt) Ltd.</p>
                        <p>No. 12/3, Sample Road, Sample City.</p>
                        <p>Hotline: 12345</p>
                        <p>info@busfy.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <p>All Rights Reserved &copy; 2020</p>
        </div>
    </footer>
</body>
</html>

