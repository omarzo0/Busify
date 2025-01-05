<?php
require_once '../../../Backend/ConnectDB.php';

// Updated query to join trips and drivers tables
$query = "
    SELECT trips.*, drivers.fname, drivers.lname 
    FROM trips 
    LEFT JOIN drivers ON trips.bus_number = drivers.bus_number
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trips List</title>
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
            <a class="navigation__a" href="../AdminDashboard.php">Dashboard</a>
            <a class="navigation__a" href="../AdminProfile.php">My profile</a>
            <a class="navigation__a" href="../driver/Drivers.php">Driver list</a>
            <a class="navigation__a" href="../trips/Trips.php">Trips list</a>
            <a class="navigation__a" href="../passengers/passengers.php">Passengers list</a>
            <a class="navigation__a" href="../vehicles/vehicles.php">Vehicle list</a>
            <a href="../AdminSignIn.php">
                <button class="btnsignin-popup" onclick="logout()">Logout</button>
            </a>
        </div>
    </nav>
</header>

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Trips List</h1>
    <a href="Add_Trip.php">Add Trip</a>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Driver's Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['source']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <a href="edit_trip.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_trip.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this trip?');">Delete</a>
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
