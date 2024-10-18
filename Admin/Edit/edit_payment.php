<?php
include('../../assets/condb/condb.php');

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // ดึงข้อมูลการชำระเงินจากตาราง tb_payments
    try {
        $sql = "SELECT payment_id, order_id, payment_date, amount, payment_status, payment_method, transaction_id, receipt_image 
                FROM tb_payments 
                WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
        $stmt->execute();
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$payment) {
            echo "ไม่พบข้อมูลการชำระเงินที่เลือก";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "ไม่พบ ID การชำระเงิน";
    exit;
}

// อัปเดตข้อมูลเมื่อกดปุ่มบันทึก
if (isset($_POST['update'])) {
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];
    $payment_status = $_POST['payment_status'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];

    // จัดการอัปโหลดรูปใบเสร็จใหม่ (ถ้ามี)
    $receipt_image = $payment['receipt_image'];
    if (isset($_FILES['receipt_image']) && $_FILES['receipt_image']['error'] == 0) {
        $target_dir = "../uploads";
        $target_file = $target_dir . basename($_FILES['receipt_image']['name']);
        move_uploaded_file($_FILES['receipt_image']['tmp_name'], $target_file);
        $receipt_image = $target_file;
    }

    // อัปเดตข้อมูลในตาราง tb_payments
    try {
        $sql = "UPDATE tb_payments SET 
                payment_date = :payment_date,
                amount = :amount,
                payment_status = :payment_status,
                payment_method = :payment_method,
                transaction_id = :transaction_id,
                receipt_image = :receipt_image
                WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':payment_date', $payment_date);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->bindParam(':receipt_image', $receipt_image);
        $stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "อัปเดตข้อมูลสำเร็จ";
        header("Location: ../Manage/manage_payments.php");
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
    <title>แก้ไขการชำระเงิน</title>
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
                            <h1 class="m-0">แก้ไขการชำระเงิน</h1>
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
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="payment_date">วันที่ชำระเงิน</label>
                                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo htmlspecialchars($payment['payment_date']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">จำนวนเงิน</label>
                                            <input type="number" class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($payment['amount']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_status">สถานะการชำระเงิน</label>
                                            <select class="form-control" id="payment_status" name="payment_status" required>
                                                <option value="pending" <?php if ($payment['payment_status'] == 'pending') echo 'selected'; ?>>รอดำเนินการ</option>
                                                <option value="completed" <?php if ($payment['payment_status'] == 'completed') echo 'selected'; ?>>สำเร็จ</option>
                                                <option value="failed" <?php if ($payment['payment_status'] == 'failed') echo 'selected'; ?>>ล้มเหลว</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_method">วิธีการชำระเงิน</label>
                                            <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?php echo htmlspecialchars($payment['payment_method']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_id">รหัสธุรกรรม</label>
                                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" value="<?php echo htmlspecialchars($payment['transaction_id']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="receipt_image">ใบเสร็จ</label>
                                            <input type="file" class="form-control" id="receipt_image" name="receipt_image" accept="image/*">
                                            <?php if ($payment['receipt_image']) { ?>
                                                <img src="<?php echo htmlspecialchars($payment['receipt_image']); ?>" alt="ใบเสร็จ" width="100">
                                            <?php } ?>
                                        </div>
                                        <button type="submit" name="update" class="btn btn-primary">บันทึก</button>
                                        <a href="../Manage/manage_payments.php" class="btn btn-secondary">ยกเลิก</a>
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