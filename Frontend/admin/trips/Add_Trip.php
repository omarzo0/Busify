<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_POST['submit'])) {
    // Fetch form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];


    // Insert trip into the database
    $query = "INSERT INTO trips (date, time, source, destination, price, driver_id, busno) 
              VALUES ('$date', '$time', '$source', '$destination', '$price', '$driver_id', '$busno')";
    
    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Trip added successfully.');
            window.location.href='trips/trips.php'; //
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error adding trip.');
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
    <title>Add Trip</title>
    <link rel="stylesheet" href="../../template.css">
    <link rel="stylesheet" href="../../SignUpSignIn.css">
</head>
<body>
    <header>
    <nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
            <a class="navigation__a" href="Drivers.php">driver list</a>
            <a class="navigation__a" href="trips/Trips.php">trips list</a>
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
                <input class="input" type="date" id="date" name="date" required>
            </div>
            <div class="input__fields">
                <label for="time">Time</label>
                <input class="input" type="time" id="time" name="time" required>
            </div>
            <div class="input__fields">
                <label for="source">Source</label>
                <input class="input" type="text" id="source" name="source" required>
            </div>
            <div class="input__fields">
                <label for="destination">Destination</label>
                <input class="input" type="text" id="destination" name="destination" required>
            </div>
            <div class="input__fields">
                <label for="price">Price</label>
                <input class="input" type="number" id="price" name="price" required>
            </div>
            <div class="input__fields">
                <label for="driver_id">Driver</label>
                <select class="input" id="driver_id" name="driver_id" required>
                    <option value="">Select Driver</option>
                    <?php while ($driver = mysqli_fetch_assoc($result_drivers)) { ?>
                        <option value="<?php echo $driver['id']; ?>"><?php echo $driver['busno']; ?></option>
                    <?php } ?>
                </select>
            </div>
           
            <button class="submit__button"  type="submit" name="submit">Add Trip</button>
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
