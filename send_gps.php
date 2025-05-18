<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['lat']) || !isset($data['lng'])) {
    http_response_code(400);
    exit("Missing coordinates");
}

$lat = (float) $data['lat'];
$lng = (float) $data['lng'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET gps_lat = ?, gps_lng = ? WHERE id = ?");
$stmt->bind_param("ddi", $lat, $lng, $user_id);

if ($stmt->execute()) {
    echo "GPS updated";
} else {
    http_response_code(500);
    echo "Database error";
}
?>
