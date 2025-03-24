<?php
// Database connection variables
$servername = "localhost";  // Usually 'localhost' for local servers like XAMPP
$username = "root";         // Your MySQL username (default for XAMPP is 'root')
$password = "";             // Your MySQL password (default for XAMPP is an empty string)
$dbname = "timelessmemories"; // The name of your database

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // If the connection fails, it will show the error
} else {
    // If connected successfully, you can proceed with your queries
    // echo "Connected successfully"; // Uncomment for testing the connection
}
?>
