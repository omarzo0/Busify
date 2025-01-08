<?php
require_once '../../../Backend/ConnectDB.php';

// Updated query to join trips and drivers tables
$query = "
    SELECT trips.*, drivers.fname, drivers.lname 
    FROM trips 
    LEFT JOIN drivers ON trips.bus_number = drivers.bus_number
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trips List</title>
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
    <link type="text/css" rel="stylesheet" href="../css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Trips List</h1>
    <a href="Add_Trip.php">Add Trip</a>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Driver's Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['source']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <a href="edit_trip.php?id=<?php echo $row['trip_id']; ?>">Edit</a> |
                <a href="delete_trip.php?id=<?php echo $row['trip_id']; ?>" onclick="return confirm('Are you sure you want to delete this trip?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<script>
    function logout() {
        sessionStorage.clear();
        localStorage.clear();
    }
</script>
</body>
</html>
