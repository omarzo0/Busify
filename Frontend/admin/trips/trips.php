<?php
require_once '../../../Backend/ConnectDB.php';

// Correct SQL query without the extra comma
$query = "SELECT * FROM trips";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the results here (if needed)
    while ($row = mysqli_fetch_assoc($result)) {
        // Process each row
        echo "Trip ID: " . $row['id'] . "<br>";
        echo "Date: " . $row['date'] . "<br>";
        echo "Time: " . $row['time'] . "<br>";
        echo "Source: " . $row['source'] . "<br>";
        echo "Destination: " . $row['destination'] . "<br>";
        echo "Price: " . $row['price'] . "<br>";
    }
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link type="text/css" rel="stylesheet" href="../../template.css">
    <link type="text/css" rel="stylesheet" href="../../SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
<header>
<nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
            <a class="navigation__a" href="../Drivers.php">driver list</a>
            <a class="navigation__a" href="../trips/Trips.php">trips list</a>
            <a href="../AdminSignIn.php">
    <button class="btnsignin-popup" onclick="logout()">Logout</button>
</a>
        </div>
    </nav>
</header>

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Trips List</h1>
    <a class="" href="Add_Trip.php">Add Trip</a>
    <table border="1">
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['time']; ?></td>
        <td><?php echo $row['source']; ?></td>
        <td><?php echo $row['destination']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td>
            <a href="trips/edit_trip.php?id=<?php echo $row['id']; ?>">Edit</a> | 
            <a href="trips/delete_trip.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this trip?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

   
</div>


<script>
    function logout() {
        sessionStorage.clear();  
        localStorage.clear();  
    }
</script>
</body>
</html>
