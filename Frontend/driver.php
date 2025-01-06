<?php
require_once '../Backend/ConnectDB.php';

// Check if the session variable 'bus_number' is set
if (!isset($_SESSION['bus_number'])) {
    // Handle the case where the session variable is not set
    die("Bus number not found in session. Please log in again.");
}

$bus_number = $_SESSION['bus_number'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("
    SELECT trips.*,
           drivers.fname, drivers.lname
    FROM trips
    LEFT JOIN drivers ON trips.bus_number = drivers.bus_number
    WHERE trips.bus_number = ?
");
$stmt->bind_param("s", $bus_number);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
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
				
				<a href="AdminProfile.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
					<span class="ml-2 text-sm font-medium">My profile</span>
				</a>
				<a href="trips/Trips.php" class="flex items-center w-full h-12 px-3 mt-2 text-gray-200 bg-gray-700 rounded" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
					</svg>
					<span class="ml-2 text-sm font-medium">your trip list</span>
				</a>
				<a href="
			</div>
			<div class="flex flex-col items-center w-full mt-2 border-t border-gray-700">
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
    <h1>Trips List</h1>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Driver's Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Remaning Seats</th>
            <th>Price</th>
        </tr>
        <?php 
        
if ($result) {
    

        while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['source']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['available_seats']; ?></td>
            <td><?php echo $row['price']; ?></td>
        </tr>
        <?php } 
        }
     else {
        die("Error executing query: " . $conn->error);
    }?>
    </table>
</div>
</body>
</html>
