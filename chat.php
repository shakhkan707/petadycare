<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$other_user_id = $_GET['user_id'] ?? null;
if (!$other_user_id) {
    die("Ошибка: не указан пользователь");
}

// Проверка, что текущий пользователь имеет право на переписку с этим пользователем
if ($_SESSION['role'] === 'user' && $other_user_id != $_SESSION['user_id']) {
    // Для пользователей разрешаем переписку только с админами
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $other_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['role'] !== 'admin') {
        die("Ошибка: нет доступа к этой переписке");
    }
}

// Получаем сообщения
$stmt = $conn->prepare("SELECT m.*, u.username 
                       FROM messages m 
                       JOIN users u ON m.sender_id = u.id 
                       WHERE (sender_id = ? AND receiver_id = ?) 
                       OR (sender_id = ? AND receiver_id = ?) 
                       ORDER BY sent_at ASC");
$current_user_id = $_SESSION['user_id'];
$stmt->bind_param("iiii", $current_user_id, $other_user_id, $other_user_id, $current_user_id);
$stmt->execute();
$messages = $stmt->get_result();

// Получаем информацию о собеседнике
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $other_user_id);
$stmt->execute();
$other_user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Чат с <?= htmlspecialchars($other_user['username']) ?></title>
    <link rel="stylesheet" href="chatstyles.css">
</head>

<body>
    <h2 style="text-align: center;">
        Чат с <?= htmlspecialchars($other_user['username']) ?> (<?= $other_user['role'] === 'admin' ? 'Администратор' : 'Пользователь' ?>)
    </h2>
    <div id="chat-box" class="chat-container">
        <?php while ($message = $messages->fetch_assoc()): ?>
            <div class="message <?= $message['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received' ?>">
                <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                <small><?= date('d.m.Y H:i', strtotime($message['sent_at'])) ?></small>
            </div>
        <?php endwhile; ?>
    </div>
    <form action="send_message.php" method="POST" class="message-form">
        <input type="hidden" name="receiver_id" value="<?= $other_user_id ?>">
        <textarea name="message" placeholder="Ваше сообщение..." required></textarea>
        <button type="submit">Отправить</button>
    </form>

    <?php
    $back_link = ($_SESSION['role'] === 'admin') ? 'admin_messages.php' : 'my_messages.php';
    ?>
    <a href="<?= $back_link ?>" target="_top" class="back-btn">← Назад</a>


    <button id="startGPS">Start GPS</button>
    <button id="stopGPS" style="display:none;">Stop GPS</button>
    <div id="gpsStatus" style="margin-top:10px;"></div>

    <script>
        let watchId = null;

        document.getElementById("startGPS").addEventListener("click", () => {
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(position => {
                    fetch("send_gps.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        })
                    });
                    document.getElementById("gpsStatus").textContent = "GPS broadcasting...";
                });

                document.getElementById("startGPS").style.display = "none";
                document.getElementById("stopGPS").style.display = "inline-block";
            }
        });

        document.getElementById("stopGPS").addEventListener("click", () => {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
            }

            fetch("clear_gps.php", {
                method: "POST"
            });

            document.getElementById("gpsStatus").textContent = "GPS stopped.";
            document.getElementById("startGPS").style.display = "inline-block";
            document.getElementById("stopGPS").style.display = "none";
        });
    </script>



    <script>
        const userId = <?= json_encode($_GET['user_id']) ?>;

        function fetchMessages() {
            fetch(`get_messages.php?user_id=${userId}`)
                .then(response => response.text())
                .then(html => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = html;
                    chatBox.scrollTop = chatBox.scrollHeight; // Прокрутка вниз
                });
        }

        fetchMessages();
        setInterval(fetchMessages, 10000);
    </script>


</body>

</html>