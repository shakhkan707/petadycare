<?php
session_start();
require 'db.php';

$current_user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user_id'] ?? null;

if (!$other_user_id) {
    exit;
}

$stmt = $conn->prepare("SELECT m.*, u.username 
                       FROM messages m 
                       JOIN users u ON m.sender_id = u.id 
                       WHERE (sender_id = ? AND receiver_id = ?) 
                       OR (sender_id = ? AND receiver_id = ?) 
                       ORDER BY sent_at ASC");
$stmt->bind_param("iiii", $current_user_id, $other_user_id, $other_user_id, $current_user_id);
$stmt->execute();
$messages = $stmt->get_result();

while ($message = $messages->fetch_assoc()) {
    $class = $message['sender_id'] == $current_user_id ? 'sent' : 'received';
    echo '<div class="message ' . $class . '">';
    echo '<p>' . nl2br(htmlspecialchars($message['message'])) . '</p>';
    echo '<small>' . date('d.m.Y H:i', strtotime($message['sent_at'])) . '</small>';
    echo '</div>';
}
?>
