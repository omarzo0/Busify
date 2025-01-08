<?php
require_once '../../../Backend/ConnectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $bus_number = mysqli_real_escape_string($conn, $_POST['bus_number']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $available_seats = mysqli_real_escape_string($conn, $_POST['available_seats']);

    // Validate form data
    if (empty($bus_number) || empty($source) || empty($destination) || empty($available_seats)) {
        $error = "All fields are required.";
    } else {
        // Insert into database
        $query = "INSERT INTO buses (bus_number, bus_model, bus_color, bus_capacity)
                  VALUES ('$bus_number', '$source', '$destination', '$available_seats')";

        if (mysqli_query($conn, $query)) {
            $success = "Bus added successfully.";
        } else {
            $error = "Error adding bus: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add vehicle</title>
    <link type="text/css" rel="stylesheet" href="../../template.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
    <link rel="stylesheet" href="../../SignUpSignIn.css">

</head>
<body>
<header>
<nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
        <a class="navigation__a" href="../AdminDashboard.php">Dashboard</a>
        <a class="navigation__a" href="../AdminProfile.php">My profile</a>
            <a class="navigation__a" href="../driver/Drivers.php">driver list</a>
            <a class="navigation__a" href="../trips/Trips.php">trips list</a>
            <a class="navigation__a" href="../passengers/passengers.php">passengers list</a>
            <a class="navigation__a" href="../vehicles/vehicles.php">vehicle list</a>
            <a href="../AdminSignIn.php">
    <button class="btnsignin-popup" onclick="logout()">Logout</button>
</a>
        </div>
        </nav>
</header>

<div class="dashboard-container">
    <h1>Add Bus</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } elseif (!empty($success)) { ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php } ?>
    <form method="POST" action="../vehicles/add_vehicle.php" class="add-form">
        <label for="bus_number">Bus Number: </label>
        <input type="text" id="bus_number" name="bus_number" required>

        <label for="source">Bus Model: </label>
        <input type="text" id="source" name="source" required>

        <label for="destination">Bus Color: </label>
        <input type="text" id="destination" name="destination" required>

        <label for="available_seats">Bus Capacity: </label>
        <input type="text" id="available_seats" name="available_seats" required>

        <button type="submit">Add Bus</button>
    </form>
</div>

</body>
</html>
