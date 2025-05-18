<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT client_info.*, users.username 
        FROM favorites 
        JOIN client_info ON favorites.client_info_id = client_info.id 
        JOIN users ON client_info.user_id = users.id 
        WHERE favorites.user_id = ? 
        ORDER BY favorites.added_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Избранные сообщения</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-chat {
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- =====BOX ICONS===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!--===== HEADER =====-->
    <header class="l-header">
        <nav class="nav bd-grid">
            <div>
                <a href="#" class="nav__logo">PetDayCare</a>
            </div>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item"><a href="admin.php" class="nav__link">Home</a></li>
                    <li class="nav__item"><a href="admin_messages.php" class="nav__link">Messages</a></li>
                    <li class="nav__item"><a href="favorites.php" class="nav__link active-link">Favorites</a></li>
                    <li class="nav__item"><a href="profile.php" class="nav__link">Profile</a></li>
                    <li class="nav__item"><a href="./login.html" class="nav__link">Logout</a></li>
                </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-menu'></i>
            </div>
        </nav>
    </header>
    <br><br>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">⭐ Favorite messages</h2>

        <div class="row gy-5">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($row['full_name']) ?>
                                <small class="text-muted">(<?= htmlspecialchars($row['username']) ?>)</small>
                            </h5>
                            <p class="card-text mb-3"><strong>📞 Phone Number:</strong> <?= htmlspecialchars($row['phone_number']) ?></p>
                            <p class="card-text mb-3"><strong>📅 Date:</strong> <?= $row['date'] ?></p>
                            <p class="card-text mb-3"><strong>⏰ Time:</strong> <?= $row['time'] ?></p>
                            <p class="card-text mb-3"><strong>💬 Messages:</strong><br><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                            <a href="chat.php?user_id=<?= $row['user_id'] ?>" class="btn btn-primary w-100 mt-auto">Начать чат</a>
                            <form action="remove_favorite.php" method="post" class="mt-2">
                                <input type="hidden" name="client_info_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger w-100">Удалить из избранного</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <br><br>

    <footer class="footer">
        <p class="footer__title">PetDayCare</p>
        <div class="footer__social">
            <a href="#" class="footer__icon"><i class='bx bxl-facebook'></i></a>
            <a href="#" class="footer__icon"><i class='bx bxl-instagram'></i></a>
            <a href="#" class="footer__icon"><i class='bx bxl-twitter'></i></a>
        </div>
        <p class="footer__copy">&#169;PetDayCare . All rigths reserved</p>
    </footer>

</body>

</html>