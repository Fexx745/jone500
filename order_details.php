<?php
session_start();
include('assets/condb/condb.php');

// ตรวจสอบว่ามีการส่ง orderId มาหรือไม่
if (!isset($_GET['orderId'])) {
    echo "<script>alert('ไม่พบข้อมูลการสั่งซื้อ'); window.location.href = 'cart_history.php';</script>";
    exit();
}

$orderId = $_GET['orderId'];

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ'); window.location.href = 'login.php';</script>";
    exit();
}

$customerId = $_SESSION['customer_id'];

try {
    // ดึงข้อมูลคำสั่งซื้อพื้นฐาน
    $sqlOrder = "SELECT * FROM tb_orders WHERE order_id = :orderId AND customer_id = :customerId";
    $stmtOrder = $conn->prepare($sqlOrder);
    $stmtOrder->bindParam(':orderId', $orderId);
    $stmtOrder->bindParam(':customerId', $customerId);
    $stmtOrder->execute();
    $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่าคำสั่งซื้อนี้มีอยู่
    if (!$order) {
        echo "<script>alert('ไม่พบคำสั่งซื้อนี้'); window.location.href = 'cart_history.php';</script>";
        exit();
    }

    // ดึงรายละเอียดของการสั่งซื้อ
    $sqlOrderDetails = "SELECT * FROM tb_order_details WHERE order_id = :orderId";
    $stmtOrderDetails = $conn->prepare($sqlOrderDetails);
    $stmtOrderDetails->bindParam(':orderId', $orderId);
    $stmtOrderDetails->execute();
    $orderDetails = $stmtOrderDetails->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล: " . $e->getMessage();
    exit();
}

$conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการสั่งซื้อ - หมายเลขคำสั่ง <?= $orderId; ?></title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Update this path accordingly -->
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="mt-5">รายละเอียดการสั่งซื้อ - หมายเลขคำสั่ง <?= $orderId; ?></h1>
        <h5 class="mt-4">ข้อมูลการสั่งซื้อ</h5>
        <p><strong>วันที่สั่งซื้อ:</strong> <?= date('Y-m-d H:i:s', strtotime($order['order_date'])); ?></p>
        <p><strong>ราคา รวม:</strong> <?= number_format($order['total_price'], 2); ?> บาท</p>

        <h5 class="mt-4">รายละเอียดสินค้า</h5>
        <?php if (count($orderDetails) > 0): ?>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>รูปสินค้า</th> <!-- เพิ่มคอลัมน์สำหรับรูปภาพ -->
                        <th>ชื่อสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $detail): ?>
                        <tr>
                            <td>
                                <?php
                                // ดึงชื่อสินค้าจาก tb_products โดยใช้ product_id
                                include('assets/condb/condb.php');
                                $sqlProduct = "SELECT product_name, image FROM products WHERE product_id = :productId"; // เพิ่ม product_image
                                $stmtProduct = $conn->prepare($sqlProduct);
                                $stmtProduct->bindParam(':productId', $detail['product_id']);
                                $stmtProduct->execute();
                                $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <img src="assets/imge/product/<?= $product['image']; ?>" alt="<?= $product['product_name']; ?>" style="width: 100px; height: auto;"> <!-- แสดงรูปภาพ -->
                            </td>
                            <td><?= $product['product_name']; ?></td>
                            <td><?= $detail['quantity']; ?></td>
                            <td><?= number_format($detail['price'], 2); ?> บาท</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>ไม่มีรายละเอียดสินค้าในคำสั่งซื้อนี้</p>
        <?php endif; ?>
        <a href="cart_history.php" class="btn btn-warning">ย้อนกลับ</a>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script>
</body>

</html>
