<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งค่า category_id หรือไม่
if (!isset($_GET['category_id'])) {
    echo "<script>alert('ไม่พบหมวดหมู่ที่ต้องการแก้ไข!'); window.location.href='manage_categories.php';</script>";
    exit;
}

// รับค่า category_id จาก URL
$category_id = $_GET['category_id'];

// ดึงข้อมูลหมวดหมู่จากฐานข้อมูล
try {
    $sql = "SELECT category_name, image FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "<script>alert('ไม่พบข้อมูลหมวดหมู่นี้!'); window.location.href='manage_categories.php';</script>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// การจัดการการอัปโหลดรูปภาพและการแก้ไขข้อมูล
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $image_path = $category['image']; // ใช้ภาพเก่าหากไม่มีการอัปโหลดใหม่

    // จัดการกับการอัปโหลดรูปภาพ
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = uniqid() . '_' . basename($image['name']);
        $target_directory = '../uploads'; // เปลี่ยนเส้นทางให้ถูกต้อง
        $target_file = $target_directory . $image_name;

        // ตรวจสอบประเภทไฟล์
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($image_file_type, $allowed_types)) {
            // อัปโหลดไฟล์
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $image_path = $target_file; // อัปเดตให้ใช้ภาพใหม่
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('ประเภทไฟล์ไม่ถูกต้อง!'); window.history.back();</script>";
            exit;
        }
    }

    // อัปเดตข้อมูลหมวดหมู่ในฐานข้อมูล
    try {
        $sql = "UPDATE categories SET category_name = :category_name, image = :image WHERE category_id = :category_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        echo "<script>alert('แก้ไขหมวดหมู่เรียบร้อย!'); window.location.href='../Manage/manage_categories.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขหมวดหมู่</title>
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
                            <h1 class="m-0">แก้ไขหมวดหมู่</h1>
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
                                            <label for="category_name">ชื่อหมวดหมู่</label>
                                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">รูปภาพ</label><br>
                                            <img src="../../assets/imge/category/<?php echo htmlspecialchars($category['image']); ?>" alt="Current Image" style="max-width: 200px; display: block; margin-bottom: 10px;">
                                            <input type="file" class="form-control" id="image" name="image">
                                            <small>กรุณาเลือกไฟล์รูปภาพใหม่ หากต้องการเปลี่ยน</small>
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