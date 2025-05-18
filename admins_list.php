<?php
require 'db.php';

$stmt = $conn->prepare("SELECT name, email, phone, bio, profile_image FROM users WHERE role = 'admin'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Meet Our Team</title>
    <link rel="stylesheet" href="chatstyles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card img {
            border-radius: 50%;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Meet Our Team</h1>
        <?php while ($admin = $result->fetch_assoc()): ?>
            <div class="card">
                <?php
                $photo = !empty($admin['profile_image']) ? htmlspecialchars($admin['profile_image']) : 'images/img1.png';
                ?>
                <img src="<?= $photo ?>" width="100" height="100" alt="Admin Photo">

                <h2><?= htmlspecialchars($admin['name'] ?? '') ?></h2>
                <p><strong>Email:</strong> <?= htmlspecialchars($admin['email'] ?? '') ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($admin['phone'] ?? '') ?></p>
                <p><?= nl2br(htmlspecialchars($admin['bio'] ?? '')) ?></p>
            </div>
        <?php endwhile; ?>

    </div>
</body>

</html>