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
