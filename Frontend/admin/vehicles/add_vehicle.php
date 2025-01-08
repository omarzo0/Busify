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

  <div class="driver__signup__page">
  <h1>Add Bus</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } elseif (!empty($success)) { ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php } ?>
    <form method="POST" action="../vehicles/add_vehicle.php" class="add-form">
    <div class="input__fields">

        <label for="bus_number">Bus Number: </label>
        <input type="text" id="bus_number" name="bus_number" class="input" required>
        </div>
        <div class="input__fields">

        <label for="source">Bus Model: </label>
        <input type="text" id="source" name="source" class="input" required>
        </div>
        <div class="input__fields">

        <label for="destination">Bus Color: </label>
        <input type="text" id="destination" name="destination" class="input" required>
        </div>
        <div class="input__fields">

        <label for="available_seats">Bus Capacity: </label>
        <input type="text" id="available_seats" name="available_seats" class="input" required>
        </div>

        <button class="submit__button" type="submit">Add Bus</button>
    </form>
</div>

</body>
</html>
