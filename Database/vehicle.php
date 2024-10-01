<?php
// addVehicle.php - Adds a vehicle for a transporter
header('Content-Type: application/json');
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['transporter_id'], $data['vehicle_number'], $data['vehicle_type'], $data['capacity'])) {
    $transporter_id = $data['transporter_id'];
    $vehicle_number = $data['vehicle_number'];
    $vehicle_type = $data['vehicle_type'];
    $capacity = $data['capacity'];

    // Insert vehicle into vehicles table
    $stmt = $conn->prepare("INSERT INTO vehicles (transporter_id, vehicle_number, vehicle_type, capacity, available) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("issd", $transporter_id, $vehicle_number, $vehicle_type, $capacity);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Vehicle added successfully',
            'vehicle_id' => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error adding vehicle'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data'
    ]);
}

$conn->close();
?>
