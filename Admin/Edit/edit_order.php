<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่าได้ส่ง order_id มาหรือไม่
if (!isset($_GET['order_id'])) {
    echo "ไม่มีรหัสคำสั่งซื้อที่ต้องการแก้ไข";
    exit;
}

// รับค่า order_id จาก URL
$order_id = $_GET['order_id'];

// ดึงข้อมูลคำสั่งซื้อจากฐานข้อมูล
try {
    $sql = "SELECT * FROM tb_orders WHERE order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "ไม่พบคำสั่งซื้อนี้ในระบบ";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $total_price = $_POST['total_price'];
    $order_status = $_POST['order_status'];

    // อัปเดตข้อมูลคำสั่งซื้อในฐานข้อมูล
    try {
        $update_sql = "UPDATE tb_orders SET customer_id = :customer_id, order_date = :order_date, total_price = :total_price, order_status = :order_status WHERE order_id = :order_id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':customer_id', $customer_id);
        $update_stmt->bindParam(':order_date', $order_date);
        $update_stmt->bindParam(':total_price', $total_price);
        $update_stmt->bindParam(':order_status', $order_status);
        $update_stmt->bindParam(':order_id', $order_id);
        $update_stmt->execute();

        // ถ้ามีการอัปเดตสำเร็จ
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location.href='../Manage/manage_orders.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขคำสั่งซื้อ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../Navbar_Admin.php'; ?>

        <?php include '../Menubar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">แก้ไขคำสั่งซื้อ</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="customer_id">รหัสลูกค้า</label>
                                            <input type="text" class="form-control" id="customer_id" name="customer_id" value="<?php echo htmlspecialchars($order['customer_id']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="order_date">วันที่สั่งซื้อ</label>
                                            <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($order['order_date']))); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_price">ราคารวม</label>
                                            <input type="number" class="form-control" id="total_price" name="total_price" value="<?php echo htmlspecialchars($order['total_price']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="order_status">สถานะคำสั่งซื้อ</label>
                                            <select class="form-control" id="order_status" name="order_status" required>
                                                <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>รอดำเนินการ</option>
                                                <option value="Completed" <?php if ($order['order_status'] == 'Completed') echo 'selected'; ?>>เสร็จสิ้น</option>
                                                <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled') echo 'selected'; ?>>ยกเลิก</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                        <a href="../Manage/manage_orders.php" class="btn btn-secondary">ยกเลิก</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AdminLTE JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    </div>
</body>

</html>