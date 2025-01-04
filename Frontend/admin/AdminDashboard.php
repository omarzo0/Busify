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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="flex">

<!-- Component Start -->
<div class="flex flex-col items-center w-60 h-screen bg-gray-900 text-gray-400 rounded">
<a class="flex items-center w-full px-3 mt-3" href="#">
        <img class="logo" src="../Supportive Files/logo.png" alt="Logo">
			<span class="ml-2 text-sm font-bold">Busify</span>
		</a>
		<div class="w-full px-2">
			<div class="flex flex-col items-center w-full mt-3 border-t border-gray-700">
				<a href="AdminDashboard.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
					</svg>
					<span class="ml-2 text-sm font-medium">Dasboard</span>
				</a>
				<a href="AdminProfile.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
					<span class="ml-2 text-sm font-medium">My profile</span>
				</a>
				<a href="driver/Drivers.php" class="flex items-center w-full h-12 px-3 mt-2 text-gray-200 bg-gray-700 rounded" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
					</svg>
					<span class="ml-2 text-sm font-medium">driver list</span>
				</a>
				<a href="trips/Trips.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
					</svg>
					<span class="ml-2 text-sm font-medium">trips list</span>
				</a>
			</div>
			<div class="flex flex-col items-center w-full mt-2 border-t border-gray-700">
				<a href="passengers/passengers.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
					</svg>
					<span class="ml-2 text-sm font-medium">passengers list</span>
				</a>
				<a href="vehicles/vehicles.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
					</svg>
					<span class="ml-2 text-sm font-medium">vehicle list</span>
				</a>
				<a href="AdminSignIn.php" class="relative flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
					</svg>
					<button onclick="logout()" class="ml-2 text-sm font-medium">Logout</button>
					<span class="absolute top-0 left-0 w-2 h-2 mt-2 ml-2 bg-indigo-500 rounded-full"></span>
				</a>
			</div>
		</div>
	</div>
	<!-- Component End  -->

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
