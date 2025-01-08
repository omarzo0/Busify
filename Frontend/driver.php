<?php
require_once '../Backend/ConnectDB.php';

// Check if the session variable 'bus_number' is set
if (!isset($_SESSION['bus_number'])) {
    die("Bus number not found in session. Please log in again.");
}

$bus_number = $_SESSION['bus_number'];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("
    SELECT 
        trips.*, 
        drivers.fname, 
        drivers.lname, 
        buses.bus_capacity
    FROM trips
    LEFT JOIN drivers ON trips.bus_number = drivers.bus_number
    LEFT JOIN buses ON trips.bus_number = buses.bus_number
    WHERE trips.bus_number = ?
");
$stmt->bind_param("s", $bus_number);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Close the statement and connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <link type="text/css" rel="stylesheet" href="template.css">
    <link type="text/css" rel="stylesheet" href="SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="../frontend/admin/css/adminDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
<body class="flex">

<!-- Component Start -->
<div class="flex flex-col items-center w-60 h-screen bg-gray-900 text-gray-400 rounded">
<a class="flex items-center w-full px-3 mt-3" href="#">
        <img class="logo" src="../frontend/Supportive Files/logo.png" alt="Logo">
			<span class="ml-2 text-sm font-bold">Busify</span>
		</a>
		<div class="w-full px-2">
			<div class="flex flex-col items-center w-full mt-3 border-t border-gray-700">
				
				<a href="driver_profile.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
					<span class="ml-2 text-sm font-medium">My profile</span>
				</a>
				<a href="driver.php" class="flex items-center w-full h-12 px-3 mt-2 text-gray-200 bg-gray-700 rounded" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
					</svg>
					<span class="ml-2 text-sm font-medium">your trip list</span>
				</a>
            </div>
			<div class="flex flex-col items-center w-full mt-2 border-t border-gray-700">
				<a href="driver_vehicles.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
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
        <th>Seats Reserved</th>
        <th>Remaining Seats</th>
        <th>Bus Capacity</th>
        <th>Price</th>
        <th>Profit</th>
        <th>Actions</th>
    </tr>
    <?php 
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Format time to AM/PM
            $formatted_time = date("h:i A", strtotime($row['time']));
            $formatted_date = date("m/d/Y", strtotime($row['date']));

            // Use IntlDateFormatter to get detailed date
            $formatter = new IntlDateFormatter(
                'en_US', 
                IntlDateFormatter::FULL, 
                IntlDateFormatter::NONE
            );
            $formatter->setPattern('EEEE, MMMM dd, yyyy');
            $detailed_date = $formatter->format(new DateTime($row['date']));
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['bus_number']); ?></td>
                <td><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></td>
                <td>
                    <?php echo htmlspecialchars($formatted_date); ?> <br>
                    (<?php echo htmlspecialchars($detailed_date); ?>)
                </td>
                <td><?php echo htmlspecialchars($formatted_time); ?></td>
                <td><?php echo htmlspecialchars($row['source']); ?></td>
                <td><?php echo htmlspecialchars($row['destination']); ?></td>
                <td><?php echo $seats_reserved = $row['bus_capacity'] - $row['available_seats']; ?></td>
                <td><?php echo htmlspecialchars($row['available_seats']); ?></td>
                <td><?php echo htmlspecialchars($row['bus_capacity']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo $seats_reserved * $row['price']; ?></td>

                <!--        POP UP BUTTON         -->
                <td>
    <form method="POST">
        <input type="hidden" name="details" id="tripId" value="<?php echo $row['trip_id']; ?>"> <!-- Store the trip_id -->
        <button class="search__button" type="button" id="detailsButton">Details</button>
    </form>
    
    <!-- Popup -->
    <div id="myPopup" class="popup">
        <div class="popup-content">
        <button id="printButton" class="print__button">Print</button>
        <table id="passengerDetailsTable">
                <thead>
                    <tr>
                        <th>Passenger Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Source</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Passenger details will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>
</td>

<!-- END OF POP UP -->



            </tr>
            


    <?php 
        } 
    } else { ?>
    <tr>
        <td colspan="11">No trips found for the given bus number.</td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const detailsButton = document.getElementById('detailsButton');
        const myPopup = document.getElementById('myPopup');
        const closePopup = document.getElementById('closePopup');
        const tripId = document.getElementById('tripId').value;

        // Open popup and load passenger details
        detailsButton.addEventListener('click', function () {
            fetchPassengerDetails(tripId);
            myPopup.style.display = 'block';
        });

        // Close popup when clicking outside the popup content
    window.addEventListener('click', (event) => {
        if (event.target === myPopup) {
            myPopup.style.display = 'none';
        }
    });

        // Fetch passenger details from the server
        function fetchPassengerDetails(tripId) {
            fetch('fetch_passenger_details.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ trip_id: tripId })
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#passengerDetailsTable tbody');
                tableBody.innerHTML = ''; // Clear previous data

                data.forEach(passenger => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${passenger.name}</td>
                        <td>${passenger.phone}</td>
                        <td>${passenger.email}</td>
                        <td>${passenger.date}</td>
                        <td>${passenger.time}</td>
                        <td>${passenger.source}</td>
                        <td>${passenger.destination}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching passenger details:', error));
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
    const printButton = document.getElementById('printButton');

    // Print table
    printButton.addEventListener('click', function () {
        const tableContent = document.getElementById('passengerDetailsTable').outerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Passenger Details</title>');
        printWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #ddd; padding: 8px; } th { background-color: #f2f2f2; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1>Passenger Details</h1>');
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });
});

</script>