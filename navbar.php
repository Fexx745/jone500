<?php
session_start();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>หน้าเว็บของคุณ</title>
</head>

<body>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="logo">
                <img src="assets/imge/logo.png" alt="" class="img-fluid" style="max-width: 150px; height: auto;"> <!-- ปรับขนาด -->
            </div>
            <div class="search-bar d-flex align-items-center">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="ค้นหาสินค้า" aria-label="ค้นหาสินค้า">
                    <button class="btn btn-outline-secondary" id="sef">
                        <i class='bx bx-search bx-flashing'></i> ค้นหา
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="logonav me-2">
                    <img src="assets/imge/navmenu.png" alt="" class="img-fluid" style="max-width: 50px; height: auto;"> <!-- ปรับขนาด -->
                </div>
                <div class="logomarket">
                    <img src="assets/imge/market.jpg" alt="" class="img-fluid" style="max-width: 50px; height: auto;"> <!-- ปรับขนาด -->
                </div>
            </div>
        </div>
    </div>



    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">
                        <i class='bx bx-home'></i>
                        หน้าหลัก
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class='bx bx-category'></i>
                        หมวดสินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class='bx bx-info-circle'></i>
                        เกี่ยวกับเรา
                    </a>
                </li>

                <?php if (isset($_SESSION['email'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class='bx bx-cart'></i>
                            รถเข็น
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class='bx bx-credit-card'></i>
                            แจ้งโอน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class='bx bxs-car-crash'></i>
                            เช็คสถานะ
                        </a>
                    </li>
                <?php endif; ?>
            </ul>


            <ul class="navbar-nav">
                <?php if (isset($_SESSION['email'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class='bx bx-user'></i>
                            สวัสดีคุณ <?= $_SESSION['first_name']; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class='bx bx-log-out'></i>
                            ออกจากระบบ
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class='bx bx-log-in'></i>
                            เข้าสู่ระบบ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reg.php">
                            <i class='bx bx-user-plus'></i>
                            สมัครสมาชิก
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>