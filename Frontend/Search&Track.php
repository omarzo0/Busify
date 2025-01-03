<?php
require_once '../Backend/ConnectDB.php';

if(!empty($_SESSION['email'])){
    $email = $_SESSION['email'];
    $sql = "SELECT fname FROM passenger_signup WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: ../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link  type="text/css" rel="stylesheet" href="template.css">
    <link  type="text/css" rel="stylesheet" href="Search&Track.css">
</head>
<body>

<!--===============================================Header Start===============================================================-->
<header>
    <nav class="navigation">
        <img class="logo" src="Supportive Files\logo name.png" alt="Logo">
            <div class="header__quick__links">
                <a class="navigation__a" href="HomePageAfterLogIn.php">Home</a>
                <a class="navigation__a" href="HomePageAfterLogIn.php">About</a>
                <a class="navigation__a" href="HomePageAfterLogIn.php">Services</a>
                <a class="navigation__a" href="#footer">Contact</a>
                <a class="navigation__a" href="../Backend/logout.php">Logout</a>                
                <!--<button class="btnsignin-popup">Sign In</button>
                <button class="btnsignup-popup">Sign Up</button>-->
                <img class="profile__img" src="Supportive Files\R (4).jpg" alt="profile">
            </div>
    </nav>
</header>
<!--=================================================Header End===============================================================-->
<div class="welcome__user">
    <p>Hello, <?php echo $row['fname']; ?>!</p>
</div>
<div>
<form method="post">
    <div class="head__box">
        <p>Online Seat Reservation</p>
        <div class="search__box">
            <div>
                <label>From</label>
                <input type="text" name="source" placeholder="From" required>
            </div>
            <div>
                <label>To</label>
                <input type="text" name="destination" placeholder="To">
            </div>
            <div>
                <button type="submit" class="search__button">Search</button>
            </div>
        </div>
    </div>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book'])) {
        // Fetch the bus ID from the booking form
        $bus_id = $_POST['bus_id'];

        // Update the available_seats column in the database
        $update_sql = "UPDATE buses SET available_seats = available_seats - 1 WHERE id = $bus_id AND available_seats > 0";
        if (mysqli_query($conn, $update_sql)) {
            echo "<p>Booking successful! Seat reserved.</p>";
        } else {
            echo "<p>Booking failed. Please try again.</p>";
        }
    } else {
        // Fetch user input for the search form
        $source = $_POST['source'];
        $destination = $_POST['destination'];

        // Query the database
        $sql = "SELECT * FROM buses WHERE source LIKE '%$source%' AND destination LIKE '%$destination%' AND available_seats > 0";
        $result = mysqli_query($conn, $sql);?>
        <div class="head__box">
        <p>Available Buses</p>
        <?php
        // Check if results exist
        if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                
                    <div class="search__box">
                        <div>
                            <label>Bus Number</label>
                            <input type="text" value="<?php echo $row['bus_number']; ?>" readonly>
                        </div>
                        <div>
                            <label>From</label>
                            <input type="text" value="<?php echo $row['source']; ?>" readonly>
                        </div>
                        <div>
                            <label>To</label>
                            <input type="text" value="<?php echo $row['destination']; ?>" readonly>
                        </div>
                        <div>
                            <label>Time</label>
                            <input type="text" value="<?php echo $row['time']; ?>" readonly>
                        </div>
                        <div>
                            <label>Date</label>
                            <input type="text" value="<?php echo $row['date']; ?>" readonly>
                        </div>
                        <div>
                            <label>Price</label>
                            <input type="text" value="<?php echo $row['price']; ?>" readonly>
                        </div>
                        <div>
                            <label>Available Seats</label>
                            <input type="text" value="<?php echo $row['available_seats']; ?>" readonly>
                        </div>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="bus_id" value="<?php echo $row['id']; ?>">
                                <button class="search__button" type="submit" name="book">Book</button>
                            </form>
                        </div>
                    </div>
            <?php } ?>
            </div>
       <?php } else {
            echo '<p>No buses found for the selected route.</p>';
        }
    }
}
?>


    <div class="head__box">
        <p>Track Your Bus</p>
        <div class="track__box">
            <div>
                <label>From</label>
                <input type="text" placeholder="From" required>
            </div>
            <div>
                <label>To</label>
                <input type="text" placeholder="To" required>
            </div>
            <div>
                <label>Bus Number</label>
                <input type="text" placeholder="Bus Number" required>
            </div>
            <div>
                <button class="search__button">Track</button>
            </div>
        </div>
    </div>
</div>

<!--=================================================Footer Area==============================================================-->
    <footer id="footer">
        <div class="footer">
            <div class="frame">
                <div class="footer__quick__links">
                    <a class="footer__a" href="HomePageAfterLogIn.php">Home</a>
                    <a class="footer__a" href="HomePageAfterLogIn.php">About Us</a>
                    <a class="footer__a" href="HomePageAfterLogIn.php">Privacy Policy</a>
                    <a class="footer__a" href="#DriverSignIn.php">Sign in as a Driver</a>
                    <!--<a class="footer__a" href="#">Sign in as a Passenger</a>-->
                </div>
                <div class="footer__quick__links">
                    <a class="footer__a" href="HomePageAfterLogIn.php">FAQ</a>
                    <a class="footer__a" href="#footer">Contact Us</a>
                    <a class="footer__a" href="HomePageAfterLogIn.php">Terms</a>
                    <a class="footer__a" href="DriverSignUp.php">Sign up as a Driver</a>
                    <!--<a class="footer__a" href="#">Sign up as a Passenger</a>-->
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

