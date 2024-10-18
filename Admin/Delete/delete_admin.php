<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่าได้รับค่าพารามิเตอร์ admin_id หรือไม่
if (!isset($_GET['admin_id'])) {
    echo "<script>alert('ไม่มีรหัสผู้ดูแลระบบ'); window.location.href = '../Manage/manage_admin.php';</script>";
    exit;
}

$admin_id = $_GET['admin_id'];

// สร้าง SQL สำหรับการลบข้อมูล
$sql = "DELETE FROM tb_admin WHERE admin_id = :admin_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':admin_id', $admin_id);

try {
    // ทำการลบข้อมูล
    if ($stmt->execute()) {
        echo "<script>alert('ลบผู้ดูแลระบบสำเร็จ'); window.location.href = '../Manage/manage_admin.php';</script>";
    } else {
        echo "<script>alert('ไม่สามารถลบผู้ดูแลระบบได้'); window.history.back();</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
