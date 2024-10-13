<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyamula-logistics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $companyname = $_POST['companyname'];
    $phonenumber = $_POST['phonenumber'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO cargo_owners (name, email, password, company_name, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $email, $hashed_password, $companyname, $phonenumber);

    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page
        header("Location: ../pages/user_login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
