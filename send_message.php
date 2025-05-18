<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Ошибка: неверный метод запроса");
}

$receiver_id = $_POST['receiver_id'] ?? null;
$message = $_POST['message'] ?? null;

if (!$receiver_id || !$message) {
    die("Ошибка: не заполнены все поля");
}

// Проверка, что получатель существует
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $receiver_id);
$stmt->execute();
if (!$stmt->get_result()->num_rows) {
    die("Ошибка: получатель не найден");
}

// Отправка сообщения
$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $_SESSION['user_id'], $receiver_id, $message);
$stmt->execute();

header("Location: chat.php?user_id=$receiver_id");
exit;
?>