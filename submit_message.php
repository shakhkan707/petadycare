<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "showNotification('Вы не авторизованы.', 'error');";
    exit;
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$message = $_POST['message'] ?? '';

if ($full_name && $phone_number && $date && $time && $message) {
    $stmt = $conn->prepare("INSERT INTO client_info (user_id, full_name, phone_number, date, time, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $full_name, $phone_number, $date, $time, $message);
    
    if ($stmt->execute()) {
        echo "showNotification('Сообщение отправлено успешно!');";
    } else {
        echo "showNotification('Ошибка при сохранении.', 'error');";
    }
} else {
    echo "showNotification('Пожалуйста, заполните все поля.', 'error');";
}
?>
