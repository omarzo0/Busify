<?php
header('Content-Type: application/json');

// Database connection
require_once '../Backend/ConnectDB.php'; // Include the database connection file

$data = json_decode(file_get_contents('php://input'), true);
$trip_id = $data['trip_id'];

// Fetch passenger IDs from reserved table for the given trip_id
$query = "
    SELECT rs.passenger_id, ps.fname, ps.lname, ps.phone, ps.email, t.date, t.time, t.source, t.destination
    FROM reserved rs
    INNER JOIN passenger_signup ps ON rs.passenger_id = ps.passenger_id
    INNER JOIN trips t ON rs.trip_id = t.trip_id
    WHERE rs.trip_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $trip_id);
$stmt->execute();
$result = $stmt->get_result();

$passengers = [];
while ($row = $result->fetch_assoc()) {
    // Format date to mm/dd/yyyy
    $formatted_date = date("m/d/Y", strtotime($row['date']));

    // Use IntlDateFormatter to get detailed date
    $formatter = new IntlDateFormatter(
        'en_US', 
        IntlDateFormatter::FULL, 
        IntlDateFormatter::NONE
    );
    $formatter->setPattern('EEEE, MMMM dd, yyyy');
    $detailed_date = $formatter->format(new DateTime($row['date']));

    // Format time to AM/PM
    $formatted_time = date("h:i A", strtotime($row['time']));

    $passengers[] = [
        'name' => $row['fname'] . ' ' . $row['lname'],
        'phone' => $row['phone'],
        'email' => $row['email'],
        'date' => $formatted_date . " (" . $detailed_date . ")",
        'time' => $formatted_time,
        'source' => $row['source'],
        'destination' => $row['destination']
    ];
}

echo json_encode($passengers);
?>
