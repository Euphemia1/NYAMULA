<?php
// signup.php - Handles user registration for transporters and cargo owners
header('Content-Type: application/json');
require_once 'db.php'; // Include database connection

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'], $data['email'], $data['password'], $data['userType'])) {
    $name = $data['name'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password
    $userType = $data['userType']; // Either 'Transporter' or 'CargoOwner'

    // Insert user into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, userType) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $userType);

    if ($stmt->execute()) {
        // Depending on the user type, insert into the respective table
        $userId = $stmt->insert_id;

        if ($userType === 'Transporter') {
            // Insert transporter-specific details
            $conn->query("INSERT INTO transporters (user_id) VALUES ($userId)");
        } elseif ($userType === 'CargoOwner') {
            // Insert cargo-owner-specific details
            $conn->query("INSERT INTO cargo_owners (user_id) VALUES ($userId)");
        }

        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'User signed up successfully',
            'user_id' => $userId
        ]);
    } else {
        // Error response
        echo json_encode([
            'success' => false,
            'message' => 'Error during signup'
        ]);
    }

    $stmt->close();
} else {
    // Invalid request response
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data'
    ]);
}

$conn->close();
?>
