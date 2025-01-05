<?php
require_once '../../../Backend/ConnectDB.php';

$query = "SELECT f.id, f.feedback_text, f.created_at, p.fname, p.lname 
          FROM feedback f
          INNER JOIN passenger_signup p ON f.passenger_id = p.id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
    <link type="text/css" rel="stylesheet" href="../../template.css">
    <link type="text/css" rel="stylesheet" href="../css/adminDashboard.css">

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

<div class="dashboard-container">
    <h1>Feedback List</h1>
    <table>
        <tr>
            <th>Passenger Name</th>
            <th>Feedback</th>
            <th>Submitted At</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
            <td><?php echo $row['feedback_text']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
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
