<?php
require '../db.php';
$stmt = $conn->prepare("SELECT id, username, name, bio, profile_image, title, rate_per_hour  FROM users WHERE role = 'admin'");
$stmt->execute();
$admins = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>

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

    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../responsive.css">

    <link rel="stylesheet" href="../styleNav.css">

    <link rel="stylesheet" href="../responsiveNav.css">

</head>

<body>

    <!-- HEADER -->

    <header id="header">

        <div class="container-fluid ps-0">
            <div class="row nav-row align-items-center">

                <div class="col-lg-3 col-sm-4 col-5">
                    <div class="logo text-md-end text-center">
                        <a href="../navOptions/Rental Services Detail.html">
                            <img src="../pngs/11.png" class="img-fluid" alt="logo" style="max-width: 90px; height: auto;">
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
                                <a class="nav-link" href="../index.html">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="active nav-link" href="Rental Services.html">SERVICES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Testimonial.html">TESTIMONIAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="About Us.html">ABOUT US</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-2">

                    <div id="main">
                        <span onclick="openNav()"><i class="burger fa-solid fa-bars text-white"></i></span>
                    </div>
                    <div id="mySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <a href="../index.html">HOME</a>
                        <a href="About Us.html">ABOUT US</a>
                        <a href="Rental Services.html">RENTAL SERVICES</a>
                        <a href="Testimonial.html">TESTIMONIAL</a>
                        <a href="../user.php"><button type="button" class="btn">DASHBOARD</button></a>
                    </div>

                    <div class="button-wrapper">
                        <a href="../user.php"><button type="button" class="btn">DASHBOARD</button></a>
                        <div class="btn2"></div>

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
                                        <span class="word text-center">OUR PROFESSIONALS</span>

                                    </h1>

                                </div>

                                <div class="text-center">
                                    <img src="../pngs/66.png" class="img-fluid" alt="png2">
                                </div>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </header>

    <!-- PART 5-->

    <section id="part5">

        <div class="container-fluid">
            <div class="row gap-lg-0 justify-content-center gap-5">

                <?php while ($admin = $admins->fetch_assoc()): ?>
                    <div class="col-sm-4 first-row">
                        <div class="text-center">
                            <div style="max-width: 250px; display: flex; justify-content: center; align-items: center; margin: 0 auto; text-align: center;">
                                <?php
                                $photo = !empty($admin['profile_image']) ? '../' . htmlspecialchars($admin['profile_image']) : '../images/img10.jpg';
                                ?>
                                <img src="<?= $photo ?>" class="img-fluid" style="margin-bottom: 20px; height: 250px; width: 100%; object-fit: cover; border-radius: 12px;">
                            </div>
                            <div class="service">
                                <h2><?= htmlspecialchars($admin['username'] ?? '') ?></h2>
                                <p>
                                <h2><?= htmlspecialchars($admin['title'] ?? '-') ?></h2>
                                </p>
                                <p><?= nl2br(htmlspecialchars($admin['bio'] ?? '-')) ?></p>
                                <div class="per-day d-flex align-items-center justify-content-around">
                                    <div>
                                        <h6>Per Hour</h6>
                                    </div>
                                    <div class="dollar">
                                        <h6>$<?= htmlspecialchars($admin['rate_per_hour'] ?? '') ?></h6>
                                    </div>
                                </div>
                                <div class="rent_now text-center">
                                    <a href="../chat.php?user_id=<?= $admin['id'] ?>" class="btn btn-book-now">
                                        BOOK NOW
                                    </a>
                                    <div class="rent-wrap mt-2">
                                        <img src="../pngs/png11.png" alt="" class="img-fluid" style="max-width: 40px;">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>

    </section>



    <!-- FOOTER -->

    <footer id="footer">

        <div class="container-fluid">

            <div class="row align-items-center">

                <div class="col-12 col-lg-11 col-xl-10">
                    <div class="row navFoot align-items-center">

                        <div class="col-sm-4 col-lg-5 px-0">
                            <div class="footer-logo text-center">
                                <img src="../pngs/11.png" alt="">
                            </div>

                        </div>
                        <div class="col-sm-8 col-lg-7 px-0 navLine">
                            <div class="nav_bar d-flex justify-content-center align-items-center">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="../index.html">HOME</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="About Us.html">ABOUT US</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="Rental Services.html">RENTAL SERVICES</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="Testimonial.html">TESTIMONIAL</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="Contact Us.html">CONTACT US</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 px-0">
                    <div class="nav_icon">

                        <ul class="nav flex-lg-column justify-content-center align-items-center">
                            <li class="nav-item">
                                <a class="nav-link linkedin" href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link instagram" href="#"><i class="fa-brands fa-instagram"></i></a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link twitter" href="#"><i class="fa-brands fa-twitter"></i></a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link facebook ms-0" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-5">
                    <div class="touch">
                        <h1>GET IN TOUCH</h1>
                        <h2 class="display-5 my-2">123-456-789</h2>
                        <p>Our online scheduling and payment system is safe.</p>
                        <a href="#" class="btn-1 text-white">
                            <svg>
                                <rect x="0" y="0" fill="none" width="100%" height="100%" />
                            </svg>
                            Request With Online Form
                        </a>

                    </div>
                </div>

                <div class="col-lg-7 col-xl-6 news">

                    <div class="subscribe d-flex justify-content-center flex-column">

                        <h1 class="mb-3">SUSCRIBE TO OUR NEWSLETTER</h1>
                        <div class="input">
                            <input type="email" class="form-control" placeholder="Email Address...">
                            <button type="button" class="btn">SUBSCRIBE</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-5">

                <div class="col-lg-4 col-xl-3 offset-lg-8">
                    <div class="copyright text-center text-lg-end">
                        <p>
                            ©2023 Company Name, All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </footer>


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

    <script src="JS/wow.min.js "></script>

    <script src="../js/java.js"></script>
</body>

</html>