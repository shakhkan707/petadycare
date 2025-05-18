<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];

// Получаем всех админов, с которыми был чат
$stmt = $conn->prepare("
    SELECT DISTINCT u.id, u.username
    FROM messages m
    JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id)
    WHERE (m.sender_id = ? OR m.receiver_id = ?)
    AND u.role = 'admin' AND u.id != ?
");
$stmt->bind_param("iii", $current_user_id, $current_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
$admins = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Messages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-wrapper {
            height: 100vh;
        }

        .admin-list {
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
            height: 100%;
        }

        .admin-link {
            display: block;
            margin-bottom: 12px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .admin-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
        }


        .chat-frame {
            border: none;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            .admin-list {
                border-right: none;
                border-bottom: 1px solid #dee2e6;
                height: auto;
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }

            .admin-link {
                display: inline-block;
                margin-right: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid d-flex justify-content-between align-items-center p-3 border-bottom">
        <a href="user.php" class="btn btn-outline-secondary">
            &larr; Back
        </a>
        <h3 class="m-0 text-center flex-grow-1">My Chats</h3>
        <div style="width: 85px;"></div>
    </div>

    <div class="container-fluid chat-wrapper d-flex flex-column flex-md-row px-15">
        <div class="admin-list col-md-3 d-flex flex-column me-2"
            style="background-image: url('images/chat.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <h5 class="text-center mb-3">My Chats</h5>
            <?php foreach ($admins as $admin): ?>
                <a class="admin-link" href="?admin_id=<?= $admin['id'] ?>">
                    <?= htmlspecialchars($admin['username']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="col-md-9 flex-grow-1"
            style="    background: #9fc5fe;">
            <?php if (isset($_GET['admin_id'])):
                $_SESSION['current_admin_id'] = (int)$_GET['admin_id'];
            ?>
                <iframe class="chat-frame" src="chat.php?user_id=<?= (int)$_GET['admin_id'] ?>"></iframe>
            <?php else: ?>
                <div class="d-flex justify-content-center align-items-center h-100">
                    <h5 class="text-muted">Выберите администратора слева, чтобы начать чат</h5>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>

</html>