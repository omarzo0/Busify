<?php
// Include database connection
require_once '../Backend/ConnectDB.php';

// Check if the session variable is set
if (!isset($_SESSION['bus_number'])) {
    die("Bus number not found in session. Please log in again.");
}

$bus_number = $_SESSION['bus_number'];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("
    SELECT 
        buses.*,
        drivers.fname, 
        drivers.lname,
        drivers.phone_number
    FROM buses 
    LEFT JOIN drivers ON buses.bus_number = drivers.bus_number
    WHERE buses.bus_number = ?
");

// Bind the parameter and execute the query
$stmt->bind_param("s", $bus_number);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the driver data
$driver = $result->fetch_assoc();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>

    <link type="text/css" rel="stylesheet" href="../frontend/admin/css/global.css">
    <link type="text/css" rel="stylesheet" href="../frontend/css/driver/driverprofile.css">

</head>
<body>
<aside class="sidebar">
    <div class="sidebar-header">
      <img src="../frontend/Supportive Files/logo.png" alt="logo" />
      <h2>Busify</h2>
    </div>
    <ul class="sidebar-links">
    
      <li>
        <a href="driver_profile.php">
          <span class="material-symbols-outlined"></span>My profile</a>
      </li>
      <li>
        <a href="driver.php"><span class="material-symbols-outlined"></span>My Trip List</a>
      </li>
      <li>
        <a href="driver_vehicles.php"><span class="material-symbols-outlined"></span>Vehicle List</a>
      </li>
     
      <li>
        <a  href="passengerSignIn.php"><button><span class="material-symbols-outlined"></span></button>Log out</a>
      </li>
    </ul>
  </aside>
	<!-- Component End  -->

<div class="profile__page" style="margin-top: -200px;">
    <form>
    <h1>Vehicle Details</h1>

        <div class="input__fields">
            <label for="fname">First Name: </label>
            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($driver['fname']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="lname">Last Name: </label>
            <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($driver['lname']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="phone">Phone: </label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($driver['phone_number']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="email">Bus Number: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($driver['bus_number']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="email">Bus Color: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($driver['bus_color']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="email">Bus Model: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($driver['bus_model']); ?>" readonly>
        </div>

        <div class="input__fields">
            <label for="email">Bus Capacity: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($driver['bus_capacity']); ?>" readonly>
        </div>
    </form>
</div>

</body>
</html>
