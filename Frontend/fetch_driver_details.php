<?php
header('Content-Type: application/json');

// Database connection
require_once '../Backend/ConnectDB.php'; // Include the database connection file

$data = json_decode(file_get_contents('php://input'), true);
$bus_number = $data['bus_number'] ?? null;

// Updated query to fetch bus and driver details
$query = "
    SELECT 
        buses.bus_model,
        buses.bus_color,
        drivers.fname,
        drivers.lname,
        drivers.phone_number
    FROM buses
    LEFT JOIN drivers ON buses.bus_number = drivers.bus_number
    WHERE buses.bus_number = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $bus_number); // Use 's' for string
$stmt->execute();
$result = $stmt->get_result();

$bus_details = [];
while ($row = $result->fetch_assoc()) {
    $bus_details[] = [
        'name' => $row['fname'] . ' ' . $row['lname'],
        'phone' => $row['phone_number'],
        'bus_model' => $row['bus_model'],
        'bus_color' => $row['bus_color']
    ];
}

// Return the details as a JSON response
echo json_encode($bus_details);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
