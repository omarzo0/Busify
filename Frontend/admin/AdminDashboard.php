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
    <link type="text/css" rel="stylesheet" href="css/adminDashboard.css">
    <link type="text/css" rel="stylesheet" href="css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body >

<aside class="sidebar">
    <div class="sidebar-header">
      <img src="../Supportive Files/logo.png" alt="logo" />
      <h2>Busify</h2>
    </div>
    <ul class="sidebar-links">
    
      <li>
        <a href="AdminDashboard.php">
          <span class="material-symbols-outlined"></span>Dashboard</a>
      </li>
      <li>
        <a href="AdminProfile.php"><span class="material-symbols-outlined"></span>My profile</a>
      </li>
      <li>
        <a href="driver/Drivers.php"><span class="material-symbols-outlined"></span>driver list</a>
      </li>
     
      <li>
        <a  href="trips/Trips.php"><button><span class="material-symbols-outlined"></span></button>Trip List</a>
      </li>
      <li>
        <a  href="passengers/passengers.php"><button><span class="material-symbols-outlined"></span></button>passengers list</a>
      </li>
      <li>
        <a href="vehicles/vehicles.php"><button><span class="material-symbols-outlined"></span></button>vehicle List</a>
      </li>
      <li>
        <a href="passengerSignIn.php"><button><span class="material-symbols-outlined"></span></button>Logout</a>
      </li>
    </ul>
  </aside>
	<!-- Component End  -->

<!-- Admin Dashboard -->
<div class="dashboard-container">
    
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


<script>
    // Data for the charts (from PHP)
    var busesData = <?php echo $totalBuses; ?> || 0;
    var driversData = <?php echo $totalDrivers; ?> || 0;
    var passengersData = <?php echo $totalPassengers; ?> || 0;
    var tripsData = <?php echo $totalTrips; ?> || 0;

    // Buses Chart (Pie chart)
    var ctxBuses = document.getElementById('busesChart').getContext('2d');
    new Chart(ctxBuses, {
        type: 'pie',
        data: {
            labels: ['Buses'], // Add another slice for better visibility
            datasets: [{
                label: 'Total Buses',
                data: [busesData, 100 - busesData], // Ensure the chart has at least 2 values
                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(201, 203, 207, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(201, 203, 207, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Repeat for the other charts
    var ctxDrivers = document.getElementById('driversChart').getContext('2d');
    new Chart(ctxDrivers, {
        type: 'pie',
        data: {
            labels: ['Drivers'],
            datasets: [{
                label: 'Total Drivers',
                data: [driversData, 100 - driversData],
                backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(201, 203, 207, 0.6)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(201, 203, 207, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Passengers Chart
    var ctxPassengers = document.getElementById('passengersChart').getContext('2d');
    new Chart(ctxPassengers, {
        type: 'pie',
        data: {
            labels: ['Passengers'],
            datasets: [{
                label: 'Total Passengers',
                data: [passengersData, 100 - passengersData],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(201, 203, 207, 0.6)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(201, 203, 207, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Trips Chart
    var ctxTrips = document.getElementById('tripsChart').getContext('2d');
    new Chart(ctxTrips, {
        type: 'pie',
        data: {
            labels: ['Trips'],
            datasets: [{
                label: 'Total Trips',
                data: [tripsData, 100 - tripsData],
                backgroundColor: ['rgba(153, 102, 255, 0.6)', 'rgba(201, 203, 207, 0.6)'],
                borderColor: ['rgba(153, 102, 255, 1)', 'rgba(201, 203, 207, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    // Logout function
    function logout() {
        sessionStorage.clear();  
        localStorage.clear();  
    }
</script>


</body>

</html>
