<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$client_info_id = $_POST['client_info_id'] ?? null;

if ($client_info_id) {
    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND client_info_id = ?");
    $stmt->bind_param("ii", $user_id, $client_info_id);
    $stmt->execute();
}

header("Location: favorites.php");
exit;
