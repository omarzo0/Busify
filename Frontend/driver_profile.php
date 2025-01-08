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
    <link type="text/css" rel="stylesheet" href="template.css">
    <link type="text/css" rel="stylesheet" href="../frontend/admin/css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>
<body class="flex">
<!-- Component Start -->
<div class="flex flex-col items-center w-60 h-screen bg-gray-900 text-gray-400 rounded">
<a class="flex items-center w-full px-3 mt-3" href="#">
        <img class="logo" src="../frontend/Supportive Files/logo.png" alt="Logo">
			<span class="ml-2 text-sm font-bold">Busify</span>
		</a>
		<div class="w-full px-2">
			<div class="flex flex-col items-center w-full mt-3 border-t border-gray-700">
				
				<a href="driver_profile.php" class="flex items-center w-full h-12 px-3 mt-2 text-gray-200 bg-gray-700 rounded" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
					<span class="ml-2 text-sm font-medium">My profile</span>
				</a>
				<a href="driver.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
					</svg>
					<span class="ml-2 text-sm font-medium">your trip list</span>
				</a>
            </div>
			<div class="flex flex-col items-center w-full mt-2 border-t border-gray-700">
				<a href="driver_vehicles.php" class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
					</svg>
					<span class="ml-2 text-sm font-medium">vehicle list</span>
				</a>
				<a href="AdminSignIn.php" class="relative flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300" href="#">
					<svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
					</svg>
					<button onclick="logout()" class="ml-2 text-sm font-medium">Logout</button>
					<span class="absolute top-0 left-0 w-2 h-2 mt-2 ml-2 bg-indigo-500 rounded-full"></span>
				</a>
			</div>
		</div>
</div>
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
