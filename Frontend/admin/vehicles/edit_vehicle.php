<?php
require_once '../../../Backend/ConnectDB.php';

$id = $_GET['id']; 
$query = "SELECT * FROM buses WHERE bus_number = $id";
$result = mysqli_query($conn, $query);
$bus = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $bus_number = mysqli_real_escape_string($conn, $_POST['bus_number']);
    $bus_color = mysqli_real_escape_string($conn, $_POST['bus_color']);
    $bus_model = mysqli_real_escape_string($conn, $_POST['bus_model']);
    $available_seats = mysqli_real_escape_string($conn, $_POST['available_seats']);

    $update_query = "UPDATE buses SET 
        bus_number = '$bus_number', 
        bus_color = '$bus_color', 
        bus_model = '$bus_model',
        available_seats = '$available_seats'
        WHERE bus_number = $id";

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
        <label for="bus_number">Bus Number: </label>
        <input type="text" id="bus_number" name="bus_number" value="<?php echo $bus['bus_number']; ?>" required>

        <label for="source">Bus Model: </label>
        <input type="text" id="source" name="bus_model" value="<?php echo $bus['bus_model']; ?>" required>

        <label for="destination">Bus Color: </label>
        <input type="text" id="destination" name="bus_color" value="<?php echo $bus['bus_color']; ?>" required>

        <label for="available_seats">Bus Capacity: </label>
        <input type="text" id="available_seats" name="available_seats" value="<?php echo $bus['available_seats']; ?>" required>

        <button type="submit">Update vehicle</button>
    </form>
</div>

</body>
</html>
