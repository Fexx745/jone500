<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่าได้รับค่าพารามิเตอร์ admin_id หรือไม่
if (!isset($_GET['admin_id'])) {
    echo "<script>alert('ไม่มีรหัสผู้ดูแลระบบ'); window.location.href = '../Manage/manage_admin.php';</script>";
    exit;
}

$admin_id = $_GET['admin_id'];

// ดึงข้อมูลของผู้ดูแลระบบจากฐานข้อมูล
$sql = "SELECT * FROM tb_admin WHERE admin_id = :admin_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':admin_id', $admin_id);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<script>alert('ไม่พบข้อมูลผู้ดูแลระบบ'); window.location.href = '../Manage/manage_admin.php';</script>";
    exit;
}

// ตรวจสอบการส่งข้อมูล POST สำหรับการแก้ไข
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // ตรวจสอบข้อมูล
    if (empty($first_name) || empty($last_name) || empty($email)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit;
    }

    // สร้าง SQL สำหรับการแก้ไขข้อมูล
    if (!empty($password)) {
        // ถ้ารหัสผ่านมีการเปลี่ยนแปลงให้แก้ไขด้วย
        $sql = "UPDATE tb_admin SET first_name = :first_name, last_name = :last_name, email = :email, password = :password WHERE admin_id = :admin_id";
        $hashed_password = $password; // ไม่แฮชรหัสผ่าน
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
    } else {
        // ถ้ารหัสผ่านไม่เปลี่ยนให้ไม่รวมไว้ในคำสั่ง UPDATE
        $sql = "UPDATE tb_admin SET first_name = :first_name, last_name = :last_name, email = :email WHERE admin_id = :admin_id";
        $stmt = $conn->prepare($sql);
    }

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':admin_id', $admin_id);

    // ทำการแก้ไขข้อมูล
    if ($stmt->execute()) {
        echo "<script>alert('แก้ไขข้อมูลผู้ดูแลระบบสำเร็จ'); window.location.href = '../Manage/manage_admin.php';</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลผู้ดูแลระบบได้'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขผู้ดูแลระบบ</title>
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
                            <h1 class="m-0">แก้ไขผู้ดูแลระบบ</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="first_name">ชื่อ</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($admin['first_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">นามสกุล</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($admin['last_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">อีเมล</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">รหัสผ่าน (ถ้าต้องการเปลี่ยน)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <a href="../Manage/manage_admin.php" class="btn btn-secondary">ยกเลิก</a>
                    </form>
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