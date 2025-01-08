<?php
// Include database connection
require_once '../../Backend/ConnectDB.php';



// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo "<script>
            alert('Please log in first!');
            window.location.href='AdminSignIn.php';
          </script>";
    exit;
}

// Fetch admin data
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_signup WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    echo "<script>
            alert('Admin not found!');
            window.location.href='AdminSignIn.php';
          </script>";
    exit;
}

// Handle form submission for updating the profile
if (isset($_POST['update'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check for duplicate email
    $check_email_query = "SELECT id FROM admin_signup WHERE email = '$email' AND id != '$admin_id'";
    $email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($email_result) > 0) {
        echo "<script>
                alert('Email already exists. Please use another email.');
              </script>";
    } else {
        // Update query
        $update_query = "UPDATE admin_signup 
                         SET fname = '$fname', lname = '$lname', phone = '$phone', email = '$email'
                         WHERE id = '$admin_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>
                    alert('Profile updated successfully!');
                    window.location.href='AdminDashboard.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating profile: " . mysqli_error($conn) . "');
                  </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    
    <link type="text/css" rel="stylesheet" href="css/sidebar.css">
    <link type="text/css" rel="stylesheet" href="css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>
<body>
<aside class="sidebar">
    <div class="sidebar-header">
      <img src="../Supportive Files/logo.png" alt="logo" />
      <h2>Busify</h2>
    </div>
    <ul class="sidebar-links">
    
      <li>
        <a href="AdminDashboard.php">
          <span class="material-symbols-outlined"></span>Dashboard</a>
      </li>
      <li>
        <a href="AdminProfile.php"><span class="material-symbols-outlined"></span>My profile</a>
      </li>
      <li>
        <a href="driver/Drivers.php"><span class="material-symbols-outlined"></span>driver list</a>
      </li>
     
      <li>
        <a  href="trips/Trips.php"><button><span class="material-symbols-outlined"></span></button>Trip List</a>
      </li>
      <li>
        <a  href="passengers/passengers.php"><button><span class="material-symbols-outlined"></span></button>passengers list</a>
      </li>
      <li>
        <a href="vehicles/vehicles.php"><button><span class="material-symbols-outlined"></span></button>vehicle List</a>
      </li>
      <li>
        <a href="passengerSignIn.php"><button><span class="material-symbols-outlined"></span></button>Logout</a>
      </li>
    </ul>
  </aside>

<div class="profile__page">
    <form action="" method="POST">
    <h1>Admin Profile</h1>

        <div class="input__fields">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($admin['fname']); ?>">
        </div>

        <div class="input__fields">
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($admin['lname']); ?>" >
        </div>

        <div class="input__fields">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($admin['phone']); ?>" >
        </div>

        <div class="input__fields">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" >
        </div>

        <button class="submit__button" type="submit" name="update">Update Profile</button>
    </form>
</div>

</body>
</html>
