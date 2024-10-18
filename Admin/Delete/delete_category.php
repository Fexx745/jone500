<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งค่า category_id หรือไม่
if (!isset($_GET['category_id'])) {
    echo "<script>alert('ไม่พบหมวดหมู่ที่ต้องการลบ!'); window.location.href='../Manage/manage_categories.php';</script>";
    exit;
}

// รับค่า category_id จาก URL
$category_id = $_GET['category_id'];

// ดึงข้อมูลหมวดหมู่ก่อนการลบ
try {
    $sql = "SELECT image FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "<script>alert('ไม่พบข้อมูลหมวดหมู่นี้!'); window.location.href='../Manage/manage_categories.php';</script>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// ลบข้อมูลหมวดหมู่จากฐานข้อมูล
try {
    // ลบข้อมูลหมวดหมู่
    $sql = "DELETE FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();

    // ลบไฟล์ภาพถ้ามี
    if (!empty($category['image']) && file_exists($category['image'])) {
        unlink($category['image']); // ลบไฟล์ภาพ
    }

    echo "<script>alert('ลบหมวดหมู่เรียบร้อย!'); window.location.href='../Manage/manage_categories.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
