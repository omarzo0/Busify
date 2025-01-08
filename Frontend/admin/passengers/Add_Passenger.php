<?php
require_once '../../../Backend/ConnectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Validate form data
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($cpassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $cpassword) {
        $error = "Passwords do not match.";
    } else {
        // Insert into database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $chashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin_signup (fname, lname, phone, email, password, cpassword)
                  VALUES ('$fname', '$lname', '$phone', '$email', '$hashedPassword', '$chashed')";

        if (mysqli_query($conn, $query)) {
            $success = "Passenger added successfully.";
        } else {
            $error = "Error adding passenger: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Passenger</title>
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
  <h1>Add Passenger</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } elseif (!empty($success)) { ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php } ?>
    <form method="POST" action="Add_Passenger.php" class="add-form">
    <div class="input__fields">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>
    </div>
    <div class="input__fields">

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>
        </div>
        <div class="input__fields">

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        </div>
        <div class="input__fields">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        </div>
        <div class="input__fields">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        </div>
        <div class="input__fields">

        <label for="cpassword">Confirm Password:</label>
        <input type="password" id="cpassword" name="cpassword" required>
        </div>

        <button class="submit__button" type="submit">Add Passenger</button>
    </form>
</div>

</body>
</html>
