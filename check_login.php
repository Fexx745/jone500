<?php
// เริ่มต้น session
session_start();

// นำเข้าไฟล์การเชื่อมต่อฐานข้อมูล
include_once 'assets/condb/condb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าอีเมลและรหัสผ่านจากฟอร์ม
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลการเข้าสู่ระบบ
    $query = "SELECT * FROM tb_customers WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // ตรวจสอบว่าพบผู้ใช้หรือไม่
    if ($stmt->rowCount() > 0) {
        // ดึงข้อมูลผู้ใช้
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            // บันทึกข้อมูลส่วนตัวใน session
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];  // แก้ไขการพิมพ์ผิดจาก 'fist_name'
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_role'] = $user['user_role'];    // สามารถบันทึก role หรือข้อมูลอื่นๆ ที่จำเป็น

            // แสดง alert และนำไปหน้า index.php
            echo "<script>
                    alert('Login successful!');
                    window.location.href='index.php';
                  </script>";
        } else {
            // รหัสผ่านไม่ถูกต้อง
            echo "<script>
                    alert('Incorrect email or password.');
                    window.location.href='login.php';
                  </script>";
        }
    } else {
        // ไม่พบอีเมลนี้ในฐานข้อมูล
        echo "<script>
                alert('Email not found.');
                window.location.href='login.php';
              </script>";
    }
}
?>
