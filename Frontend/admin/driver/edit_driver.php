<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to get the trip and associated driver and bus details
    $query_trip = "
        SELECT trips.*, drivers.*, buses.* 
        FROM trips 
        INNER JOIN drivers ON trips.bus_number = drivers.bus_number
        INNER JOIN buses ON trips.bus_number = buses.bus_number
        WHERE trips.id = '$id'
    ";
    $result_trip = mysqli_query($conn, $query_trip);
    $driver = mysqli_fetch_assoc($result_trip);
}

if (isset($_POST['update'])) {
    // Fetch form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $busno = $_POST['busno'];
    $busmodel = $_POST['busmodel'];
    $buscapacity = $_POST['buscapacity'];

    // Update query
    $query = "UPDATE driver_signup SET fname='$fname', lname='$lname', phone='$phone', busno='$busno', busmodel='$busmodel', buscapacity='$buscapacity' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Driver details updated successfully.');
            window.location.href='../driver/view_drivers.php'; 
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error updating driver.');
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
    <title>Edit Driver</title>
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

    <div class="driver__signup__page">
        <form action="" method="POST">
            <div class="input__fields">
                <label for="fname">First Name</label>
                <input class="input" type="text" id="fname" name="fname" value="<?php echo $driver['fname']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="lname">Last Name</label>
                <input class="input" type="text" id="lname" name="lname" value="<?php echo $driver['lname']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="phone">Phone</label>
                <input class="input" type="text" id="phone" name="phone" value="<?php echo $driver['phone_number']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="address">Address</label>
                <input class="input" type="text" id="address" name="address" value="<?php echo $driver['address']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="email">Email</label>
                <input class="input" type="text" id="email" name="email" value="<?php echo $driver['email']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="busno">Bus No</label>
                <input class="input" type="text" id="busno" name="busno" value="<?php echo $driver['bus_number']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="busmodel">Bus Model</label>
                <input class="input" type="text" id="busmodel" name="busmodel" value="<?php echo $driver['bus_model']; ?>" required>
            </div>
            <div class="input__fields">
                <label for="buscapacity">Bus Capacity</label>
                <input class="input" type="text" id="buscapacity" name="buscapacity" value="<?php echo $driver['available_seats']; ?>" required>
            </div>
            <button class="submit__button" type="submit" name="update">Update Driver</button>
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
