<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // ตรวจสอบข้อมูล
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
        exit;
    }

    // สร้าง SQL สำหรับการเพิ่มข้อมูล
    $sql = "INSERT INTO tb_admin (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // ไม่ทำการแฮชรหัสผ่าน

        // ทำการเพิ่มข้อมูล
        if ($stmt->execute()) {
            echo "<script>alert('เพิ่มผู้ดูแลระบบสำเร็จ'); window.location.href = '../Manage/manage_admin.php';</script>";
        } else {
            echo "<script>alert('ไม่สามารถเพิ่มผู้ดูแลระบบได้'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
