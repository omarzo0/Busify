<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM trips WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "
        <script>
            alert('Trip deleted successfully.');
            window.location.href='../trips/trips.php'; 
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error deleting trip.');
        </script>
        ";
    }
}
?>
