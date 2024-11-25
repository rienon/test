<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the username and password from the POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection (replace with your own connection parameters)
    $servername = "127.0.0.1";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "inventory_system";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query (replace 'admin' with your table name)
    $sql = "SELECT * FROM admin WHERE username = ? AND password = MD5(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        echo "Login successful. Redirecting...";
        header("Location:/inventory.html");
    } else {
        // Invalid login
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
} else {
    // If it's not a POST request, return a 405 error
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}
?>
