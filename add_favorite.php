<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$client_info_id = intval($_POST['client_info_id']);

// Проверка, не добавлено ли уже
$check = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND client_info_id = ?");
$check->bind_param("ii", $user_id, $client_info_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO favorites (user_id, client_info_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $client_info_id);
    $stmt->execute();
}

header('Location: admin_messages.php'); // возвращаемся обратно
exit;
