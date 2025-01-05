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
    <link type="text/css" rel="stylesheet" href="../../template.css">
    <link type="text/css" rel="stylesheet" href="../../SignUpSignIn.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
<header>
<nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
        <a class="navigation__a" href="../AdminDashboard.php">Dashboard</a>
        <a class="navigation__a" href="../AdminProfile.php">My profile</a>
            <a class="navigation__a" href="../driver/Drivers.php">driver list</a>
            <a class="navigation__a" href="../trips/Trips.php">trips list</a>
            <a class="navigation__a" href="../passengers/passengers.php">passengers list</a>
            <a class="navigation__a" href="../vehicles/vehicles.php">vehicle list</a>
            <a href="../AdminSignIn.php">
    <button class="btnsignin-popup" onclick="logout()">Logout</button>
</a>
        </div>
        </nav>
</header>

<!-- Admin Dashboard -->
<div class="dashboard-container">
    <h1>Driver List</h1>
    <a class="" href="Add_Driver.php">Add driver</a>
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
