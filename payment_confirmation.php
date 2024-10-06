<?php
session_start();
include('assets/condb/condb.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ'); window.location.href = 'login.php';</script>";
    exit();
}

// ดึงรายการสินค้าที่ยังไม่ชำระเงินสำหรับลูกค้า
$customerId = $_SESSION['customer_id'];
$sql = "SELECT o.order_id, o.total_price, od.quantity, p.product_name, p.stockQty
        FROM tb_orders o
        JOIN tb_order_details od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        WHERE o.customer_id = :customerId AND o.order_status = '0'";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':customerId', $customerId);
$stmt->execute();
$pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $amount = $_POST['amount'];
    $paymentMethod = $_POST['payment_method'];
    $receiptImage = $_FILES['receipt_image']['name'];

    // Set the target directory for storing receipt images
    $targetDir = "assets/imge/payments/"; // Update the directory to assets/payment/
    $targetFile = $targetDir . basename($receiptImage);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Ensure the directory exists; if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the directory with appropriate permissions
    }

    // ตรวจสอบประเภทไฟล์
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["receipt_image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('ไฟล์ไม่ใช่รูปภาพ');</script>";
            $uploadOk = 0;
        }
    }

    // ตรวจสอบขนาดไฟล์
    if ($_FILES["receipt_image"]["size"] > 500000) {
        echo "<script>alert('ขนาดไฟล์ใหญ่เกินไป');</script>";
        $uploadOk = 0;
    }

    // ตรวจสอบประเภทไฟล์
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('ขออภัย, เฉพาะไฟล์ JPG, JPEG, PNG & GIF เท่านั้น');</script>";
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk ถูกตั้งค่าเป็น 0 เนื่องจากมีข้อผิดพลาด
    if ($uploadOk == 0) {
        echo "<script>alert('ไม่สามารถอัปโหลดไฟล์');</script>";
    } else {
        // อัปโหลดไฟล์
        if (move_uploaded_file($_FILES["receipt_image"]["tmp_name"], $targetFile)) {
            // บันทึกข้อมูลการชำระเงินในฐานข้อมูล
            try {
                $sql = "INSERT INTO tb_payments (order_id, payment_date, amount, payment_status, payment_method, receipt_image) 
                        VALUES (:orderId, NOW(), :amount, '0', :paymentMethod, :receiptImage)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':orderId', $orderId);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':paymentMethod', $paymentMethod);
                $stmt->bindParam(':receiptImage', $targetFile); // Path stored in DB
                $stmt->execute();

                // Update order status to 1 (paid)
                $updateSql = "UPDATE tb_orders SET order_status = 1 WHERE order_id = :orderId";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(':orderId', $orderId);
                $updateStmt->execute();

                echo "<script>alert('แจ้งโอนเงินสำเร็จ'); window.location.href = 'cart_history.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $e->getMessage() . "');</script>";
            }
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์');</script>";
        }
    }
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
        <h2>รายการสินค้าที่ยังไม่ชำระเงิน</h2>
        <form action="payment_confirmation.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <thead>
                    <tr>
                        <th>เลือก</th>
                        <th>ชื่อสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาทั้งหมด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendingOrders)) : ?>
                        <tr>
                            <td colspan="4" class="text-center">ไม่มีรายการสินค้าที่ยังไม่ชำระเงิน</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($pendingOrders as $order) : ?>
                            <tr>
                                <td>
                                    <input type="radio" name="order_id" value="<?php echo $order['order_id']; ?>" required>
                                </td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['stockQty']; ?></td>
                                <td><?php echo number_format($order['total_price'], 2); ?> บาท</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

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
                    <!-- เพิ่มวิธีการชำระเงินอื่น ๆ ที่ต้องการได้ -->
                </select>
            </div>

            <div class="form-group">
                <label for="receipt_image">อัปโหลดใบเสร็จ:</label>
                <input type="file" name="receipt_image" class="form-control-file" accept="image/*" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">แจ้งโอนเงิน</button>
        </form>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
</body>

</html>
