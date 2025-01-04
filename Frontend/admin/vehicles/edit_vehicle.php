<?php
require_once '../../../Backend/ConnectDB.php';

$id = $_GET['id']; 
$query = "SELECT * FROM buses WHERE id = $id";
$result = mysqli_query($conn, $query);
$bus = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $bus_number = mysqli_real_escape_string($conn, $_POST['bus_number']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $available_seats = mysqli_real_escape_string($conn, $_POST['available_seats']);

    $update_query = "UPDATE buses SET 
        bus_number = '$bus_number', 
        source = '$source', 
        destination = '$destination', 
        time = '$time', 
        date = '$date', 
        price = '$price', 
        available_seats = '$available_seats'
        WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: ../vehicles/vehicles.php?message=Bus updated successfully");
        exit;
    } else {
        $error = "Error updating bus: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit vehicle</title>
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
    <h1>Edit vehicle</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="edit_vehicle.php?id=<?php echo $id; ?>" class="edit-form">
        <label for="bus_number">vehicle Number:</label>
        <input type="text" id="bus_number" name="bus_number" value="<?php echo $bus['bus_number']; ?>" required>

        <label for="source">Source:</label>
        <input type="text" id="source" name="source" value="<?php echo $bus['source']; ?>" required>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" value="<?php echo $bus['destination']; ?>" required>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" value="<?php echo $bus['time']; ?>" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $bus['date']; ?>" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $bus['price']; ?>" required>

        <label for="available_seats">Available Seats:</label>
        <input type="text" id="available_seats" name="available_seats" value="<?php echo $bus['available_seats']; ?>" required>

        <button type="submit">Update vehicle</button>
    </form>
</div>

</body>
</html>
