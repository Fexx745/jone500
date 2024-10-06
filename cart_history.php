<?php
session_start();
include('assets/condb/condb.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ'); window.location.href = 'login.php';</script>";
    exit();
}

$customerId = $_SESSION['customer_id'];

try {
    // ดึงข้อมูลการสั่งซื้อทั้งหมดของลูกค้าจาก tb_orders
    $sqlOrders = "SELECT * FROM tb_orders WHERE customer_id = :customerId ORDER BY order_date DESC";
    $stmtOrders = $conn->prepare($sqlOrders);
    $stmtOrders->bindParam(':customerId', $customerId);
    $stmtOrders->execute();
    $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
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
    <title>ประวัติการสั่งซื้อ</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Update this path accordingly -->
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="mt-5">ประวัติการสั่งซื้อ</h1>

        <?php if (count($orders) > 0): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>หมายเลขคำสั่งซื้อ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ราคา รวม</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['order_id']; ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($order['order_date'])); ?></td>
                            <td><?= number_format($order['total_price'], 2); ?> บาท</td>
                            <td>สำเร็จ</td>
                            <td><a href="order_details.php?orderId=<?= $order['order_id']; ?>" class="btn btn-info">ดูรายละเอียด</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>ไม่มีประวัติการสั่งซื้อ</p>
        <?php endif; ?>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
</body>

</html>
