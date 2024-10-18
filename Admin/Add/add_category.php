<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $category_name = $_POST['category_name'];
    
    // จัดการกับการอัปโหลดรูปภาพ
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = uniqid() . '_' . basename($image['name']); // สร้างชื่อไฟล์ที่ไม่ซ้ำ
        $target_directory = '../../assets/imge/category/'; // เปลี่ยนเส้นทางให้ถูกต้อง
        $target_file = $target_directory . $image_name;

        // ตรวจสอบประเภทไฟล์
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($image_file_type, $allowed_types)) {
            // อัปโหลดไฟล์
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // บันทึกข้อมูลในฐานข้อมูล
                try {
                    $sql = "INSERT INTO categories (category_name, image) VALUES (:category_name, :image)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':category_name', $category_name);
                    $stmt->bindParam(':image', $target_file);
                    $stmt->execute();

                    echo "<script>alert('เพิ่มหมวดหมู่เรียบร้อย!'); window.location.href='../Manage/manage_categories.php';</script>";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('ประเภทไฟล์ไม่ถูกต้อง!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('กรุณาเลือกไฟล์รูปภาพ!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('เข้าถึงหน้านี้ไม่ถูกต้อง!'); window.history.back();</script>";
}
?>
