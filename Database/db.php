<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'nymaula-logistics';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $company = $_POST['company'];
    $phone = $_POST['phone'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO cargo_owners (name, email, password, company, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $company, $phone);

    if ($stmt->execute()) {
        // Registration successful
        header("Location: /pages/user_login.html");
        exit();
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>