<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_POST['submit'])) {
    // Fetch form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $busno = $_POST['busno'];
    $busmodel = $_POST['busmodel'];
    $buscapacity = $_POST['buscapacity'];

    // Insert driver into the database
    $query = "INSERT INTO driver_signup (fname, lname, phone, busno, busmodel, buscapacity) 
              VALUES ('$fname', '$lname', '$phone', '$busno', '$busmodel', '$buscapacity')";
    
    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Driver added successfully.');
            window.location.href='add_driver.php'; // Redirect after success
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error adding driver.');
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
    <title>Add Driver</title>
    <link rel="stylesheet" href="../../template.css">
    <link rel="stylesheet" href="../../SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="css/adminDashboard.css">

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
                <input class="input" type="text" id="fname" name="fname" required>
            </div>
            <div class="input__fields">
                <label for="lname">Last Name</label>
                <input class="input" type="text" id="lname" name="lname" required>
            </div>
            <div class="input__fields">
                <label for="phone">Phone</label>
                <input class="input" type="text" id="phone" name="phone" required>
            </div>
            <div class="input__fields">
                <label for="busno">Bus No</label>
                <input class="input" type="text" id="busno" name="busno" required>
            </div>
            <div class="input__fields">
                <label for="busmodel">Bus Model</label>
                <input class="input" type="text" id="busmodel" name="busmodel" required>
            </div>
            <div class="input__fields">
                <label for="buscapacity">Bus Capacity</label>
                <input class="input" type="text" id="buscapacity" name="buscapacity" required>
            </div>
            <button class="submit__button" type="submit" name="submit">Add Driver</button>
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
