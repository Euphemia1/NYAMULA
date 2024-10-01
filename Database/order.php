<?php
// createOrder.php - Create a new order (shipment)
header('Content-Type: application/json');
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cargo_owner_id'], $data['transporter_id'], $data['pickup_location_id'], $data['dropoff_location_id'], $data['cargo_description'], $data['weight'])) {
    $cargo_owner_id = $data['cargo_owner_id'];
    $transporter_id = $data['transporter_id'];
    $pickup_location_id = $data['pickup_location_id'];
    $dropoff_location_id = $data['dropoff_location_id'];
    $cargo_description = $data['cargo_description'];
    $weight = $data['weight'];

    // Insert order into orders table
    $stmt = $conn->prepare("INSERT INTO orders (cargo_owner_id, transporter_id, pickup_location_id, dropoff_location_id, cargo_description, weight, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("iiissd", $cargo_owner_id, $transporter_id, $pickup_location_id, $dropoff_location_id, $cargo_description, $weight);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Order created successfully',
            'order_id' => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error creating order'
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
