<?php

//header.php

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Open Library</title>
    <link rel="canonical" href="">
    <!-- Bootstrap core CSS -->
    <link href="../asset/css/simple-datatables-style.css" rel="stylesheet" />
    <link href="../asset/css/styles.css" rel="stylesheet" />
    <script src="../asset/js/font-awesome-5-all.min.js" crossorigin="anonymous"></script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="" sizes="180x180">
    <link rel="icon" href="" sizes="32x32" type="image/png">
    <link rel="icon" href="" sizes="16x16" type="image/png">
    <link rel="manifest" href="">
    <link rel="mask-icon" href="" color="#7952b3">
    <link rel="icon" href="">
    <meta name="theme-color" content="#7952b3">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<?php

if (is_admin_login()) {

?>

    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Open Library</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.php">Thông tin</a></li>
                        <li><a class="dropdown-item" href="setting.php">Cài đặt</a></li>
                        <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="category.php">Loại</a>
                            <a class="nav-link" href="author.php">Tác giả</a>
                            <a class="nav-link" href="location_rack.php">vị trí kệ</a>
                            <a class="nav-link" href="book.php">Sách</a>
                            <a class="nav-link" href="user.php">Người dùng</a>
                            <a class="nav-link" href="issue_book.php">Sách mượn</a>
                            <a class="nav-link" href="logout.php">Đăng xuất</a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">

                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>


                <?php
            } else {

                ?>

                    <body>

                        <main>

                            <div class="container py-4">

                                <header class="pb-3 mb-4 border-bottom">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="index.php" class="d-flex align-items-center text-dark text-decoration-none">
                                                <span class="fs-4">Open Library</span>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <?php

                                            if (is_user_login()) {
                                            ?>
                                                <ul class="list-inline mt-4 float-end">
                                                    <li class="list-inline-item"><?php echo $_SESSION['user_id']; ?></li>
                                                    <li class="list-inline-item"><a href="issue_book_details.php">Sách mượn</a></li>
                                                    <li class="list-inline-item"><a href="search_book.php">Tìm kiếm sách</a></li>
                                                    <li class="list-inline-item"><a href="profile.php">Thông tin</a></li>
                                                    <li class="list-inline-item"><a href="logout.php">Đăng xuất</a></li>
                                                </ul>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>

                                </header>
                            <?php
                        }
                            ?>