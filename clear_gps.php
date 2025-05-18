<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET gps_lat = NULL, gps_lng = NULL WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

echo "GPS cleared";
