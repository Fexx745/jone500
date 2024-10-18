<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งค่า customer_id มาหรือไม่
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // ดึงข้อมูลลูกค้าจากฐานข้อมูล
    try {
        $sql = "SELECT * FROM tb_customers WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            echo "ไม่พบข้อมูลลูกค้านี้";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // อาจจะต้องการ hash รหัสผ่านถ้าจะเปลี่ยน
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $user_role = $_POST['user_role'];

    try {
        // สร้างคำสั่ง SQL สำหรับอัปเดตข้อมูลลูกค้า
        $sql = "UPDATE tb_customers 
                SET first_name = :first_name, last_name = :last_name, email = :email, 
                    password = :password, phone = :phone, address = :address, 
                    city = :city, postal_code = :postal_code, user_role = :user_role 
                WHERE customer_id = :customer_id";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // หรือใช้ hashed password
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':user_role', $user_role);
        $stmt->bindParam(':customer_id', $customer_id);

        // ดำเนินการอัปเดตข้อมูล
        $stmt->execute();

        // ถ้าสำเร็จ จะ redirect ไปที่หน้าแรกของการจัดการลูกค้า
        header('Location: ../Manage/manage_customers.php?message=แก้ไขข้อมูลลูกค้าเรียบร้อยแล้ว');
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
    <title>แก้ไขข้อมูลลูกค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../Navbar_Admin.php'; ?>

        <?php include '../Menubar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">แก้ไขข้อมูลลูกค้า</h1>
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
                                    <form action="edit_customer.php?customer_id=<?php echo $customer_id; ?>" method="POST">
                                        <div class="form-group">
                                            <label for="first_name">ชื่อ</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($customer['first_name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">นามสกุล</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($customer['last_name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">อีเมล</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">รหัสผ่าน (กรุณากรอกเฉพาะถ้าต้องการเปลี่ยน)</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">โทรศัพท์</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">ที่อยู่</label>
                                            <textarea class="form-control" id="address" name="address" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">เมือง</label>
                                            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="postal_code">รหัสไปรษณีย์</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($customer['postal_code']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_role">บทบาทผู้ใช้</label>
                                            <select class="form-control" id="user_role" name="user_role" required>
                                                <option value="user" <?php if ($customer['user_role'] == 'user') echo 'selected'; ?>>ผู้ใช้</option>
                                                <option value="admin" <?php if ($customer['user_role'] == 'admin') echo 'selected'; ?>>ผู้ดูแลระบบ</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="../Manage/manage_customers.php" class="btn btn-secondary">ยกเลิก</a>
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