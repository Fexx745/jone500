<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่ง order_id มาหรือไม่
if (!isset($_GET['order_id'])) {
    echo "ไม่มีรหัสคำสั่งซื้อที่ต้องการลบ";
    exit;
}

// รับค่า order_id จาก URL
$order_id = $_GET['order_id'];

// ลบข้อมูลคำสั่งซื้อจากฐานข้อมูล
try {
    $sql = "DELETE FROM tb_orders WHERE order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    // ถ้ามีการลบสำเร็จ
    echo "<script>alert('ลบคำสั่งซื้อสำเร็จ!'); window.location.href='../Manage/manage_orders.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
