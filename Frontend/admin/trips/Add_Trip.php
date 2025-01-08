<?php
require_once '../../../Backend/ConnectDB.php';

// Query to fetch drivers and bus details
$query_drivers = "
    SELECT 
        drivers.id AS driver_id, 
        drivers.fname, 
        drivers.lname, 
        buses.bus_number, 
        buses.available_seats, 
        buses.bus_model 
    FROM 
        drivers 
    LEFT JOIN 
        buses 
    ON 
        drivers.bus_number = buses.bus_number
";
$result_drivers = mysqli_query($conn, $query_drivers);

if (isset($_POST['submit'])) {
    // Fetch form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    list($bus_number, $available_seats) = explode('|', $_POST['bus_number']);

    // Convert time to AM/PM format
    $timeObject = DateTime::createFromFormat('H:i', $time); // Assuming input is in 24-hour format (e.g., 14:30)
    $formattedTime = $timeObject->format('h:i A'); // Convert to 12-hour format with AM/PM

    // Insert trip into the database
    $query = "INSERT INTO trips (date, time, source, destination, price, bus_number, available_seats) 
              VALUES ('$date', '$formattedTime', '$source', '$destination', '$price', '$bus_number', '$available_seats')";
    
    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Trip added successfully.');
            window.location.href='Add_Trip.php';
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
    <link type="text/css" rel="stylesheet" href="../css/Add_drive.css">
    <link type="text/css" rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-header">
      <img src="../../Supportive Files/logo.png" alt="logo" />
      <h2>Busify</h2>
    </div>
    <ul class="sidebar-links">
    
      <li>
        <a href="../AdminDashboard.php">
          <span class="material-symbols-outlined"></span>Dashboard</a>
      </li>
      <li>
        <a href="../AdminProfile.php"><span class="material-symbols-outlined"></span>My profile</a>
      </li>
      <li>
        <a href="../driver/Drivers.php"><span class="material-symbols-outlined"></span>driver list</a>
      </li>
     
      <li>
        <a  href="../trips/Trips.php"><button><span class="material-symbols-outlined"></span></button>Trip List</a>
      </li>
      <li>
        <a  href="../passengers/passengers.php"><button><span class="material-symbols-outlined"></span></button>passengers list</a>
      </li>
      <li>
        <a href="../vehicles/vehicles.php"><button><span class="material-symbols-outlined"></span></button>vehicle List</a>
      </li>
      <li>
        <a href="../passengerSignIn.php"><button><span class="material-symbols-outlined"></span></button>Logout</a>
      </li>
    </ul>
  </aside>

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
                <label for="bus_number">Driver and Bus</label>
                <select class="input" id="bus_number" name="bus_number" required>
                    <option value="">Select Driver and Bus</option>
                    <?php while ($driver = mysqli_fetch_assoc($result_drivers)) { ?>
                        <option value="<?php echo $driver['bus_number'] . '|' . $driver['available_seats']; ?>">
                            <?php echo $driver['fname'] . " " . $driver['lname'] . " - " . $driver['bus_number'] . " (" . $driver['bus_model'] . ", Seats: " . $driver['available_seats'] . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button class="submit__button" type="submit" name="submit">Add Trip</button>
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
