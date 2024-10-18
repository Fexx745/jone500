<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่ง order_detail_id หรือไม่
if (isset($_GET['order_detail_id'])) {
    $order_detail_id = $_GET['order_detail_id'];

    // ดึงข้อมูลจาก tb_order_details
    try {
        $sql = "SELECT od.order_detail_id, od.order_id, od.product_id, od.quantity, od.price, o.order_date, o.order_status
                FROM tb_order_details od
                JOIN tb_orders o ON od.order_id = o.order_id
                JOIN products p ON od.product_id = p.product_id
                WHERE od.order_detail_id = :order_detail_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_detail_id', $order_detail_id);
        $stmt->execute();
        $orderDetail = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    header("Location: ../Manage/manage_order_details.php"); // เปลี่ยนเส้นทางหากไม่มี order_detail_id
    exit;
}

// ดำเนินการเมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // อัปเดตข้อมูลใน tb_order_details
    try {
        $sql = "UPDATE tb_order_details SET order_id = :order_id, product_id = :product_id, quantity = :quantity, price = :price WHERE order_detail_id = :order_detail_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':order_detail_id', $order_detail_id);
        $stmt->execute();

        // เปลี่ยนเส้นทางกลับไปยังหน้าจัดการรายละเอียดคำสั่งซื้อ
        header("Location: ../Manage/manage_order_details.php?success=1");
        exit;
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
    <title>แก้ไขรายละเอียดคำสั่งซื้อ</title>
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
                            <h1 class="m-0">แก้ไขรายละเอียดคำสั่งซื้อ</h1>
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
                                            <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo htmlspecialchars($orderDetail['order_id']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_id">รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="product_id" name="product_id" value="<?php echo htmlspecialchars($orderDetail['product_id']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">จำนวน</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($orderDetail['quantity']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">ราคา</label>
                                            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($orderDetail['price']); ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">ยกเลิก</button>
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
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