<?php
require_once '../../../Backend/ConnectDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete bus from the database
    $query = "DELETE FROM buses WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: ../vehicles/vehicles.php?message=Bus deleted successfully");
        exit;
    } else {
        echo "Error deleting bus: " . mysqli_error($conn);
    }
} else {
    header("Location: Buses.php");
    exit;
}
?>
