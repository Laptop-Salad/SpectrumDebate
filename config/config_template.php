<?php
$servername = "localhost";
$username = "<username>";
$password = "<password>";
$db = "spectrumdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Ensure connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>