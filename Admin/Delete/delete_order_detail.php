<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่ง order_detail_id หรือไม่
if (isset($_GET['order_detail_id'])) {
    $order_detail_id = $_GET['order_detail_id'];

    // ลบข้อมูลจาก tb_order_details
    try {
        $sql = "DELETE FROM tb_order_details WHERE order_detail_id = :order_detail_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_detail_id', $order_detail_id);
        $stmt->execute();

        // เปลี่ยนเส้นทางกลับไปยังหน้าจัดการรายละเอียดคำสั่งซื้อ
        header("Location: ../Manage/manage_order_details.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    // ถ้าไม่มี order_detail_id ให้กลับไปยังหน้าจัดการรายละเอียดคำสั่งซื้อ
    header("Location: ../Manage/manage_order_details.php");
    exit;
}
?>
