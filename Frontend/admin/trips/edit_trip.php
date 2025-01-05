<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to get the trip and associated driver and bus details
    $query_trip = "
        SELECT trips.*, drivers.fname, drivers.lname, buses.bus_model, buses.available_seats 
        FROM trips 
        INNER JOIN drivers ON trips.bus_number = drivers.bus_number
        INNER JOIN buses ON trips.bus_number = buses.bus_number
        WHERE trips.id = '$id'
    ";
    $result_trip = mysqli_query($conn, $query_trip);
    $trip = mysqli_fetch_assoc($result_trip);

    // Query to fetch all drivers and their bus details for the dropdown
    $query_drivers = "
        SELECT drivers.bus_number, drivers.fname, drivers.lname, buses.bus_model, buses.available_seats 
        FROM drivers
        INNER JOIN buses ON drivers.bus_number = buses.bus_number
    ";
    $result_drivers = mysqli_query($conn, $query_drivers);
}

if (isset($_POST['update'])) {
    // Fetch form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $busno = $_POST['bus_number'];

    // Update query
    $query = "
        UPDATE trips 
        SET date='$date', time='$time', source='$source', destination='$destination', price='$price', bus_number='$busno'
        WHERE id='$id'
    ";

    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Trip details updated successfully.');
            window.location.href='trips.php'; // Redirect after update
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error updating trip.');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip</title>
    <link rel="stylesheet" href="../../template.css">
    <link rel="stylesheet" href="../../SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
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

    <div class="trip__form__page">
        <form action="" method="POST">
            <div class="input__fields">
                <label for="date">Date</label>
                <input class="input" type="date" id="date" name="date" value="<?php echo htmlspecialchars($trip['date']); ?>" required>
            </div>
            <div class="input__fields">
                <label for="time">Time</label>
                <input class="input" type="time" id="time" name="time" value="<?php echo htmlspecialchars($trip['time']); ?>" required>
            </div>
            <div class="input__fields">
                <label for="source">Source</label>
                <input class="input" type="text" id="source" name="source" value="<?php echo htmlspecialchars($trip['source']); ?>" required>
            </div>
            <div class="input__fields">
                <label for="destination">Destination</label>
                <input class="input" type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($trip['destination']); ?>" required>
            </div>
            <div class="input__fields">
                <label for="price">Price</label>
                <input class="input" type="number" id="price" name="price" value="<?php echo htmlspecialchars($trip['price']); ?>" required>
            </div>
            <div class="input__fields">
                <label for="bus_number">Driver and Bus</label>
                <select class="input" id="bus_number" name="bus_number" required>
                    <option value="">Select Driver and Bus</option>
                    <?php while ($driver = mysqli_fetch_assoc($result_drivers)) { ?>
                        <option value="<?php echo $driver['bus_number']; ?>" <?php echo ($trip['bus_number'] === $driver['bus_number']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($driver['fname'] . " " . $driver['lname'] . " - " . $driver['bus_number'] . " (" . $driver['bus_model'] . ", Seats: " . $driver['available_seats'] . ")"); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" name="update">Update Trip</button>
        </form>
    </div>
    <script>
        function logout() {
            sessionStorage.clear();
            localStorage.clear();
        }
    </script>
</body>
</html>
