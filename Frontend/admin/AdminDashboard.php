<?php
// Database connection
require_once '../../Backend/ConnectDB.php';

// Fetch important values from the database
$queryBuses = "SELECT COUNT(*) AS total_buses FROM buses";
$queryDrivers = "SELECT COUNT(*) AS total_drivers FROM drivers";
$queryPassengers = "SELECT COUNT(*) AS total_passengers FROM passenger_signup";
$queryTrips = "SELECT COUNT(*) AS total_trips FROM trips";

$resultBuses = mysqli_query($conn, $queryBuses);
$resultDrivers = mysqli_query($conn, $queryDrivers);
$resultPassengers = mysqli_query($conn, $queryPassengers);
$resultTrips = mysqli_query($conn, $queryTrips);

$rowBuses = mysqli_fetch_assoc($resultBuses);
$rowDrivers = mysqli_fetch_assoc($resultDrivers);
$rowPassengers = mysqli_fetch_assoc($resultPassengers);
$rowTrips = mysqli_fetch_assoc($resultTrips);

$totalBuses = $rowBuses['total_buses'];
$totalDrivers = $rowDrivers['total_drivers'];
$totalPassengers = $rowPassengers['total_passengers'];
$totalTrips = $rowTrips['total_trips'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link type="text/css" rel="stylesheet" href="../template.css">
    <link type="text/css" rel="stylesheet" href="../SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="css/adminDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
<header>
    <nav class="navigation">
        <img class="logo" src="../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
            <a class="navigation__a" href="Drivers.php">driver list</a>
            <a class="navigation__a" href="trips/Trips.php">trips list</a>
            <a href="AdminSignIn.php">
    <button class="btnsignin-popup" onclick="logout()">Logout</button>
</a>
        </div>
    </nav>
</header>

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    
    <!-- Pie Charts Section -->
    <div class="chart-container">
        <canvas id="busesChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="driversChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="passengersChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="tripsChart"></canvas>
    </div>
</div>

<footer id="footer">
        <div class="footer">
            <div class="frame">
                <div class="footer__quick__links">
                    <a class="footer__a" href="indec.php">Home</a>
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

<script>
    // Data for the charts (from PHP)
    var busesData = <?php echo $totalBuses; ?>;
    var driversData = <?php echo $totalDrivers; ?>;
    var passengersData = <?php echo $totalPassengers; ?>;
    var tripsData = <?php echo $totalTrips; ?>;

    // Buses Chart (Pie chart)
    var ctxBuses = document.getElementById('busesChart').getContext('2d');
    new Chart(ctxBuses, {
        type: 'pie',
        data: {
            labels: ['Buses'],
            datasets: [{
                label: 'Total Buses',
                data: [busesData],
                backgroundColor: ['rgba(54, 162, 235, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        }
    });

    // Drivers Chart (Pie chart)
    var ctxDrivers = document.getElementById('driversChart').getContext('2d');
    new Chart(ctxDrivers, {
        type: 'pie',
        data: {
            labels: ['Drivers'],
            datasets: [{
                label: 'Total Drivers',
                data: [driversData],
                backgroundColor: ['rgba(255, 99, 132, 0.6)'],
                borderColor: ['rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        }
    });

    // Passengers Chart (Pie chart)
    var ctxPassengers = document.getElementById('passengersChart').getContext('2d');
    new Chart(ctxPassengers, {
        type: 'pie',
        data: {
            labels: ['Passengers'],
            datasets: [{
                label: 'Total Passengers',
                data: [passengersData],
                backgroundColor: ['rgba(75, 192, 192, 0.6)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        }
    });

    // Trips Chart (Pie chart)
    var ctxTrips = document.getElementById('tripsChart').getContext('2d');
    new Chart(ctxTrips, {
        type: 'pie',
        data: {
            labels: ['Trips'],
            datasets: [{
                label: 'Total Trips',
                data: [tripsData],
                backgroundColor: ['rgba(153, 102, 255, 0.6)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        }
    });
    function logout() {
        sessionStorage.clear();  
        localStorage.clear();  

    }
</script>

</body>

</html>
