<?php
require_once '../../../Backend/ConnectDB.php';

$query = "SELECT * FROM drivers";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver List</title>
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

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Driver List</h1>
    <table>
    <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Bus Number</th>
        <th>Address</th>
        <th>Email</th>
        <th>Actions</th>
       
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
        <td><?php echo $row['phone_number']; ?></td>
        <td><?php echo $row['bus_number']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>
            <a href="edit_driver.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="delete_driver.php?id=<?php echo $row['id']; ?>">Delete</a>
            <a href="Add_Driver.php">Add D</a>

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
