<?php
require_once '../Backend/ConnectDB.php';

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Check if the user is a passenger
        $stmt = $conn->prepare("SELECT passenger_id, password FROM passenger_signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['id'] = $row['passenger_id'];
                header("Location: Search&Track.php");
                exit;
            } else {
                echo "<script>alert('Password is incorrect!');</script>";
            }
        } else {
            // Check if the user is a driver
            $stmt = $conn->prepare("SELECT email, bus_number, cpassword FROM driver_signup WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['cpassword'];

                if (password_verify($password, $hashedPassword)) {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['bus_number'] = $row['bus_number'];
                    header("Location: driver.php");
                    exit;
                } else {
                    echo "<script>alert('Password is incorrect!');</script>";
                }
            } else {
                // Check if the user is an admin
                $stmt = $conn->prepare("SELECT id, password FROM admin_signup WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hashedPassword = $row['password'];

                    if (password_verify($password, $hashedPassword)) {
                        session_start();
                        $_SESSION['admin_id'] = $row['id'];
                        header("Location: ./admin/AdminDashboard.php");
                        exit;
                    } else {
                        echo "<script>alert('Password is incorrect! from the admin side');</script>";
                    }
                } else {
                    echo "<script>alert('Email is incorrect or not registered!');</script>";
                }
            }
        }

        $stmt->close();
    } else {
        echo "<script>alert('Email and password fields cannot be empty!');</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busify</title>
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
                    <a href="../Frontend\PassengerSignUp.php"><button class="btnsignin-popup">Sign Up</button></a>
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
                <div class="password__details">
                    <div class="input__fields">
                        <label for="email">Email</label>
                        <input class="input" type="email" id="email" name="email" placeholder="Your email.." required>
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
     
                </div>
                <div>

                    <div class="google__signin">
                        <div>
                            <button class="submit__button" type="submit" name="submit">Sign In</button>
                        </div>
                        <div class="password__details">
                            <p>Are You Don't Have An Account? <a href="PassengerSignUp.php">Sign Up</a></p>
                        </div>
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

