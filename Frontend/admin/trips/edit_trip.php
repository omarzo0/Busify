<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM trips WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    // Fetch form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $driver_id = $_POST['driver_id'];
    $busno = $_POST['busno'];

    // Update query
    $query = "UPDATE trips SET date='$date', time='$time', source='$source', destination='$destination', price='$price', driver_id='$driver_id', busno='$busno' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Trip details updated successfully.');
            window.location.href='view_trips.php'; // Redirect after update
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

    <div class="trip__form__page">
        <form action="" method="POST">
            <div class="input__fields">
                <label for="date">Date</label>
                <input class="input" type="date" id="date" name="date" value="<?php echo $trip['date']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="time">Time</label>
                <input class="input" type="time" id="time" name="time" value="<?php echo $trip['time']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="source">Source</label>
                <input class="input" type="text" id="source" name="source" value="<?php echo $trip['source']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="destination">Destination</label>
                <input class="input" type="text" id="destination" name="destination" value="<?php echo $trip['destination']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="price">Price</label>
                <input class="input" type="number" id="price" name="price" value="<?php echo $trip['price']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="driver_id">Driver</label>
                <select class="input" id="driver_id" name="driver_id" required>
                    <option value="">Select Driver</option>
                    <?php while ($driver = mysqli_fetch_assoc($result_drivers)) { ?>
                        <option value="<?php echo $driver['id']; ?>" <?php echo ($driver['id'] == $trip['driver_id']) ? 'selected' : ''; ?>>
                            <?php echo $driver['busno']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input__fields">
                <label for="busno">Bus Number</label>
                <input class="input" type="text" id="busno" name="busno" value="<?php echo $trip['busno']; ?>" required>
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
