<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function _fg_dbConnection() {
    $conn = mysqli_connect("localhost", "talxcoza_raspberry", "T5NU3HcePm7Xg5dkRmgn", "talxcoza_raspberry");
    return $conn;
}

function _fc_dbConnectionClose($conn) {
    mysqli_close($conn);
}

// Read JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!isset($data["temperature"])) {
    die("Error: Temperature data missing!");
}

// Connect to the database
$conn = _fg_dbConnection();
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare SQL statement
$temp = mysqli_real_escape_string($conn, $data["temperature"]);
$sql = "INSERT INTO cpu_temperature (temperature, timestamp) VALUES ('$temp', NOW())";

if (mysqli_query($conn, $sql)) {
    echo "Data saved successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
_fc_dbConnectionClose($conn);
?>
