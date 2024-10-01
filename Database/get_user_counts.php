<?php
// getUserCounts.php - Fetches the count of Transporters and Cargo Owners
header('Content-Type: application/json');
require_once 'db.php'; // Include database connection

// Query to get count of Transporters
$transporterCountResult = $conn->query("SELECT COUNT(*) AS count FROM users WHERE userType = 'Transporter'");
$transporterCount = $transporterCountResult->fetch_assoc()['count'];

// Query to get count of Cargo Owners
$cargoOwnerCountResult = $conn->query("SELECT COUNT(*) AS count FROM users WHERE userType = 'CargoOwner'");
$cargoOwnerCount = $cargoOwnerCountResult->fetch_assoc()['count'];

// Return the counts in JSON format
echo json_encode([
    'transporterCount' => $transporterCount,
    'cargoOwnerCount' => $cargoOwnerCount
]);

$conn->close();
?>
