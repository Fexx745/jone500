<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่ง product_id หรือไม่
if (!isset($_GET['product_id'])) {
    echo "ไม่พบรหัสสินค้า.";
    exit;
}

$product_id = $_GET['product_id'];

// ลบสินค้าจากฐานข้อมูล
try {
    // ดึงข้อมูลรูปภาพเพื่อทำการลบไฟล์ (ถ้ามี)
    $sql = "SELECT image FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // ลบข้อมูลในฐานข้อมูล
        $sql = "DELETE FROM products WHERE product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            // ลบไฟล์รูปภาพถ้ามี
            if (!empty($product['image']) && file_exists($product['image'])) {
                unlink($product['image']);
            }
            echo "ลบข้อมูลสินค้าสำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการลบสินค้า.";
        }
    } else {
        echo "ไม่พบข้อมูลสินค้านี้.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// เปลี่ยนเส้นทางกลับไปยังหน้าจัดการสินค้า
header("Location: ../Manage/manage_products.php");
exit();
?>
