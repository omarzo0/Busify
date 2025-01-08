<?php
require_once '../Backend/ConnectDB.php';

if(!empty($_SESSION['id']) || $_SESSION['login'] == true){
    $email = $_SESSION['id'];
    $sql = "SELECT fname , passenger_id FROM passenger_signup WHERE passenger_id = '$email'";
    $result = mysqli_query($conn, $sql);
    $row_in = mysqli_fetch_assoc($result);
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
    <p>Hello, <?php echo $row_in['fname']; ?>!</p>
    <a class="" href="add_feedback.php">Add Feedback</a>

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

        $bus_details = explode('|', $_POST['bus_number']);
        $bus_number = $bus_details[0];
        $trip_id = $bus_details[1];
        $passenger_id = $bus_details[2];

        // Use prepared statement for insertion
        $stmt1 = $conn->prepare("INSERT INTO reserved (trip_id, passenger_id, bus_number) VALUES (?, ?, ?)");
        $stmt1->bind_param("iss", $trip_id, $passenger_id, $bus_number); // Binding for integer, string, and string

        // Execute the prepared statement
        if ($stmt1->execute()) {
            echo "<script>
                    alert('Booking successful!');
                    window.location.href = 'Search&Track.php'; // Redirect to confirmation page or wherever appropriate
                  </script>";
        } else {
            echo "<script>
                    alert('Error in booking: " . $stmt1->error . "');
                    window.history.back();
                  </script>";
        }

        // Close the prepared statement
        $stmt1->close();

        // Update the available_seats column in the database
        $update_sql = "UPDATE trips SET available_seats = available_seats - 1 WHERE bus_number = '$bus_number' AND available_seats > 0";
        if (mysqli_query($conn, $update_sql)) {
            echo "<p>Booking successful! Seat reserved.</p>";
        } else {
            echo "<p>Booking failed. Please try again.</p>";
        }

    } else {
        $source = $_POST['source'];
$destination = $_POST['destination'];
$passenger_id = $_SESSION['id']; // Assuming passenger_id is stored in session

// Query to get the trip and associated driver and bus details, excluding trips already booked by the passenger
$query_trip = "
SELECT trips.*, drivers.fname, drivers.lname, buses.bus_model 
FROM trips 
INNER JOIN drivers ON trips.bus_number = drivers.bus_number
INNER JOIN buses ON trips.bus_number = buses.bus_number
WHERE trips.source LIKE ? 
AND trips.destination LIKE ? 
AND trips.available_seats > 0
AND trips.trip_id NOT IN (
    SELECT trip_id FROM reserved WHERE passenger_id = ?
)";

$stmt_trip = $conn->prepare($query_trip);
$source_param = "%" . $source . "%";
$destination_param = "%" . $destination . "%";

// Bind parameters for source, destination, and passenger_id (to exclude already booked trips)
$stmt_trip->bind_param("sss", $source_param, $destination_param, $passenger_id);
$stmt_trip->execute();
$result_trip = $stmt_trip->get_result();

        ?>
        <div class="head__box">
        <p>Available Buses</p>
        <?php
        // Check if results exist
        if (mysqli_num_rows($result_trip) > 0) { 
            while ($row = mysqli_fetch_assoc($result_trip)) {
                // Get the scheduled date and time
                $scheduled_date = new DateTime($row['date']);
                $formatted_date = $scheduled_date->format('m/d/Y');
                $formatter = new IntlDateFormatter('en_US', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                $formatter->setPattern('EEEE, MMMM dd, yyyy');
                $detailed_date = $formatter->format(new DateTime($row['date']));

                $time = new DateTime($row['time']);
                $formatted_time = $time->format('h:i A'); // Format time as hh:mm AM/PM
                ?>
                
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
                        <label>Date</label>
                        <input type="text" value="<?php echo $formatted_date . " (" . $detailed_date . ")"; ?>" readonly>
                    </div>
                    <div>
                        <label>Time</label>
                        <input type="text" value="<?php echo $formatted_time; ?>" readonly>
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
                            <input type="hidden" name="bus_number" value="<?php echo $row['bus_number'] . '|' . $row['trip_id'] . '|' . $row_in['passenger_id']; ?>"> <!-- Assuming passenger_id is stored in session -->
                            <button class="search__button" type="submit" name="book">Book</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
       <?php } else {
            echo '<p>No buses found for the selected route.</p>';
        }

        // Close the prepared statement
        $stmt_trip->close();
    }
}
$conn->close();
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

