<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="assets/css/styles.css">

  <!-- =====BOX ICONS===== -->
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

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
          <li class="nav__item"><a href="#home" class="nav__link active-link">Home</a></li>
          <li class="nav__item"><a href="admin_messages.php" class="nav__link">Messages</a></li>
          <li class="nav__item"><a href="favorites.php" class="nav__link">Favorites</a></li>
          <li class="nav__item"><a href="profile.php" class="nav__link">Profile</a></li>
          <li class="nav__item"><a href="./login.html" class="nav__link">Logout</a></li>
        </ul>
      </div>

      <div class="nav__toggle" id="nav-toggle">
        <i class='bx bx-menu'></i>
      </div>
    </nav>
  </header>

  <main class="l-main">
    <!--===== HOME =====-->
    <section class="home bd-grid" id="home">
      <div class="home__data">
        <h1 class="home__title">
        Welcome ,<br> Administrator<br>
          <span class="home__title-color">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
          </span>
        </h1>
        <a href="admin_messages.php" class="button">Messages from customers</a><br><br>
        <a href="profile.php" class="button">Profile Management</a>
      </div>


      <div class="home__social">
        <a href="" class="home__social-icon"><i class='bx bxl-linkedin'></i></a>
        <a href="" class="home__social-icon"><i class='bx bxl-behance'></i></a>
        <a href="" class="home__social-icon"><i class='bx bxl-github'></i></a>
      </div>

      <div class="home__img">
        <svg class="home__blob" viewBox="0 0 479 467" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <mask id="mask0" mask-type="alpha">
            <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z" />
          </mask>
          <g mask="url(#mask0)">
            <path d="M9.19024 145.964C34.0253 76.5814 114.865 54.7299 184.111 29.4823C245.804 6.98884 311.86 -14.9503 370.735 14.143C431.207 44.026 467.948 107.508 477.191 174.311C485.897 237.229 454.931 294.377 416.506 344.954C373.74 401.245 326.068 462.801 255.442 466.189C179.416 469.835 111.552 422.137 65.1576 361.805C17.4835 299.81 -17.1617 219.583 9.19024 145.964Z" />
            <image class="home__blob-img" x="50" y="60" href="assets/img/7.png" />
          </g>
        </svg>
      </div>
    </section>

    <!--===== FOOTER =====-->
    <footer class="footer">
      <p class="footer__title">PetDayCare</p>
      <div class="footer__social">
        <a href="#" class="footer__icon"><i class='bx bxl-facebook'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-instagram'></i></a>
        <a href="#" class="footer__icon"><i class='bx bxl-twitter'></i></a>
      </div>
      <p class="footer__copy">&#169;PetDayCare . All rigths reserved</p>
    </footer>


    <!--===== SCROLL REVEAL =====-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--===== MAIN JS =====-->
    <script src="assets/js/main.js"></script>
</body>

</html>