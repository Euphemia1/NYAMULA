<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nyamula-logistics";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $company_name = $_POST['company_name'];
    $truck_registration_number = $_POST['truck_registration_number'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO transporters (name, email, password, company_name, truck_registration_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $company_name, $truck_registration_number);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Transporter registration successful!";
        // Redirect to the login page
        header("Location: pages/user_login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
