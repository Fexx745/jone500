<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่ง product_id หรือไม่
if (!isset($_GET['product_id'])) {
    echo "ไม่พบรหัสสินค้า.";
    exit;
}

$product_id = $_GET['product_id'];

// ดึงข้อมูลสินค้าจากฐานข้อมูล
try {
    $sql = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "ไม่พบข้อมูลสินค้านี้.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// อัปเดตข้อมูลเมื่อส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $product_name = $_POST['product_name'];
    $product_detail = $_POST['product_detail'];
    $price = $_POST['price'];
    $stockQty = $_POST['stockQty'];
    $size = $_POST['size'];
    $category_id = $_POST['category_id'];

    // ตรวจสอบและจัดการไฟล์รูปภาพ
    $target_dir = "../uploads"; // โฟลเดอร์สำหรับเก็บรูปภาพ
    $uploadOk = 1;

    // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
    if (!empty($_FILES["image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // ตรวจสอบว่ารูปภาพเป็นไฟล์จริงหรือไม่
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }

        // ตรวจสอบขนาดไฟล์ (สูงสุด 2MB)
        if ($_FILES["image"]["size"] > 2000000) {
            echo "ขอโทษครับ รูปภาพของคุณใหญ่เกินไป.";
            $uploadOk = 0;
        }

        // ตรวจสอบนามสกุลไฟล์
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "ขอโทษครับ เราเพียงรับไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
            $uploadOk = 0;
        }

        // ตรวจสอบว่ามีปัญหาในการอัปโหลดไฟล์
        if ($uploadOk == 0) {
            echo "ขอโทษครับ ไม่สามารถอัปโหลดรูปภาพได้.";
        } else {
            // พยายามอัปโหลดไฟล์
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.";
            }
        }
    } else {
        // ถ้าไม่มีการอัปโหลดไฟล์ใหม่ ให้ใช้รูปภาพเดิม
        $target_file = $product['image'];
    }

    // อัปเดตข้อมูลสินค้าในฐานข้อมูล
    try {
        $sql = "UPDATE products SET product_name = :product_name, product_detail = :product_detail, price = :price, 
                stockQty = :stockQty, size = :size, category_id = :category_id, image = :image WHERE product_id = :product_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_detail', $product_detail);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stockQty', $stockQty);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $target_file);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            echo "แก้ไขข้อมูลสินค้าสำเร็จ!";
            header("Location: ../Manage/manage_products.php"); // เปลี่ยนเส้นทางกลับไปยังหน้า Manage
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขสินค้า.";
        }
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
    <title>แก้ไขสินค้า</title>
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
                            <h1 class="m-0">แก้ไขสินค้า</h1>
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
                                    <form action="edit_product.php?product_id=<?php echo htmlspecialchars($product_id); ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="product_name">ชื่อสินค้า</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_detail">รายละเอียดสินค้า</label>
                                            <textarea class="form-control" id="product_detail" name="product_detail" required><?php echo htmlspecialchars($product['product_detail']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">ราคา</label>
                                            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="stockQty">จำนวนสินค้า</label>
                                            <input type="number" class="form-control" id="stockQty" name="stockQty" value="<?php echo htmlspecialchars($product['stockQty']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="size">ขนาด</label>
                                            <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">หมวดหมู่</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <?php
                                                // ดึงข้อมูลหมวดหมู่เพื่อแสดงใน select
                                                try {
                                                    $sql = "SELECT category_id, category_name FROM categories";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();
                                                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($categories as $category) {
                                                        $selected = ($category['category_id'] == $product['category_id']) ? 'selected' : '';
                                                        echo "<option value='" . htmlspecialchars($category['category_id']) . "' $selected>" . htmlspecialchars($category['category_name']) . "</option>";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Error: " . $e->getMessage();
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">รูปภาพ (ถ้าต้องการเปลี่ยน)</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <img src="../../assets/imge/product/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" width="100" class="mt-2">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">กลับ</button>
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