<?php
require_once '../Backend/ConnectDB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['passenger_id'])) {
    header("Location: ../index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passenger_id = $_SESSION['passenger_id'];
    $feedback_text = mysqli_real_escape_string($conn, $_POST['feedback_text']);

    // Validate inputs
    if (empty($feedback_text)) {
        die("Feedback text cannot be empty.");
    }

    // Insert feedback into database
    $query = "INSERT INTO feedback (passenger_id, feedback_text) VALUES ('$passenger_id', '$feedback_text')";
    if (mysqli_query($conn, $query)) {
        echo "Feedback submitted successfully!";
        header("Location: feedback_success.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link type="text/css" rel="stylesheet" href="../../template.css">
</head>
<body>
<header>
    <nav class="navigation">
        <img class="logo" src="../../Supportive Files/logo.png" alt="Logo">
        <div class="header__quick__links">
            <a class="navigation__a" href="../AdminDashboard.php">Dashboard</a>
            <a href="../AdminSignIn.php">
                <button class="btnsignin-popup" onclick="logout()">Logout</button>
            </a>
        </div>
    </nav>
</header>

<div class="dashboard-container">
        <h1>Submit Feedback</h1>
        <form method="POST" action="add_feedback.php">
            <input type="hidden" name="passenger_id" value="<?php echo $_SESSION['passenger_id']; ?>"> <!-- Session ID -->
            <label for="feedback_text">Your Feedback:</label>
            <textarea name="feedback_text" id="feedback_text" rows="5" required></textarea>
            <br>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>

<script>
    function logout() {
        sessionStorage.clear();
        localStorage.clear();
    }
</script>
</body>
</html>
