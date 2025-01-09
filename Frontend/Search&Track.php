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
    <link   rel="stylesheet" href="../frontend/css/global.css">
    <link   rel="stylesheet" href="../frontend/css/track.css">
    <style>
.popup {
    position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,
                    0,
                    0,
                    0.4);
            display: none;
}

/* Popup content */
.popup-content {
    background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888888;
            width: 70%;
            font-weight: bolder;
}

.print__button {
    background-color: #4CAF50; /* Green */
    color: white;
    padding: 10px 15px;
    margin-bottom: 15px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.print__button:hover {
    background-color: #45a049;
}

</style>
</head>
<body>

<!--===============================================Header Start===============================================================-->
<header>
    <nav class="navigation">
        <img class="logo" src="Supportive Files\logo name.png" alt="Logo">
            <div class="header__quick__links">
                    <a class="navigation__a" href="#">Home</a>
                    <a class="navigation__a" href="#our__services">Services</a>
                    <a class="navigation__a" href="#footer">Contact</a>         
                    <a class="navigation__a" href="../Backend/logout.php">Logout</a>                
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
                <input type="text" name="source" placeholder="From">
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

require_once '../Backend/ConnectDB.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book'])) {

        // Extract values from the input
        $bus_details = explode('|', $_POST['bus_number']);
        $bus_number = $bus_details[0];
        $trip_id = $bus_details[1];
        $passenger_id = $bus_details[2];

        // Use a prepared statement for booking
        $stmt1 = $conn->prepare("INSERT INTO reserved (trip_id, passenger_id, bus_number) VALUES (?, ?, ?)");
        $stmt1->bind_param("iss", $trip_id, $passenger_id, $bus_number);

        if ($stmt1->execute()) {
            echo "<script>
                    alert('Booking successful!');
                    window.location.href = 'Search&Track.php'; 
                  </script>";
        } else {
            echo "<script>
                    alert('Error in booking: " . $stmt1->error . "');
                    window.history.back();
                  </script>";
        }

        $stmt1->close();

        // Update available seats safely using a prepared statement
        $update_stmt = $conn->prepare("UPDATE trips SET available_seats = available_seats - 1 WHERE bus_number = ? AND available_seats > 0");
        $update_stmt->bind_param("s", $bus_number);

        if ($update_stmt->execute()) {
            echo "<p>Booking successful! Seat reserved.</p>";
        } else {
            echo "<p>Booking failed. Please try again.</p>";
        }

        $update_stmt->close();

    } else {
        // Searching trips logic
        $source = $_POST['source'] ?? ''; // Default to empty string if not set
        $destination = $_POST['destination'] ?? ''; // Default to empty string if not set

        $passenger_id = $_SESSION['id'] ?? ''; // Ensure session ID is set
        if (empty($source) && empty($destination) && empty($passenger_id)) {
            echo "<p>Missing source, destination, or passenger ID.</p>";
        } else {
            // Query for available trips
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

            $stmt_trip->bind_param("sss", $source_param, $destination_param, $passenger_id);
            $stmt_trip->execute();
            $result_trip = $stmt_trip->get_result();

        // HTML Display
        ?>
        <div class="head__box">
            <p>Available Buses</p>
            <?php if ($result_trip->num_rows > 0) { 
                while ($row = $result_trip->fetch_assoc()) {
                    $formatted_date = (new DateTime($row['date']))->format('m/d/Y');
                    $detailed_date = (new IntlDateFormatter('en_US', IntlDateFormatter::FULL, IntlDateFormatter::NONE))
                                     ->format(new DateTime($row['date']));
                    $formatted_time = (new DateTime($row['time']))->format('h:i A');
                    ?>
                    <div class="search__box">
                        <div>
                            <label>Bus Number</label>
                            <input type="text" value="<?php echo htmlspecialchars($row['bus_number']); ?>" readonly>
                        </div>
                        <div>
                            <label>From</label>
                            <input type="text" value="<?php echo htmlspecialchars($row['source']); ?>" readonly>
                        </div>
                        <div>
                            <label>To</label>
                            <input type="text" value="<?php echo htmlspecialchars($row['destination']); ?>" readonly>
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
                            <input type="text" value="<?php echo htmlspecialchars($row['price']); ?>" readonly>
                        </div>
                        <div>
                            <label>Available Seats</label>
                            <input type="text" value="<?php echo htmlspecialchars($row['available_seats']); ?>" readonly>
                        </div>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="bus_number" 
                                       value="<?php echo htmlspecialchars($row['bus_number'] . '|' . $row['trip_id'] . '|' . $_SESSION['id']); ?>">
                                <button class="search__button" type="submit" name="book">Book</button>
                            </form>
                        </div>
                        <div>
    <form method="POST">
        <input type="hidden" class="bus_number" id = "busNumber" value="<?php echo $row['bus_number']; ?>">
        <button class="detailsButton search__button" id= "detailsButton" name = "details" type="submit">Details</button>
    </form>

    <!-- Popup -->
    <div id="myPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <button id="printButton" class="print__button">Print</button>
        <form id="busDetailsForm">
            <label>
                Driver Name:
                <input type="text" id="driverName" readonly>
            </label>
            <label>
                Phone Number:
                <input type="text" id="phoneNumber" readonly>
            </label>
            <label>
                Bus Model:
                <input type="text" id="busModel" readonly>
            </label><br>
            <label>
                Bus Color:
                <input type="text" id="busColor" readonly>
            </label>
        </form>
    </div>
</div>

</div>
                    </div>
                <?php } ?>
            <?php } else {
                echo '<p>No buses found for the selected route.</p>';
            }

            $stmt_trip->close();
            ?>
        </div>
        <?php
        }
    }
}

$conn->close();
?>


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

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".detailsButton").forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent form submission

            const busNumber = button.previousElementSibling.value; // Get bus number

            // Show the popup
            const popup = document.getElementById("myPopup");
            popup.style.display = "block";

            // Fetch and display data for the bus
            fetch('fetch_driver_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ bus_number: busNumber })
            })
                .then(response => response.json())
                .then(bus_details => {
                    if (bus_details.length > 0) {
                        // Assuming only one record is fetched
                        const detail = bus_details[0];
                        document.getElementById("driverName").value = detail.name;
                        document.getElementById("phoneNumber").value = detail.phone;
                        document.getElementById("busNumber").value = detail.bus_number;
                        document.getElementById("busModel").value = detail.bus_model;
                        document.getElementById("busColor").value = detail.bus_color;
                    }
                })
                .catch(error => console.error("Error fetching details:", error));
        });
    });

    // Close popup
    document.getElementById("printButton").addEventListener("click", () => {
            window.print();
        });

    // Close popup when clicking outside the popup content
    window.addEventListener("click", (event) => {
        const popup = document.getElementById("myPopup");
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
});


</script>