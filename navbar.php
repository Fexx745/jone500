<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>หน้าเว็บของคุณ</title>
    <!-- ลิงก์ CSS ของ Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- ลิงก์ JavaScript ของ Bootstrap และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="logo">
                <img src="assets/imge/logo.png" alt="" class="img-fluid" style="max-width: 150px; height: auto;"> <!-- ปรับขนาด -->
            </div>
            <div class="search-bar d-flex align-items-center">
                <form action="search.php" method="get" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหาสินค้า" aria-label="ค้นหาสินค้า" required>
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class='bx bx-search bx-flashing'></i> ค้นหา
                    </button>
                </form>
            </div>


            <div class="d-flex align-items-center">
                <div class="logomarket" style="position: relative; display: inline-block;">
                    <a href="cart.php" style="text-decoration: none; position: relative;">
                        <img src="assets/imge/market.png" alt="Cart" class="img-fluid" style="max-width: 50px; height: auto;"> <!-- เปลี่ยนเป็นโลโก้ตะกร้าสินค้า -->
                        <?php
                        // ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            $cart_count = count($_SESSION['cart']);
                            echo '<span class="badge badge-danger" style="position: absolute; top: -10px; right: -10px; font-size: 12px;">' . $cart_count . '</span>';
                        } else {
                            echo '<span class="badge badge-secondary" style="position: absolute; top: -10px; right: -10px; font-size: 12px;">0</span>';
                        }
                        ?>
                    </a>
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
                <?php
                // ดึงรายการหมวดหมู่จากฐานข้อมูล
                include('assets/condb/condb.php');

                $sql = "SELECT category_id, category_name FROM categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-category'></i>
                        หมวดสินค้า
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <?php foreach ($categories as $category): ?>
                            <a class="dropdown-item" href="category.php?category_id=<?= $category['category_id']; ?>">
                                <?= $category['category_name']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class='bx bx-info-circle'></i>
                        เกี่ยวกับเรา
                    </a>
                </li>

                <?php if (isset($_SESSION['email'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class='bx bx-cart'></i>
                            รถเข็น
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="payment_confirmation.php">
                            <i class='bx bx-credit-card'></i>
                            แจ้งโอน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart_history.php">
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