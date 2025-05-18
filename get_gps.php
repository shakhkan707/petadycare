<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    http_response_code(403);
    exit("Access denied");
}

// Ищем любого активного админа с включенным GPS
$stmt = $conn->prepare("
    SELECT gps_lat, gps_lng 
    FROM users 
    WHERE role = 'admin' 
    AND gps_lat IS NOT NULL 
    AND gps_lng IS NOT NULL 
    LIMIT 1
");

$stmt->execute();
$stmt->bind_result($lat, $lng);
$stmt->fetch();
$stmt->close();

header('Content-Type: application/json');
echo json_encode(["lat" => $lat, "lng" => $lng]);
?>
