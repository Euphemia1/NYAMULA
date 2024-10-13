<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo Owners</title>
</head>
<body>
    <h1>The Cargo Owners</h1>
    <ol>
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

        // Query to get all cargo owners
        $sql = "SELECT name FROM cargo_owners";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . "</li>";
            }
        } else {
            echo "<li>No cargo owners found</li>";
        }

        // Close the connection
        $conn->close();
        ?>
    </ol>
</body>
</html>
