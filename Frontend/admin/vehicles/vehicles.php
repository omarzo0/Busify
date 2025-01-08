<?php
require_once '../../../Backend/ConnectDB.php';

// Updated query to join the `drivers` table and `buses` table
$query = "
    SELECT 
        buses.bus_number, 
        buses.bus_model, 
        buses.bus_color, 
        buses.bus_capacity, 
        drivers.fname, 
        drivers.lname 
    FROM 
        buses 
    LEFT JOIN 
        drivers 
    ON 
        buses.bus_number = drivers.bus_number
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle List</title>
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
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

<div class="dashboard-container">
    <h1>Vehicle List</h1>
    <a class="but11" href="add_vehicle.php">Add vehicle</a>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Driver's Name</th>
            <th>Bus Model</th>
            <th>Bus Color</th>
            <th>Bus Capacity</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['bus_model']; ?></td>
            <td><?php echo $row['bus_color']; ?></td>
            <td><?php echo $row['bus_capacity']; ?></td>
            <td>
                <a href="edit_vehicle.php?id=<?php echo $row['bus_number']; ?>">Edit</a>
                <a href="delete_vehicle.php?id=<?php echo $row['bus_number']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
