<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งค่า customer_id มาหรือไม่
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    try {
        // สร้างคำสั่ง SQL สำหรับลบข้อมูลลูกค้า
        $sql = "DELETE FROM tb_customers WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        
        // ดำเนินการลบข้อมูล
        if ($stmt->execute()) {
            // ถ้าลบสำเร็จ จะ redirect ไปที่หน้าแรกของการจัดการลูกค้า
            header('Location: ../Manage/manage_customers.php?message=ลบข้อมูลลูกค้าเรียบร้อยแล้ว');
            exit;
        } else {
            echo "เกิดข้อผิดพลาดในการลบข้อมูลลูกค้า";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ไม่พบ customer_id ที่ต้องการลบ";
    exit;
}
?>
