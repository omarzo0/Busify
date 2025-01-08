<?php
require_once '../../../Backend/ConnectDB.php';

$query = "SELECT * FROM passenger_signup";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger list</title>
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

<!-- Passenger Dashboard -->
<div class="dashboard-container">
    <h1>Passengers List</h1>
    <a class="" href="Add_Passenger.php">Add Passenger</a>
    <a class="" href="feedback.php">Passengers Feedback</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
           
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
