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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];  // Get the selected role from the radio button

    if ($role === 'cargo_owner') {
        // Check in cargo_owners table
        $stmt = $conn->prepare("SELECT id, password FROM cargo_owners WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION['cargo_owner_id'] = $id;
                $_SESSION['role'] = 'cargo_owner';
                $_SESSION['email'] = $email;
                // Redirect to cargo owner dashboard
                header("Location: ../pages/cargo_dashboard.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No cargo owner found with this email.";
        }

    } elseif ($role === 'transporter') {
        // Check in transporters table
        $stmt = $conn->prepare("SELECT id, password FROM transporters WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION['transporter_id'] = $id;
                $_SESSION['role'] = 'transporter';
                $_SESSION['email'] = $email;
                // Redirect to transporter dashboard
                header("Location: transporter_dashboard.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No transporter found with this email.";
        }
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
