<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

function clean($data) {
    return htmlspecialchars(trim($data));
}

$username = clean($_POST['username'] ?? '');
$name = clean($_POST['name'] ?? '');
$email = clean($_POST['email'] ?? '');
$phone = clean($_POST['phone'] ?? '');
$bio = clean($_POST['bio'] ?? '');

if ($username && $email) {
    $stmt = $conn->prepare("UPDATE users SET username = ?, name = ?, email = ?, phone = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $name, $email, $phone, $bio, $user_id);
    if ($stmt->execute()) {
        header("Location: user.php?status=success");
    } else {
        header("Location: user.php?status=error");
    }
} else {
    header("Location: user.php?status=invalid");
}

if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['repeat_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];

    // Проверка совпадения новых паролей
    if ($new_password !== $repeat_password) {
        header("Location: user.php?status=password_mismatch");
        exit;
    }

    // Получаем текущий хеш пароля
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Проверяем правильность текущего пароля
    if (!password_verify($current_password, $hashed_password)) {
        header("Location: user.php?status=wrong_current");
        exit;
    }

    // Обновляем пароль
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_hashed_password, $user_id);
    if ($stmt->execute()) {
        header("Location: user.php?status=password_changed");
        exit;
    } else {
        header("Location: user.php?status=password_error");
        exit;
    }
}
