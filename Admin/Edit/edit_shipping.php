<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if (isset($_GET['shipping_id'])) {
    $shipping_id = $_GET['shipping_id'];

    // ดึงข้อมูลจากตาราง shipping ตาม shipping_id
    try {
        $sql = "SELECT * FROM shipping WHERE shipping_id = :shipping_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':shipping_id', $shipping_id);
        $stmt->execute();
        $shipping = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$shipping) {
            echo "<script>alert('ไม่พบข้อมูลการจัดส่งที่ต้องการแก้ไข!'); window.location.href = '../Manage/manage_shipping.php';</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "<script>alert('ไม่พบ shipping_id!'); window.location.href = '../Manage/manage_shipping.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ดึงค่าจากฟอร์ม
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $shipping_address = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';
    $shipping_method = isset($_POST['shipping_method']) ? $_POST['shipping_method'] : '';
    $shipping_date = isset($_POST['shipping_date']) ? $_POST['shipping_date'] : '';
    $tracking_number = isset($_POST['tracking_number']) ? $_POST['tracking_number'] : '';

    // ตรวจสอบว่ามีข้อมูลที่จำเป็นทั้งหมดหรือไม่
    if (!empty($order_id) && !empty($shipping_address) && !empty($shipping_method) && !empty($shipping_date) && !empty($tracking_number)) {
        try {
            // อัปเดตข้อมูลในตาราง shipping
            $sql = "UPDATE shipping SET order_id = :order_id, shipping_address = :shipping_address, shipping_method = :shipping_method, shipping_date = :shipping_date, tracking_number = :tracking_number 
                    WHERE shipping_id = :shipping_id";
            $stmt = $conn->prepare($sql);

            // ผูกค่าพารามิเตอร์
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':shipping_address', $shipping_address);
            $stmt->bindParam(':shipping_method', $shipping_method);
            $stmt->bindParam(':shipping_date', $shipping_date);
            $stmt->bindParam(':tracking_number', $tracking_number);
            $stmt->bindParam(':shipping_id', $shipping_id);

            // ดำเนินการคำสั่ง SQL
            if ($stmt->execute()) {
                echo "<script>alert('แก้ไขข้อมูลการจัดส่งสำเร็จ!'); window.location.href = '../Manage/manage_shipping.php';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการแก้ไขข้อมูล!'); history.back();</script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการจัดส่ง</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                            <h1 class="m-0">แก้ไขข้อมูลการจัดส่ง</h1>
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
                                            <label for="order_id">รหัสคำสั่งซื้อ</label>
                                            <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo htmlspecialchars($shipping['order_id']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="shipping_address">ที่อยู่การจัดส่ง</label>
                                            <input type="text" class="form-control" id="shipping_address" name="shipping_address" value="<?php echo htmlspecialchars($shipping['shipping_address']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="shipping_method">วิธีการจัดส่ง</label>
                                            <input type="text" class="form-control" id="shipping_method" name="shipping_method" value="<?php echo htmlspecialchars($shipping['shipping_method']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="shipping_date">วันที่จัดส่ง</label>
                                            <input type="date" class="form-control" id="shipping_date" name="shipping_date" value="<?php echo htmlspecialchars($shipping['shipping_date']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tracking_number">หมายเลขติดตาม</label>
                                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="<?php echo htmlspecialchars($shipping['tracking_number']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                        <a href="../Manage/manage_shipping.php" class="btn btn-secondary">ยกเลิก</a>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>