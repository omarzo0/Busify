<?php
require_once '../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM driver_signup WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Driver deleted successfully.');
            window.location.href='drivers.php'; 
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error deleting driver.');
        </script>
        ";
    }
}
?>
