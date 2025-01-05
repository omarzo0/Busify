<?php
require_once '../../../Backend/ConnectDB.php';

// Updated query to join the `drivers` table and `buses` table
$query = "
    SELECT 
        buses.bus_number, 
        buses.bus_model, 
        buses.bus_color, 
        buses.available_seats, 
        drivers.fname, 
        drivers.lname 
    FROM 
        buses 
    LEFT JOIN 
        drivers 
    ON 
        buses.bus_number = drivers.bus_number
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle List</title>
    <link type="text/css" rel="stylesheet" href="../../template.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
</head>
<body>
<header>
<nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
        <a class="navigation__a" href="../AdminDashboard.php">Dashboard</a>
        <a class="navigation__a" href="../AdminProfile.php">My profile</a>
            <a class="navigation__a" href="../driver/Drivers.php">Driver List</a>
            <a class="navigation__a" href="../trips/Trips.php">Trips List</a>
            <a class="navigation__a" href="../passengers/passengers.php">Passengers List</a>
            <a class="navigation__a" href="../vehicles/vehicles.php">Vehicle List</a>
            <a href="../AdminSignIn.php">
    <button class="btnsignin-popup" onclick="logout()">Logout</button>
</a>
        </div>
        </nav>
</header>

<div class="dashboard-container">
    <h1>Vehicle List</h1>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Driver's Name</th>
            <th>Bus Model</th>
            <th>Bus Color</th>
            <th>Bus Capacity</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['bus_model']; ?></td>
            <td><?php echo $row['bus_color']; ?></td>
            <td><?php echo $row['available_seats']; ?></td>
            <td>
                <a href="edit_vehicle.php?id=<?php echo $row['bus_number']; ?>">Edit</a>
                <a href="delete_vehicle.php?id=<?php echo $row['bus_number']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
