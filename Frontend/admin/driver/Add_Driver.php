<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_POST['submit'])) {
    // Fetch form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $bus_number = $_POST['bus_number'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];           
    $bus_model = $_POST['bus_model'];       
    $bus_color = $_POST['bus_color'];       
    $available_seats = $_POST['available_seats']; 
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if user or bus already exists
    $user_exist_query = "SELECT bus_number, email FROM driver_signup WHERE email = '$email' OR bus_number = '$bus_number'";
    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "
            <script>
                alert('User or Bus Number already exists.');
                window.location.href='Add_Driver.php';
            </script>
            ";
        } else {
            // Hash passwords
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $confirmhashedPassword = password_hash($cpassword, PASSWORD_DEFAULT);

            // Insert driver into `driver_signup` table
            $driverSignupQuery = "INSERT INTO driver_signup (fname, lname, email, bus_number, password, cpassword) 
                                  VALUES ('$fname', '$lname', '$email', '$bus_number', '$hashedPassword', '$confirmhashedPassword')";

            // Insert driver into `drivers` table
            $driversQuery = "INSERT INTO drivers (fname, lname, phone_number, bus_number, email, address) 
                             VALUES ('$fname', '$lname', '$phone', '$bus_number', '$email', '$address')";

            // Insert bus into `buses` table
            $busesQuery = "INSERT INTO buses (bus_number, bus_model, bus_color, available_seats) 
                           VALUES ('$bus_number', '$bus_model', '$bus_color', '$available_seats')";

            // Execute queries
            if (mysqli_query($conn, $driverSignupQuery) && 
                mysqli_query($conn, $driversQuery) && 
                mysqli_query($conn, $busesQuery)) {
                echo "
                <script>
                    alert('Driver and bus added successfully.');
                    window.location.href='add_driver.php'; // Redirect after success
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Error adding driver or bus.');
                </script>
                ";
            }
        }
    } else {
        echo "
        <script>
            alert('Cannot run query.');
            window.location.href='PassengerSignUp.php';
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
                <label for="email">Email</label>
                <input class="input" type="text" id="email" name="email" required>
            </div>
            <div class="input__fields">
                <label for="address">Address</label>
                <input class="input" type="text" id="address" name="address" required>
            </div>
            <div class="input__fields">
                <label for="bus_number">Bus Number</label>
                <input class="input" type="text" id="bus_number" name="bus_number" required>
            </div>
            <div class="input__fields">
                <label for="bus_model">Bus Model</label>
                <input class="input" type="text" id="bus_model" name="bus_model" required>
            </div>
            <div class="input__fields">
                <label for="bus_color">Bus Color</label>
                <input class="input" type="text" id="bus_color" name="bus_color" required>
            </div>
            <div class="input__fields">
                <label for="available_seats">Bus Capacity</label>
                <input class="input" type="text" id="available_seats" name="available_seats" required>
            </div>
            <div class="input__fields">
                <label for="password">Password</label>
                <input class="input" type="text" id="password" name="password" required>
            </div>
            <div class="input__fields">
                <label for="cpassword">Confirm Password</label>
                <input class="input" type="text" id="cpassword" name="cpassword" required>
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
