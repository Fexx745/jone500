<?php
session_start();
include('assets/condb/condb.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ'); window.location.href = 'login.php';</script>";
    exit();
}

// รับ order_id จาก URL หรือ POST
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;

// ตรวจสอบว่ามี order_id หรือไม่
if (!$orderId) {
    echo "<script>alert('ไม่พบหมายเลขคำสั่งซื้อ'); window.location.href = 'cart_history.php';</script>";
    exit();
}

// ดึงรายการสินค้าที่ยังไม่ชำระเงินสำหรับลูกค้า
$customerId = $_SESSION['customer_id'];
$sql = "SELECT o.order_id, o.total_price
        FROM tb_orders o
        WHERE o.customer_id = :customerId AND o.order_id = :orderId AND o.order_status = '0'";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customerId', $customerId);
$stmt->bindParam(':orderId', $orderId);
$stmt->execute();
$pendingOrder = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... (the rest of the payment processing code remains unchanged)
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งโอนเงิน</title>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="mt-5">แจ้งโอนเงิน</h1>

        <!-- ตารางแสดงรายการสินค้าที่ยังไม่ชำระเงิน -->
        <h2>หมายเลขคำสั่งซื้อ: <?php echo $pendingOrder['order_id']; ?></h2>
        <h2>ยอดรวม: <?php echo number_format($pendingOrder['total_price'], 2); ?> บาท</h2>

        <form action="payment_confirmation.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="order_id" value="<?php echo $pendingOrder['order_id']; ?>">

            <div class="form-group">
                <label for="amount">จำนวนเงินที่โอน (บาท):</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="payment_method">วิธีการชำระเงิน:</label>
                <select name="payment_method" class="form-control" required>
                    <option value="โอนผ่านธนาคาร">โอนผ่านธนาคาร</option>
                    <option value="บัตรเครดิต">บัตรเครดิต</option>
                    <option value="PayPal">PayPal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="receipt_image">อัปโหลดใบเสร็จ:</label>
                <input type="file" name="receipt_image" class="form-control-file" accept="image/*" required>
            </div>
            <a href="cart_history.php" class="btn btn-warning">ย้อนกลับ</a>
            <button type="submit" name="submit" class="btn btn-primary">แจ้งโอนเงิน</button>
        </form>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
</body>

</html>
