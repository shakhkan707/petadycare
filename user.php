<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['status'])) {
    $message = match ($_GET['status']) {
        'success' => 'Изменения успешно сохранены!',
        'error' => 'Ошибка при сохранении.',
        'invalid' => 'Некорректные данные.',
        default => ''
    };
    if ($message) {
        echo "<script>alert('$message');</script>";
    }
}

$status = $_GET['status'] ?? '';
$alerts = [
    'password_mismatch' => 'Новые пароли не совпадают.',
    'wrong_current' => 'Текущий пароль введён неверно.',
    'password_changed' => 'Пароль успешно изменён.',
    'password_error' => 'Ошибка при обновлении пароля.',
];

if (isset($alerts[$status])) {
    echo "<script>alert('{$alerts[$status]}');</script>";
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, name, email, phone, bio FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


// Получаем список админов, с которыми есть переписка
$sql = "SELECT DISTINCT u.id, u.username 
        FROM messages m 
        JOIN users u ON (m.sender_id = u.id OR m.receiver_id = u.id) 
        WHERE (m.sender_id = ? OR m.receiver_id = ?) 
        AND u.id != ?
        AND u.role = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$admins = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="responsive.css">

    <link rel="stylesheet" href="styleNav.css">


    <style>
        .text-brown {
            color: #8B4513 !important;
            /* SaddleBrown — можно заменить на другой оттенок */
        }

        .btn-brown {
            color: #fff;
            background-color: #8B4513;
            border-color: #8B4513;
        }

        .btn-brown:hover {
            background-color: #A0522D;
            border-color: #A0522D;
        }

        /* Make container black with white text */
        .container-md {
            background-color: #121212 !important;
            color: #f1f1f1;
            padding: 20px;
            border-radius: 12px;
        }

        /* Override Bootstrap .card background */
        .card {
            background-color: #1e1e1e;
            border: none;
            color: #ffffff;
        }

        /* Inputs */
        .card input.form-control,
        .card textarea.form-control,
        .card select.custom-select {
            background-color: #2a2a2a;
            color: #f1f1f1;
            border: 1px solid #444;
        }

        /* Placeholder color */
        .card input::placeholder,
        .card textarea::placeholder {
            color: #aaa;
        }

        /* Active tab */
        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Non-active tab items */
        .list-group-item {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        /* Buttons */
        .btn-default {
            background-color: #333;
            color: #fff;
            border: 1px solid #444;
        }
    </style>


</head>

<body>

    <!-- HEADER -->

    <header id="header">

        <div class="container-fluid ps-0">
            <div class="row nav-row align-items-center">

                <div class="col-lg-3 col-sm-4 col-5">
                    <div class="logo text-md-end text-center">
                        <a href="./navOptions/Rental Services Detail.html">
                            <img src="pngs/11.png" class="img-fluid" alt="logo" style="max-width: 90px; height: auto;">
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-5">

                    <div class="nav_icon">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link ms-0" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-brands fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="nav_bar d-flex justify-content-center">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./navOptions/RentalServices.php">SERVICES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./my_messages.php">My messages</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./navOptions/About Us.html">ABOUT US</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-2 d-flex justify-content-end align-items-center gap-2">

                    <div id="main">
                        <span onclick="openNav()"><i class="burger fa-solid fa-bars text-white"></i></span>
                    </div>
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <a href="./index.html">HOME</a>
                        <a href="About Us.html">ABOUT US</a>
                        <a href="RentalServices.php">RENTAL SERVICES</a>
                        <a href="Testimonial.html">TESTIMONIAL</a>
                        <a href="user.php"><button type="button" class="btn">DASHBOARD</button></a>
                    </div>

                    <div class="button-wrapper me-3">
                        <a href="../user.php"><button type="button" class="btn">DASHBOARD</button></a>
                        <div class="btn2"></div>
                    </div>
                    <div class="logout-wrapper me-5">
                        <a href="./login.html" class="btn btn-m custom-logout">Logout</a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-1">
                    <div class="icon_list">
                        <div class="line"></div>
                        <div class="v_nav">
                            <ul class="nav flex-column align-items-center">
                                <li class="nav-item">
                                    <a class="nav-link" data-tooltip="facebook" href="#"><i
                                            class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-tooltip="linkedin" href="#"><i
                                            class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-tooltip="instagram" href="#"><i
                                            class="fa-brands fa-instagram"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-tooltip="twitter" href="#"><i
                                            class="fa-brands fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>

                <div class="col-lg-11 col-12">
                    <div class="row">
                        <div class="col-lg-11 col-12 pe-0">
                            <div class="overflow-hidden">
                                <div class="justify-content-center align-items-center d-flex gap-5">

                                    <h1 class="ml15">
                                        <span class="word text-center">WELCOME, <span class="text-warning"><?= htmlspecialchars($_SESSION['username']) ?></span>

                                    </h1>

                                </div>

                                <div class="text-center">
                                    <img src="pngs/72.png" class="img-fluid" alt="png2">
                                </div>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </header>

    <!-- PART 2 -->

    <section id="part2">

        <div class="container">
            <div class="row justify-content-between flex-column-reverse flex-lg-row">
                <div class="col-lg-8">
                    <div>
                        <div class="form">
                            <form action="/action_page.php">
                                <div class="container my-5">
                                    <div class="card shadow-sm rounded bg-black border-white text-white">
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center align-items-center mb-3 gap-3 flex-wrap">
                                                <i class="fa-solid fa-envelope fa-2x text-brown"></i>
                                                <img src="pngs/png5.png" alt="" style="height: 50px;">
                                                <h3 class="mb-0 text-white">Ваши чаты с администраторами</h3>
                                            </div>

                                            <?php if ($admins->num_rows > 0): ?>
                                                <div class="d-flex flex-column align-items-center gap-2 mb-3">
                                                    <?php while ($admin = $admins->fetch_assoc()): ?>
                                                        <a href="chat.php?user_id=<?= $admin['id'] ?>" class="btn btn-success text-white text-center px-4 py-2" style="width: auto; min-width: 200px;">
                                                            💬 <?= htmlspecialchars($admin['username']) ?>
                                                        </a>
                                                    <?php endwhile; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="alert alert-warning text-center mt-3" role="alert">
                                                    🙁 У вас пока нет чатов с администраторами.
                                                </div>
                                            <?php endif; ?>

                                            <!-- ===== КНОПКА ===== -->
                                            <div class="mt-4 d-flex flex-column gap-2 text-center">
                                                <button type="button" onclick="toggleBookingSection()" class="btn btn-brown">✍️ Отправить сообщение администратору</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-3 col-lg-4">
                    <div>
                        <div>
                            <h5>INFO</h5>
                        </div>

                        <div class="info">

                            <div class="box d-flex align-items-center gap-3 mb-4">
                                <div class="rounded-gradient-borders"><i class="fa-solid fa-location-dot px-4"></i>
                                </div>
                                <div>
                                    <p class="mb-2">MAILING ADDRESS</p>
                                    <span>
                                        <p>Mangilik El 41</p>
                                    </span>
                                </div>
                            </div>

                            <div class="box d-flex align-items-center gap-3 mb-4">
                                <div class="rounded-gradient-borders"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <P>Phone</P>
                                    <span>
                                        <p>012-345-6789</p>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- ===== ФОРМА (СКРЫТА ИЗНАЧАЛЬНО) ===== -->
    <section id="section3" style="display: none;">

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 col-md-4 px-0">
                    <div class="booking_now d-flex align-items-center position-relative">
                        <h1 class="mb-0">BOOKING NOW</h1>
                        <div class="position-absolute racer wow animate__animated animate__zoomIn">
                            <img src="pngs/9.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-md-8 col-sm-10 offset-sm-1 offset-md-0">
                    <div id="notification" class="notification"></div>

                    <div class="form">
                        <h2>BOOKING NOW</h2>

                        <div class="form_page">
                            <form id="myForm">
                                <div class="row gap-xxl-5 mb-4 gap-2">
                                    <div class="col-lg mb-4 mb-lg-0">
                                        <input type="text" class="form-control" name="full_name" placeholder="Your Name">
                                    </div>
                                    <div class="col-lg">
                                        <input type="tel" class="form-control" name="phone_number" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="row gap-xxl-5 mb-4 gap-2">
                                    <div class="col-lg mb-4 mb-lg-0">
                                        <input type="date" class="form-control" name="date" placeholder="Date">
                                    </div>
                                    <div class="col-lg">
                                        <input type="time" class="form-control" name="time" placeholder="Time">
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <textarea class="form-control" name="message" rows="10" id="comment"
                                        placeholder="Your Message"></textarea>
                                </div>

                                <div class="book-your-ride">
                                    <button type="submit" class="btn">Submit Your Service Request</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container d-flex justify-content-center">
        <div id="map" class="w-75" style="height: 450px; border-radius: 10px;"></div>
    </div>

    <div class="container-md light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">Social links</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-notifications">Notifications</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <form method="POST" action="update_profile.php">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" name="bio" rows="5"><?= htmlspecialchars($user['bio']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="repeat_password">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" class="form-control" value="May 3, 1995">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <select class="custom-select">
                                            <option>USA</option>
                                            <option selected>Kazakhstan</option>
                                            <option>UK</option>
                                            <option>Germany</option>
                                            <option>France</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="+7 (707) 121 7891">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-social-links">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control" value="https://twitter.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control" value="https://www.facebook.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Google+</label>
                                        <input type="text" class="form-control" value>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" value>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" value="https://www.instagram.com/user">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-notifications">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Activity</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone comments on my article</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone answers on my forum
                                                thread</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone follows me</span>
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Application</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">News and announcements</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly product updates</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly blog digest</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="reset" class="btn btn-default">Cancel</button>
        </div>
        </form>


        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
            let map = L.map('map').setView([51.1694, 71.4491], 13); // Алматы
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            function updateMap() {
                fetch('get_gps.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.lat && data.lng) {
                            map.setView([data.lat, data.lng], 13);
                            L.marker([data.lat, data.lng]).addTo(map);
                        }
                    });
            }

            setInterval(updateMap, 5000);
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js "
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin=" anonymous " referrerpolicy="no-referrer "></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js "
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz "
            crossorigin="anonymous "></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.0/slick.min.js"
            integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>

        <script src="wow.min.js "></script>

        <script src="java.js"></script>

        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">

        </script>

        <!-- Уведомление -->
        <script>
            function showNotification(message, type = 'success') {
                const notification = document.getElementById('notification');
                notification.className = 'notification show' + (type === 'error' ? ' error' : '');
                notification.textContent = message;

                // Показать на 5 секунд
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 5000);
            }
        </script>

        <script>
            document.getElementById('myForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Остановить обычную отправку

                const form = this;
                let formData = new FormData(form);

                fetch('submit_message.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(result => {
                        eval(result); // Выполнит, например: showNotification("Успешно!", "success");

                        // Очистка полей формы
                        form.reset();
                    })
                    .catch(() => {
                        showNotification('Ошибка подключения к серверу.', 'error');
                    });
            });
        </script>

        <!-- Уведомление -->

        <!-- ===== СКРИПТ ДЛЯ ПОКАЗА/СКРЫТИЯ ===== -->
        <script>
            function toggleBookingSection() {
                const section = document.getElementById('section3');
                section.style.display = section.style.display === 'none' ? 'block' : 'none';
                section.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        </script>



</body>

</html>