<?php
$host = "localhost";
$user = "root";
$password = "root"; // для MAMP
$db = "login_db";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
