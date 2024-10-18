<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if (isset($_GET['shipping_id'])) {
    $shipping_id = $_GET['shipping_id'];

    try {
        // ลบข้อมูลจากตาราง shipping ตาม shipping_id
        $sql = "DELETE FROM shipping WHERE shipping_id = :shipping_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':shipping_id', $shipping_id);

        if ($stmt->execute()) {
            echo "<script>alert('ลบข้อมูลการจัดส่งเรียบร้อย!'); window.location.href = '../Manage/manage_shipping.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล!'); history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<script>alert('ไม่พบ shipping_id!'); window.location.href = '../Manage/manage_shipping.php';</script>";
}
?>
