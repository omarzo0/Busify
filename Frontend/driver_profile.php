<?php
// Include database connection
require_once '../Backend/ConnectDB.php';

// Fetch admin data
$bus_number = $_SESSION['bus_number'];
$query = "SELECT * FROM drivers WHERE bus_number = '$bus_number'";
$result = mysqli_query($conn, $query);
$driver = mysqli_fetch_assoc($result);

// Handle form submission for updating the profile
if (isset($_POST['update'])) {
    // Escape and sanitize user inputs
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validate password confirmation
    if (!empty($password) && $password === $cpassword) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $Chashed_password = password_hash($cpassword, PASSWORD_DEFAULT);
    } elseif (!empty($password)) {
        echo "<script>
                alert('Passwords do not match.');
                window.history.back();
              </script>";
        exit();
    }

    // Prepare update query for drivers table
    $stmt1 = $conn->prepare("
        UPDATE drivers 
        SET fname = ?, lname = ?, phone_number = ?, email = ?, address = ? 
        WHERE bus_number = ?
    ");
    $stmt1->bind_param("ssssss", $fname, $lname, $phone, $email, $address, $bus_number);

    // Execute the first update query
    if (!$stmt1->execute()) {
        echo "<script>
                alert('Error updating drivers table: " . $stmt1->error . "');
                window.history.back();
              </script>";
        exit();
    }

    // Prepare update query for driver_signup table
    if (!empty($password)) {
        $update_query_2 = "
            UPDATE driver_signup 
            SET fname = ?, lname = ?, email = ?, bus_number = ?, password = ? , cpassword = ?
            WHERE bus_number = ?";
        $stmt2 = $conn->prepare($update_query_2);
        $stmt2->bind_param("sssssss", $fname, $lname, $email, $bus_number, $hashed_password, $Chashed_password, $bus_number);
    } else {
        $update_query_2 = "
            UPDATE driver_signup 
            SET fname = ?, lname = ?, email = ?, bus_number = ? 
            WHERE bus_number = ?";
        $stmt2 = $conn->prepare($update_query_2);
        $stmt2->bind_param("sssss", $fname, $lname, $email, $bus_number, $bus_number);
    }

    // Execute the second update query
    if ($stmt2->execute()) {
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'driver_profile.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating driver_signup table: " . $stmt2->error . "');
                window.history.back();
              </script>";
    }

    // Close the prepared statements
    $stmt1->close();
    $stmt2->close();

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <link type="text/css" rel="stylesheet" href="../frontend/admin/css/global.css">
    <link type="text/css" rel="stylesheet" href="../frontend/css/driver/driverprofile.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>
<body >
<!-- Component Start -->
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

<div class="profile__page">
    <form action="" method="POST">
    <h1>Driver Profile</h1>

        <div class="input__fields">
            <label for="fname">First Name: </label>
            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($driver['fname']); ?>">
        </div>

        <div class="input__fields">
            <label for="lname">Last Name: </label>
            <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($driver['lname']); ?>" >
        </div>

        <div class="input__fields">
            <label for="phone">Phone: </label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($driver['phone_number']); ?>" >
        </div>

        <div class="input__fields">
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($driver['email']); ?>" >
        </div>

        <div class="input__fields">
            <label for="email">Bus Number: </label>
            <input type="text" id="email" name="bus_number" value="<?php echo htmlspecialchars($driver['bus_number']); ?>" readonly >
        </div>

        <div class="input__fields">
            <label for="email">Address: </label>
            <input type="text" id="email" name="address" value="<?php echo htmlspecialchars($driver['address']); ?>" >
        </div>

        <div class="input__fields">
            <label for="email">Password: </label>
            <input type="text" id="email" name="password">
        </div>

        <div class="input__fields">
            <label for="email">Confirm Password: </label>
            <input type="text" id="email" name="cpassword">
        </div>

        <button class="submit__button" type="submit" name="update" value = "<?php echo $row['bus_number']; ?>">Update Profile</button>
    </form>
</div>

</body>
</html>
