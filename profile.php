<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
$stmt = $conn->prepare("SELECT username, name, email, phone, bio, profile_image, title, rate_per_hour FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- =====BOX ICONS===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="profilestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Portfolio website complete</title>
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
                    <li class="nav__item"><a href="favorites.php" class="nav__link">Favorites</a></li>
                    <li class="nav__item"><a href="#contact" class="nav__link active-link">Profile</a></li>
                    <li class="nav__item"><a href="./login.html" class="nav__link">Logout</a></li>
                </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-menu'></i>
            </div>
        </nav>
    </header>

    <body>
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
                        <form method="POST" action="update_profile_admin.php" enctype="multipart/form-data">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="account-general">
                                    <div class="card-body media align-items-center">
                                        <img src="<?= $user['profile_image'] ? htmlspecialchars($user['profile_image']) : 'images/img10.jpg' ?>" class="d-block ui-w-80">
                                        <div class="media-body ml-4">
                                            <label class="btn btn-outline-primary">
                                                Upload new photo
                                                <input type="file" name="profile_image" class="account-settings-fileinput" accept="image/*">
                                            </label> &nbsp;
                                            <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                            <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                        </div>
                                    </div>
                                    <hr class="border-light m-0">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <input type="text" class="form-control mb-1" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Bio</label>
                                            <textarea class="form-control" name="bio" rows="5"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Title (Role)</label>
                                            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($user['title'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Rate per Hour ($)</label>
                                            <input type="number" step="0.01" class="form-control" name="rate_per_hour" value="<?= htmlspecialchars($user['rate_per_hour'] ?? '') ?>">
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
                                            <label class="form-label">Bio</label>
                                            <textarea class="form-control"
                                                rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Birthday</label>
                                            <input type="text" class="form-control" value="May 3, 1995">
                                        </div>
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
                                        <h6 class="mb-4">Contacts</h6>
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


            <br>

            <footer class="footer">
                <p class="footer__title">PetDayCare</p>
                <div class="footer__social">
                    <a href="#" class="footer__icon"><i class='bx bxl-facebook'></i></a>
                    <a href="#" class="footer__icon"><i class='bx bxl-instagram'></i></a>
                    <a href="#" class="footer__icon"><i class='bx bxl-twitter'></i></a>
                </div>
                <p class="footer__copy">&#169;PetDayCare . All rigths reserved</p>
            </footer>

            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript">

            </script>
    </body>

</html>