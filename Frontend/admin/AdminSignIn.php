<?php
require_once '../../Backend/ConnectDB.php';

if (isset($_POST['submit'])) {
    // Get the email and password from the POST data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the admin exists in the database
    $user_exist_query = "SELECT * FROM admin_signup WHERE email = '$email'";
    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify if the entered password matches the stored password
            if (password_verify($password, $user['password'])) {
                // Start the session and redirect to the dashboard if the password is correct
                session_start();
                $_SESSION['admin_id'] = $user['id']; // Store user info in session if needed
                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='AdminDashboard.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Incorrect password!');
                    window.location.href='AdminSignIn.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('Admin not found.');
                window.location.href='AdminSignIn.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Error in database query.');
            window.location.href='AdminSignIn.php';
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
    <title>Admin Sign In</title>
    <link type="text/css" rel="stylesheet" href="../template.css">
    <link type="text/css" rel="stylesheet" href="../SignUpSignIn.css">
</head>
<body>
<header>
    <nav class="navigation">
        <img class="logo" src="../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
            <a class="navigation__a" href="../../index.php">Home</a>
        </div>
    </nav>
</header>

<div class="driver__signin__page">
    <form id="form" action="" method="POST" onsubmit="return validateInputs();">
        <div class="input__fields">
            <label for="email">Email</label>
            <input class="input" type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="password__fields">
            <div class="input__fields">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="Password" required>
            </div>
        </div>

        <button class="submit__button" type="submit" name="submit">Sign In</button>
    </form>
</div>

<footer id="footer">
    <div class="footer">
        <div class="frame">
            <div class="footer__quick__links">
                <a class="footer__a" href="index.php">Home</a>
                <a class="footer__a" href="#about__us">About Us</a>
                <a class="footer__a" href="#">Privacy Policy</a>
                <a class="footer__a" href="Frontend/DriverSignIn.php">Sign in as a Driver</a>
                <a class="footer__a" href="Frontend/PassengerSignIn.php">Sign in as a Passenger</a>
            </div>
            <div class="footer__quick__links">
                <a class="footer__a" href="#">FAQ</a>
                <a class="footer__a" href="#">Contact Us</a>
                <a class="footer__a" href="#">Terms</a>
                <a class="footer__a" href="Frontend/DriverSignUp.php">Sign up as a Driver</a>
                <a class="footer__a" href="Frontend/PassengerSignUp.php">Sign up as a Passenger</a>
            </div>
            <div>
                <p class="footer__a">Follow Us On</p>
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
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <p>All Rights Reserved &copy; 2025</p>
    </div>
</footer>
</body>
</html>
