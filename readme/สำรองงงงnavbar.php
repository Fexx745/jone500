<?php
session_start();
?>
<div class="logo">
    <img src="assets/imge/logo.png" alt="">

    <div class="cad"></div>
    <input type="text" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค้นหาสินค้า">
    <i class='bx bx-search bx-flashing'></i>
    <div id="sef">
        <p>ค้นหา</p>
    </div>
    <div class="logonav"><img src="assets/imge/navmenu.png" alt=""></div>
    <div class="logomarket"><img src="assets/imge/market.jpg" alt=""></div>
</div>

<div class="nav-menu">
    <ul>
        <a href="index.php">
            <li>หน้าหลัก</li>
        </a>
        <a href="#">
            <li>หมวดสินค้า</li>
        </a>
        <a href="#">
            <li>เกี่ยวกับเรา</li>
        </a>
        <a href="login.php">
            <li>
                <?php
                if (isset($_SESSION['fist_name'])) {
                    echo $_SESSION['fist_name'];
                } else {
                    echo "เข้าสู่ระบบ";
                }
                ?>
            </li>
        </a>

        <a href="#">
            <li>รถเข็น<i class='bx bx-cart'></i></li>
        </a>
        <a href="#">
            <li>แจ้งโอน<i class='bx bx-credit-card'></i></li>
        </a>
        <a href="#">
            <li>เช็คสถานะ<i class='bx bxs-car-crash'></i></li>
        </a>
        <a href="logout.php">
            <li>
                <?php
                if (isset($_SESSION['email'])) {
                    echo "ออกจากระบบ";
                } else {
                    echo "";
                }
                ?>
            </li>
        </a>
        <a href="#">
            <li>
                <?php
                if (isset($_SESSION['email'])) {
                    echo "สวัสดีคุณ " . $_SESSION['first_name'];
                } else {
                    echo "";
                }
                ?>
            </li>
        </a>
    </ul>
</div>