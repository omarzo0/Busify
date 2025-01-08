<?php
require_once '../Backend/ConnectDB.php';

if (!isset($_SESSION['login']) || $_SESSION['id'] != true) {
    header("Location: ../index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passenger_id = $_SESSION['id'];
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
    <link   rel="stylesheet" href="../frontend/css/global.css">
    <link   rel="stylesheet" href="../frontend/css/track.css">
</head>
<body>
<header>
    <nav class="navigation">
        <img class="logo" src="Supportive Files\logo name.png" alt="Logo">
            <div class="header__quick__links">
                    <a class="navigation__a" href="#">Home</a>
                    <a class="navigation__a" href="#our__services">Services</a>
                    <a class="navigation__a" href="#footer">Contact</a>         
                    <a class="navigation__a" href="../Backend/logout.php">Logout</a>                
            </div>
    </nav>
</header>

<div class="dashboard-container">
        <h1>Submit Feedback</h1>
        <form method="POST" action="add_feedback.php">
            <input type="hidden" name="passenger_id" value="<?php echo $_SESSION['id']; ?>"> <!-- Session ID -->
            <label for="feedback_text">Your Feedback:</label>
            <textarea name="feedback_text" id="feedback_text" rows="5" required></textarea>
            <br>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
    <footer id="footer">
        <div class="footer">
            <div class="frame">
                <div class="footer__quick__links">
                    <a class="footer__a" href="indec.php">Home</a>
                    <a class="footer__a" href="#about__us">About Us</a>
                    <a class="footer__a" href="#">Privacy Policy</a>
                    <a class="footer__a" href="#">Contact Us</a>

                </div>
          
                <div class="socialmedia__container">
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-facebook-100 (1).png" alt="Facebook"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-twitter-100.png" alt="Twitter"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-instagram-100.png" alt="Instagram"></a>
  <a href="#"><img class="socialmedia__logo" src="../Frontend\Supportive Files\icons8-linkedin-100.png" alt="LinkedIn"></a>
</div>

                <div class="company__detail">
                    <div>
                        <img class="footer__logo" src="../Frontend\Supportive Files\Untitled Project.jpg" width="200px" height="200px" alt="Logo">
                    </div>
                    <div class="Company__Address">
                        <p>Busify Bus Tracking & Booking (Pvt) Ltd.</p>
                        <p>No. 12/3, Sample Road, Sample City.</p>
                        <p>Hotline: 12345</p>
                        <p>info@busfy.com</p>
                    </div>
                    <p>All Rights Reserved &copy; 2025</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
