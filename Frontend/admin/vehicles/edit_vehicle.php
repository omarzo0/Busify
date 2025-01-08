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
        bus_capacity = '$available_seats'
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
  <h1>Edit vehicle</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="edit_vehicle.php?id=<?php echo $id; ?>" class="edit-form">
    <div class="input__fields">
        <label for="bus_number">Bus Number: </label>
        <input class="input" type="text" id="bus_number" name="bus_number" value="<?php echo $bus['bus_number']; ?>" required>
        </div>
        <div class="input__fields">

        <label for="source">Bus Model: </label>
        <input class="input" type="text" id="source" name="bus_model" value="<?php echo $bus['bus_model']; ?>" required>
        </div>
        <div class="input__fields">

        <label for="destination">Bus Color: </label>
        <input class="input" type="text" id="destination" name="bus_color" value="<?php echo $bus['bus_color']; ?>" required>
        </div>
        <div class="input__fields">

        <label for="available_seats">Bus Capacity: </label>
        <input class="input" type="text" id="available_seats" name="available_seats" value="<?php echo $bus['available_seats']; ?>" required>
        </div>

        <button class="submit__button" type="submit">Update vehicle</button>
    </form>
</div>

</body>
</html>
